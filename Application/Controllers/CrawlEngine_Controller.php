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
use _Libraries\PHPCrawl\Enums\PHPCrawlerLinkSearchDocumentSections;
use _Libraries\PHPCrawl\Enums\PHPCrawlerUrlCacheTypes;
use Application\Models\Crawl;
use Application\Models\CrawlSetting;
use Application\Models\Link;
use Application\Utilities\A_Utility;
use Application\Utilities\FrontierManager;
use Application\Models\UserPrivilege;
use System\Models\DomainObjectWatcher;
use System\Request\RequestContext;
use Application\Utilities\DS_PHPCrawler;
use System\Utilities\DateTime;

class CrawlEngine_Controller extends A_AdministrativeCommands_Controller
{
    public function execute(RequestContext $requestContext)
    {
        $private_key = "k25sFdr85i-kafgFdhsdkl-JJdfgFGDFhftdhFDRs";
        $user_key = $requestContext->fieldIsSet('key', INPUT_GET) ? $requestContext->getField('key', INPUT_GET) : null;
        $auto_mode = $requestContext->fieldIsSet('auto-crawl', INPUT_GET) ? $requestContext->getField('auto-crawl', INPUT_GET) : null;

        /*
         * To run automatic crawls through cron-jobs
         * make this request
         * http://nwubanfarms.com/crawl-engine/run-crawl/?auto-crawl=1&key=k25sFdr85i-kafgFdhsdkl-JJdfgFGDFhftdhFDRs
         */
        if(($auto_mode == 1 and $user_key == $private_key) OR $this->securityPass($requestContext, UserPrivilege::UT_ADMIN, 'crawl-engine'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data = array();
        $fields = array();
        $fields['val'] = array();
        $crawl_settings_objects = CrawlSetting::getMapper('CrawlSetting')->findAll();

        foreach ($crawl_settings_objects as $crawl_setting_object)
        {
            $value = $crawl_setting_object->getCurrentValue();
            $value = $crawl_setting_object->isMultivalued() ? explode('|', $value) : $value;
            $fields['val'][$crawl_setting_object->getVarName()] = $value;
        }

        $data['fields'] = $fields;
        $data['sid'] = $requestContext->getSession()->getId();
        $data['page-title'] = "Run Web Crawl";
        $requestContext->setResponseData($data);
        $requestContext->setView('crawl-engine/index.php');
    }

    protected function DefaultCrawlSettings(RequestContext $requestContext)
    {
        $data = array();
        $fields = array();
        $fields['val'] = array();
        $cs_mapper = CrawlSetting::getMapper('CrawlSetting');
        
        if($requestContext->fieldIsSet('save-changes', INPUT_POST))
        {
            $fields = $requestContext->getAllFields(INPUT_POST);
            foreach ($fields['val'] as $var_name => $value)
            {
                $setting = $cs_mapper->findByVarName($var_name);
                $setting = is_object($setting) ? $setting : new CrawlSetting();
                $setting->setVarName($var_name)->setCurrentValue(is_array($value) ? implode('|',$value) : $value);
                if(is_array($value)) $setting->setMultiValued(true);
                if(! is_null($setting->getDefaultValue())) $setting->setDefaultValue($setting->getCurrentValue());
            }
            $requestContext->setFlashData("Default Crawler Configurations Saved Successfully");
            $data['status'] = true;
        }

        $crawl_settings_objects = $cs_mapper->findAll();
        if($requestContext->fieldIsSet('reset-all', INPUT_POST))
        {
            foreach ($crawl_settings_objects as $crawl_setting_object)
            {
                $crawl_setting_object->setCurrentValue($crawl_setting_object->getDefaultValue());
            }
            $requestContext->setFlashData("All Crawler Configurations Reset to Factory Defaults");
            $data['status'] = true;
        }

        foreach ($crawl_settings_objects as $crawl_setting_object)
        {
            $value = $crawl_setting_object->getCurrentValue();
            $value = $crawl_setting_object->isMultivalued() ? explode('|', $value) : $value;
            $fields['val'][$crawl_setting_object->getVarName()] = $value;
        }

        $data['fields'] = $fields;
        $data['page-title'] = "Default Crawl Settings";
        $requestContext->setView('crawl-engine/crawl-settings.php');
        $requestContext->setResponseData($data);
    }

    protected function RunCrawl(RequestContext $requestContext)
    {
        $requestContext->setView('_includes/_empty.php');
        $auto_crawl_mode = $requestContext->fieldIsSet('auto-crawl', INPUT_GET);

        if(! $auto_crawl_mode)
        {
            echo "<html>";
            echo "<header>";
            echo "<style type='text/css'>";
            echo "body{font-size:10px; font-family:Gadugi; background-color:black; color:white;}";
            echo "</style>";
            echo "</header>";
            echo "<body>";
        }

        try
        {
            if($auto_crawl_mode == true or $requestContext->fieldIsSet('crawl-process-starter', INPUT_POST))
            {
                $fields = $auto_crawl_mode ? array('url-option'=>1,'max-run-time'=>30)
                    : $requestContext->getAllFields(INPUT_POST);

                //get default crawl-settings
                $default_settings = array();
                $crawl_settings_objects = CrawlSetting::getMapper('CrawlSetting')->findAll();
                foreach ($crawl_settings_objects as $crawl_setting_object)
                {
                    $value = $crawl_setting_object->getCurrentValue();
                    $value = $crawl_setting_object->isMultivalued() ? explode('|', $value) : $value;
                    $default_settings[$crawl_setting_object->getVarName()] = $value;
                    if($auto_crawl_mode) $fields['val'][$crawl_setting_object->getVarName()] = $value;
                }

                //Instantiate and setup Crawler Object
                $fields['val']['setURL'] = isset($fields['val']['setURL']) ? $fields['val']['setURL'] : null;
                if($fields['url-option'] == 1)
                {
                    $MRL = FrontierManager::instance()->getMostRelevantLink();
                    if($MRL !="" and !is_null($MRL)) $fields['val']['setURL'] = $MRL;
                }

                if(! is_null($fields['val']['setURL']))
                {

                    $fields['val']['setURL'] = A_Utility::trimUrl($fields['val']['setURL']);
                    $crawler = new DS_PHPCrawler();

                    //Setup Crawler
                    foreach ($fields['val'] as $method => $value)
                    {
                        if( method_exists($crawler, $method) and is_callable( array($crawler, $method ) ))
                        {
                            switch ($method)
                            {
                                case 'addContentTypeReceiveRule' :
                                {
                                    if(!is_array($value) or !sizeof($value))
                                        $value = $default_settings[$method];
                                    foreach ($value as $rule) { $crawler->addContentTypeReceiveRule($rule); }
                                } break;
                                case 'addURLFollowRule' :
                                {
                                    if(!is_array($value) or !sizeof($value))
                                        $value = $default_settings[$method];
                                    $crawler->addURLFollowRule("#(".implode("|", $value).")$# i");
                                } break;
                                case 'addURLFilterRule' :
                                {
                                    if(!is_array($value) or !sizeof($value))
                                        $value = $default_settings[$method];
                                    $crawler->addURLFilterRule("#(".implode("|", $value).")$# i");
                                } break;
                                case 'setLinkExtractionTags' :
                                {
                                    if (!is_array($value) or sizeof($value)) $value = $default_settings[$method];
                                    $crawler->setLinkExtractionTags($value);
                                } break;
                                default : $crawler->$method($value);
                            }
                        }else{
                            throw new \Exception("Method ".get_class($crawler)."::".$method." does not exist");
                        }
                    }
                    $crawler->setUserAgentString($_SERVER['HTTP_USER_AGENT']);
                    $crawler->setUrlCacheType(PHPCrawlerUrlCacheTypes::URLCACHE_SQLITE);
                    $crawler->setRequestDelay(0.5);
                    $crawler->excludeLinkSearchDocumentSections(
                        PHPCrawlerLinkSearchDocumentSections::SCRIPT_SECTIONS |
                        PHPCrawlerLinkSearchDocumentSections::HTML_COMMENT_SECTIONS);
                    $crawler->enableResumption();

                    //Check records for url
                    $link = $crawler->findLinkObj($fields['val']['setURL']);
                    $link->setUrl($fields['val']['setURL']);
                    $link->setStatus(Link::STATUS_UNVISITED);
                    ($link->getId() == Link::DEFAULT_ID) ? $link->mapper()->insert($link) : $link->mapper()->update($link); //where -1 is default DO-Id

                    //Instantiate and setup Crawl object to record crawl-history
                    $crawl = new Crawl();
                    $crawl->setCrawlerId($crawler->getCrawlerId());
                    $crawl->setSessionId(! $auto_crawl_mode ? $requestContext->getSession()->getId(): NULL);
                    $crawl->setStartUrl($link);
                    $crawl->setStartTime(new DateTime());
                    $crawl->setStatus(Crawl::STATUS_ONGOING);
                    $crawl->mapper()->insert($crawl);

                    //Run Crawler
                    set_time_limit($fields['max-run-time'] * 60);
                    $lb = $auto_crawl_mode ? '\n\r' : "<br />";
                    $out = "<p>";
                    $out .= "<b>Crawl Started ...</b>".$lb;
                    $out .= "Start-URL: ".$fields['val']['setURL'].$lb;
                    $out .= "Crawler-ID: ".$crawler->getCrawlerId().$lb;
                    $out .= "Start Time: ".date("F d, Y / g:i:s A");
                    $out .= "</p>";
                    $out .= "<hr/>";
                    echo ($auto_crawl_mode ? strip_tags($out) : $out);
                    $crawler->go();

                    //Obtain process report
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
                    $out = "<hr/>";
                    $out .= "<p>";
                    $out .= "<b>Summary</b>".$lb;
                    $out .= "Links followed: ".$report->links_followed.$lb;
                    $out .= "Documents received: ".$report->files_received.$lb;
                    $out .= "Data-size received: ~".get_file_size_unit($report->bytes_received).$lb;
                    $out .= "Stop Time: ".date("F d, Y / g:i:s A").$lb;
                    $out .= "Process runtime: ".seconds_to_str($report->process_runtime).$lb;
                    $out .= "Process Abort Reason: ".$report->abort_reason." ".$lb;
                    $out .= "</p>";
                    echo ($auto_crawl_mode ? strip_tags($out) : $out);

                    //wrap-up process
                    DomainObjectWatcher::instance()->performOperations();
                    flush();
                }
                else {
                    throw new \Exception("No Starting URL");
                }
            }
            else {
                throw new \Exception("Invalid Request");
            }
        }
        catch (\Exception $e)
        {
            $sid = $requestContext->getSession()->getId();
            $possibly_terminated_crawls = Crawl::getMapper('Crawl')->findBySessionId( $sid, Crawl::STATUS_ONGOING );

            if(is_object($possibly_terminated_crawls))
            {
                foreach ($possibly_terminated_crawls as $terminated_crawl)
                {
                    $terminated_crawl->setEndTime(new DateTime());
                    $terminated_crawl->setStatus(Crawl::STATUS_TERMINATED);
                    $terminated_crawl->mapper()->update($terminated_crawl);
                }
            }

            echo $e->getMessage()."<hr/>";
            if(site_info('development-mode',false)==true) echo getExceptionTraceString($e);
            exit;
        }

        if(! $auto_crawl_mode)
        {
            echo "</body>";
            echo "</html>";
        }
    }

    protected function CrawlProgressInfo(RequestContext $requestContext)
    {
        $data = array();
        $data['status'] = -1;
        $data['current-crawl'] = null;

        try{
            $sid = $requestContext->fieldIsSet('sid', INPUT_GET) ? $requestContext->getField('sid', INPUT_GET) : null;
            $cid = $requestContext->fieldIsSet('cid', INPUT_GET) ? $requestContext->getField('cid', INPUT_GET) : null;

            $crawl = null;
            $_by_cid = Crawl::getMapper('Crawl')->find( $cid );
            $_by_sid = Crawl::getMapper('Crawl')->findBySessionId( $sid );
            $crawl = is_object($_by_sid) ? $_by_sid->current() : $crawl;
            $crawl = is_object($_by_cid) ? $_by_cid : $crawl;

            if(is_object($crawl))
            {
                //if($cid != null) echo "yes";
                $data['current-crawl'] = $crawl;
                $crawl->getStartUrl()->getId();
                $data['cid'] = $crawl->getId();
                $data['status'] = $crawl->getStatus();
            }
        }catch (\Exception $e){
            $data['status'] = 0;
            $data['cid'] = -1;
            $requestContext->setFlashData($e->getMessage());
        }

        $requestContext->setResponseData($data);
        $requestContext->setView('crawl-engine/_active-crawls-progress-info.php');
    }

    protected function StopCrawlProgress(RequestContext $requestContext)
    {
        try {
            $cid = $requestContext->fieldIsSet('cid', INPUT_GET) ? $requestContext->getField('cid', INPUT_GET) : null;
            $crawl = Crawl::getMapper('Crawl')->find( $cid );

            if(is_object($crawl))
            {
                $crawl->SetStatus(Crawl::STATUS_TERMINATED);
                $crawl->mapper()->update($crawl);
                echo '+';
            }
            else echo '-';
        } catch (\Exception $e) {
            echo '-';
        }
        $requestContext->setView('_includes/_empty.php');
    }
}