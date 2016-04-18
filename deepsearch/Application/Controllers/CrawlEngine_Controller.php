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


use System\Request\RequestContext;
use Application\Utilities\DeepCrawler;

class CrawlEngine_Controller extends A_Controller
{
    public function doExecute(RequestContext $requestContext)
    {
        $requestContext->setView('crawl-engine/index.php');
        if($requestContext->getRequestUrlParam(1)=='start')
        {
            $this->doCrawl($requestContext);
        }
    }

    protected function CrawlSettings(RequestContext $requestContext)
    {
        $data['page-title'] = "Default Crawl Settings";
        $requestContext->setResponseData($data);
        $requestContext->setView('crawl-engine/crawl-settings.php');
    }

    protected function doCrawl(RequestContext $requestContext)
    {
        // Now, create a instance of your class, define the behaviour
        // of the crawler (see class-reference for more options and details)
        // and start the crawling-process.

        set_time_limit(60 * 60 * 10);

        $crawler = new DeepCrawler();

        // URL to crawl
        $crawler->setURL("dev.ppsmbenugu.com.ng");

        // Only receive content of files with content-type "text/html"
        $crawler->addContentTypeReceiveRule("#text/html#");

        // Ignore links to pictures, dont even request pictures
        $crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png|css|js)$# i");

        // Store and send cookie-data like a browser does
        $crawler->enableCookieHandling(true);

        // Set the traffic-limit to 1 MB (in bytes,
        // for testing we don't want to "suck" the whole site)
        $crawler->setTrafficLimit(1000 * 1024);

        // That's enough, now here we go
        $crawler->go();

        // At the end, after the process is finished, we print a short
        // report (see method getProcessReport() for more information)
        $report = $crawler->getProcessReport();

        if (PHP_SAPI == "cli") $lb = "\n";
        else $lb = "<br />";

        echo "Summary:".$lb;
        echo "Links followed: ".$report->links_followed.$lb;
        echo "Documents received: ".$report->files_received.$lb;
        echo "Bytes received: ".$report->bytes_received." bytes".$lb;
        echo "Process runtime: ".$report->process_runtime." sec".$lb;
    }
}