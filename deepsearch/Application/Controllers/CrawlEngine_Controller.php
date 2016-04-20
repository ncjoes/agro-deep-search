<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/15/2016
 * Time:    10:10 PM
 **/


namespace Application\Controllers;


use _Libraries\PHPCrawl\Enums\PHPCrawlerAbortReasons;
use _Libraries\PHPCrawl\Enums\PHPCrawlerUrlCacheTypes;
use Application\Models\Crawl;
use Application\Models\CrawlSetting;
use Application\Utilities\FrontierManager;
use System\Models\DomainObjectWatcher;
use System\Request\RequestContext;
use Application\Utilities\DeepCrawler;
use System\Utilities\DateTime;

class CrawlEngine_Controller extends A_Controller
{
    public function doExecute(RequestContext $requestContext)
    {
        $data = array();
        $fields = array();
        $fields['val'] = array();
        $cs_mapper = CrawlSetting::getMapper('CrawlSetting');

        $crawl_settings_objects = $cs_mapper->findAll();
        foreach ($crawl_settings_objects as $crawl_setting_object)
        {
            $fields['val'][$crawl_setting_object->getVarName()] = $crawl_setting_object->getCurrentValue();
        }

        $data['fields'] = $fields;
        $data['page-title'] = "Run Web Crawl";
        $requestContext->setResponseData($data);
        $requestContext->setView('crawl-engine/index.php');
    }

    protected function CrawlSettings(RequestContext $requestContext)
    {
        $data = array();
        $fields = array();
        $fields['val'] = array();
        $cs_mapper = CrawlSetting::getMapper('CrawlSetting');
        
        $crawl_settings_objects = $cs_mapper->findAll();
        foreach ($crawl_settings_objects as $crawl_setting_object)
        {
            $fields['val'][$crawl_setting_object->getVarName()] = $crawl_setting_object->getCurrentValue();
        }

        if($requestContext->fieldIsSet('save-changes', INPUT_POST))
        {
            $fields = array_merge($fields, $requestContext->getAllFields(INPUT_POST));
            foreach ($fields['val'] as $var_name => $value)
            {
                $setting = $cs_mapper->findByVarName($var_name);
                $setting = is_object($setting) ? $setting : new CrawlSetting();
                $setting->setVarName($var_name)->setCurrentValue($value);
                if(! strlen($setting->getDefaultValue())) $setting->setDefaultValue($value);
            }
        }

        if($requestContext->fieldIsSet('reset-all', INPUT_POST))
        {
            foreach ($crawl_settings_objects as $crawl_setting_object)
            {
                $crawl_setting_object->setCurrentValue($crawl_setting_object->getDefaultValue());
                $fields['val'][$crawl_setting_object->getVarName()] = $crawl_setting_object->getCurrentValue();
            }
        }

        $data['fields'] = $fields;
        $data['page-title'] = "Default Crawl Settings";
        $requestContext->setView('crawl-engine/crawl-settings.php');
        $requestContext->setResponseData($data);
    }

    protected function RunCrawl(RequestContext $requestContext)
    {
        if($requestContext->fieldIsSet('run-craw', INPUT_POST))
        {
            $fields = $requestContext->getAllFields(INPUT_POST);

            set_time_limit($fields['max-run-time'] * 60);

            //Instantiate and setup Crawler Object
            $crawler = new DeepCrawler();
            foreach ($fields['val'] as $method => $value)
            {
                if( method_exists($crawler, $method) and is_callable( array($crawler, $method ) ))
                {
                    $crawler->$method($value);
                }else{
                    throw new \Exception("Method ".get_class($crawler)."::".$method." does not exist");
                }
            }
            $crawler->setURL($fields['val']['setURL']);
            if((int)$fields['url-option'] == 1){ $crawler->setURL(FrontierManager::instance()->getMostRelevantLink()); }
            $crawler->setUserAgentString(site_info('name',false)." [".home_url('',false)."]");
            $crawler->setUrlCacheType(PHPCrawlerUrlCacheTypes::URLCACHE_SQLITE);
            $crawler->setCrawlingDepthLimit(10);
            $crawler->enableResumption();

            //Instantiate and setup Crawl object to record crawl-history
            $crawl = new Crawl();
            $crawl->setCrawlerId($crawler->getCrawlerId());
            $crawl->setStartTime(new DateTime());
            $crawl->setStatus(Crawl::STATUS_ONGOING);

            DomainObjectWatcher::instance()->performOperations();

            //Run Crawler
            $crawler->go();
            $report = $crawler->getProcessReport();

            //Update Crawl Record
            $crawl->setEndTime(new DateTime());
            switch ($report->abort_reason)
            {
                case PHPCrawlerAbortReasons::ABORTREASON_PASSEDTHROUGH : $crawl->setStatus(Crawl::STATUS_COMPLETE); break;
                case PHPCrawlerAbortReasons::ABORTREASON_USERABORT :
                case PHPCrawlerAbortReasons::ABORTREASON_TRAFFICLIMIT_REACHED :
                case PHPCrawlerAbortReasons::ABORTREASON_FILELIMIT_REACHED : $crawl->setStatus(Crawl::STATUS_TERMINATED); break;
            }

            //Crawl Process Summary
            print_r("<hr/>");
            if (PHP_SAPI == "cli") $lb = "\n";
            else $lb = "<br />";
            echo "Summary:".$lb;
            echo "Links followed: ".$report->links_followed.$lb;
            echo "Documents received: ".$report->files_received.$lb;
            echo "Bytes received: ".$report->bytes_received." bytes".$lb;
            echo "Process runtime: ".$report->process_runtime." sec".$lb;
            echo "Reason for Termination: ".$report->abort_reason." ".$lb;
        }
    }
}