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
use Application\Utilities\FrontierManager;
use System\Models\DomainObjectWatcher;
use System\Request\RequestContext;
use Application\Utilities\DS_PHPCrawler;
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
            $requestContext->setFlashData("Default Crawler Configurations Saved Successfully");
            $data['status'] = true;
        }

        if($requestContext->fieldIsSet('reset-all', INPUT_POST))
        {
            foreach ($crawl_settings_objects as $crawl_setting_object)
            {
                $crawl_setting_object->setCurrentValue($crawl_setting_object->getDefaultValue());
                $fields['val'][$crawl_setting_object->getVarName()] = $crawl_setting_object->getCurrentValue();
            }
            $requestContext->setFlashData("All Crawler Configurations Reset to Factory Defaults");
            $data['status'] = true;
        }

        $data['fields'] = $fields;
        $data['page-title'] = "Default Crawl Settings";
        $requestContext->setView('crawl-engine/crawl-settings.php');
        $requestContext->setResponseData($data);
    }

    protected function RunCrawl(RequestContext $requestContext)
    {
        $requestContext->setView('_includes/_empty.php');
        echo "<html>";
        echo "<header>";
        echo "<style type='text/css'>";
        echo "body{font-size:10px; font-family:Gadugi; background-color:black; color:white;}";
        echo "</style>";
        echo "</header>";
        echo "<body>";

        try
        {
            if($requestContext->fieldIsSet('crawl-process-starter', INPUT_POST))
            {
                $fields = $requestContext->getAllFields(INPUT_POST);

                //Instantiate and setup Crawler Object
                $crawler = new DS_PHPCrawler();
                foreach ($fields['val'] as $method => $value)
                {
                    if( method_exists($crawler, $method) and is_callable( array($crawler, $method ) ))
                    {
                        switch ($method)
                        {
                            case 'addContentTypeReceiveRule' :
                            {
                                if(!is_array($value) or !sizeof($value))
                                    $value = array("#text/html#", "#text/css#", "#text/javascript#", "#image/gif#", "#image/png#", "#image/jpeg#");
                                foreach ($value as $rule) { $crawler->addContentTypeReceiveRule($rule); }
                            } break;
                            case 'addURLFollowRule' :
                            {
                                if(!is_array($value) or !sizeof($value))
                                    $value = array('html', 'htm', 'php', 'php3', 'php4', 'php5', 'asp', 'aspx', 'jsp');
                                $crawler->addURLFollowRule("#(".implode("|", $value).")$# i");
                            } break;
                            case 'addURLFilterRule' :
                            {
                                if(!is_array($value) or !sizeof($value))
                                    $value = array('jpg', 'png', 'gif', 'css', 'js', 'pdf', 'exe', 'apk', 'm4a', 'mp4');
                                $crawler->addURLFilterRule("#\.(".implode('|', $value).")$# i");
                            } break;
                            case 'setLinkExtractionTags' :
                            {
                                if (!is_array($value) or sizeof($value)) $value = array('href');
                                $crawler->setLinkExtractionTags($value);
                            } break;
                            default : $crawler->$method(trim($value));
                        }
                    }else{
                        throw new \Exception("Method ".get_class($crawler)."::".$method." does not exist");
                    }
                }
                $start_url = $fields['val']['setURL'];
                if((int)$fields['url-option'] == 1)
                {
                    $MRL = trim(FrontierManager::instance()->getMostRelevantLink());
                    if($MRL !="" and strlen($MRL)) $start_url = $MRL;
                }
                $start_url = trim($start_url, " \t\n\r\v\\");
                $crawler->setURL($start_url);
                $crawler->setUserAgentString($_SERVER['HTTP_USER_AGENT']);
                $crawler->setUrlCacheType(PHPCrawlerUrlCacheTypes::URLCACHE_SQLITE);
                $crawler->setRequestDelay(0.2);
                $crawler->excludeLinkSearchDocumentSections(
                    PHPCrawlerLinkSearchDocumentSections::SCRIPT_SECTIONS |
                    PHPCrawlerLinkSearchDocumentSections::HTML_COMMENT_SECTIONS);
                $crawler->enableResumption();

                //Check records for url
                $link = Link::getMapper("Link")->findByUrlHash(md5($start_url));
                $link = is_object($link) ? $link : new Link();
                $link->setUrl($start_url);
                $link->setStatus(Link::STATUS_UNVISITED);
                ($link->getId() == Link::DEFAULT_ID) ? $link->mapper()->insert($link) : $link->mapper()->update($link); //where -1 is default DO-Id

                //Instantiate and setup Crawl object to record crawl-history
                $crawl = new Crawl();
                $crawl->setCrawlerId($crawler->getCrawlerId());
                $crawl->setSessionId($requestContext->getSession()->getId());
                $crawl->setStartUrl($link);
                $crawl->setStartTime(new DateTime());
                $crawl->setStatus(Crawl::STATUS_ONGOING);
                $crawl->mapper()->insert($crawl);

                //Run Crawler
                set_time_limit($fields['max-run-time'] * 60);
                $lb = "<br />";
                echo "<p>";
                echo "<b>Crawl Started ...</b>".$lb;
                echo "URL: ".$start_url.$lb;
                echo "Crawler-ID: ".$crawler->getCrawlerId().$lb;
                echo "Start Time: ".date("F d, Y / g:i:s A");
                echo "</p>";
                echo "<hr/>";
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
                echo "<hr/>";
                echo "<p>";
                echo "<b>Summary</b>".$lb;
                echo "Links followed: ".$report->links_followed.$lb;
                echo "Documents received: ".$report->files_received.$lb;
                echo "Data-size received: ~".get_file_size_unit($report->bytes_received).$lb;
                echo "Stop Time: ".date("F d, Y / g:i:s A").$lb;
                echo "Process runtime: ".seconds_to_str($report->process_runtime).$lb;
                echo "Process Abort Reason: ".$report->abort_reason." ".$lb;
                echo "</p>";

                //wrap-up process
                DomainObjectWatcher::instance()->performOperations();
                flush();
            }
            else
            {
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

        echo "</body>";
        echo "</html>";
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
                unset($crawl);
                echo '+';
                exit;
            }
            echo '-';
            exit;
        } catch (\Exception $e) {
            echo '-';
            exit;
        }
    }
}