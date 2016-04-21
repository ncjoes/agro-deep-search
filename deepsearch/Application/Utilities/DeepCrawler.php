<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/17/2016
 * Time:    9:02 AM
 **/


namespace Application\Utilities;


use _Libraries\PHPCrawl\PHPCrawler;
use _Libraries\PHPCrawl\PHPCrawlerDocumentInfo;
use Application\Models\Crawl;

// Extend the class and override the handleDocumentInfo()-method
/**
 * Class DeepCrawler
 * @package Application\Utilities
 */
class DeepCrawler extends PHPCrawler
{
    /**
     * @var Crawl
     */
    protected $crawl_record;

    /**
     * @return Crawl
     */
    public function getCrawlRecord()
    {
        return $this->crawl_record;
    }

    /**
     * @param Crawl $crawl_record
     * @return DeepCrawler
     */
    public function setCrawlRecord(Crawl $crawl_record)
    {
        $this->crawl_record = $crawl_record;
        return $this;
    }

    /**
     * @param \_Libraries\PHPCrawl\PHPCrawlerDocumentInfo $DocInfo
     * @return null
     */
    public function handleDocumentInfo(PHPCrawlerDocumentInfo $DocInfo)
    {
        if (PHP_SAPI == "cli") $lb = "\n"; else $lb = "<br />";
        echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")".$lb;
        echo "Referrer-page: ".$DocInfo->referer_url.$lb;
        if ($DocInfo->received == true){ echo "Content received: ".$DocInfo->bytes_received." bytes".$lb; }
        else{ echo "Content not received".$lb; }
        echo "<hr/>";
        flush();

        // Now you should do something with the content of the actual
        // received page or file ($DocInfo->source), we skip it in this example

        //Update Crawl Record
        $crawl = $this->crawl_record;
        //$report = $this->getProcessReport();
        $crawl->setNumLinksFollowed($crawl->getNumLinksFollowed() + 1);
        $crawl->setNumDocumentsReceived($crawl->getNumDocumentsReceived() + ($DocInfo->received == true ? 1 : 0));
        $crawl->setNumByteReceived($crawl->getNumByteReceived() + ($DocInfo->received == true ? $DocInfo->bytes_received : 0));
        $crawl->setProcessRunTime(mktime() - $crawl->getStartTime()->getDateTimeInt());
        $crawl->mapper()->update($crawl);
    }
}
