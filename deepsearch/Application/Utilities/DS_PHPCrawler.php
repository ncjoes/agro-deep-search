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
class DS_PHPCrawler extends PHPCrawler
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
     * @return DS_PHPCrawler
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
        //Bring Crawl-Record into scope
        $crawl = $this->crawl_record;

        //send progress report to browser
        if (PHP_SAPI == "cli") $lb = "\n"; else $lb = "<br />";
        $line = $DocInfo->http_status_code." - ".$DocInfo->url." [";
        if ($DocInfo->received_completely == true) $line .= $DocInfo->bytes_received; else $line .= "N/R";
        $line .= "]";
        echo $line.$lb."- - - ".$lb;

        //handle received document
        if($DocInfo->received_completely)
        {
            //TODO
            //Classify Document
            // if need be {
            // do DB stuffs
            //1. Load $DocInfo->source into HTMLParser
            //2. Extract all links
            //3. Extract all forms
            // }
            if($this->classifyPage() >= 0.5) //page belongs to our domain of interest
            {
                $document = $this->prepareContent($DocInfo);
                $num_links_extracted = $this->extractContainedLinks($document);
                $num_forms_extracted = $this->extractContainedForms($document);
                $crawl->setNumLinksExtracted($crawl->getNumLinksExtracted() + $num_links_extracted);
                $crawl->setNumFormsExtracted($crawl->getNumFormsExtracted() + $num_forms_extracted);
            }
        }

        //Update Crawl Process Record
        $crawl->setNumLinksFollowed($crawl->getNumLinksFollowed() + 1);
        $crawl->setNumDocumentsReceived($crawl->getNumDocumentsReceived() + ($DocInfo->received == true ? 1 : 0));
        $crawl->setNumByteReceived( $crawl->getNumByteReceived() + ($DocInfo->received == true ? $DocInfo->bytes_received + $DocInfo->header_bytes_received : 0));
        $crawl->setProcessRunTime(mktime() - $crawl->getStartTime()->getDateTimeInt());
        $crawl->mapper()->update($crawl);

        flush();
    }

    /**
     * @return float
     */
    public function classifyPage()
    {
        $p = 0.5;
        return $p;
    }

    /**
     * @param $documentInfo
     * @return \DOMDocument
     */
    public function prepareContent(PHPCrawlerDocumentInfo $documentInfo)
    {
        $document = new \DOMDocument();
        return $document;//->loadHTML($documentInfo->content);
    }

    /**
     * @param $document
     * @return int
     */
    public function extractContainedLinks(\DOMDocument $document)
    {
        $num_links = 0;
        return $num_links;
    }

    /**
     * @param $document
     * @return int
     */
    public function extractContainedForms(\DOMDocument $document)
    {
        $num_forms = 0;
        return $num_forms;
    }
}
