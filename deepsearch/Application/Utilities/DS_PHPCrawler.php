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
use System\Models\DomainObjectWatcher;

// Extend the class and override the handleDocumentInfo()-method
/**
 * Class DeepCrawler
 * @package Application\Utilities
 */
class DS_PHPCrawler extends PHPCrawler
{
    /**
     * @param \_Libraries\PHPCrawl\PHPCrawlerDocumentInfo $DocInfo
     * @return int
     */
    public function handleDocumentInfo(PHPCrawlerDocumentInfo $DocInfo)
    {
        $crawl = Crawl::getMapper("Crawl")->findByCrawlerId($this->crawler_uniqid);

        if($crawl->getStatus() == Crawl::STATUS_ONGOING)
        {
            //send progress report to browser
            if (PHP_SAPI == "cli") $lb = "\n"; else $lb = "<br />";
            $line = ($crawl->getNumLinksFollowed()+1)." | ".$DocInfo->http_status_code." - ".$DocInfo->url." [";
            if ($DocInfo->received_completely == true) $line .= $DocInfo->bytes_received; else $line .= "N/R";
            $line .= "]";
            echo $line.$lb."- - - ".$lb;

            //handle received document
            if($DocInfo->received_completely)
            {
                if($this->classifyPage() >= 0.5) //page belongs to our domain of interest
                {
                    libxml_use_internal_errors(true);
                    $document = $this->prepareContent($DocInfo);
                    $num_links_extracted = $this->extractContainedLinks($document);
                    $num_forms_extracted = $this->extractContainedForms($document);
                    $crawl->setNumLinksExtracted($crawl->getNumLinksExtracted() + $num_links_extracted);
                    $crawl->setNumFormsExtracted($crawl->getNumFormsExtracted() + $num_forms_extracted);
                    libxml_clear_errors();
                    unset($document);
                }
            }

            //Update Crawl Process Record
            $crawl->setNumLinksFollowed($crawl->getNumLinksFollowed() + 1);
            $crawl->setNumDocumentsReceived($crawl->getNumDocumentsReceived() + ($DocInfo->received == true ? 1 : 0));
            $crawl->setNumByteReceived( $crawl->getNumByteReceived() + ($DocInfo->received == true ? $DocInfo->bytes_received + $DocInfo->header_bytes_received : 0));
            $crawl->setProcessRunTime(mktime() - $crawl->getStartTime()->getDateTimeInt());
            $crawl->mapper()->update($crawl);

            flush();

            return 1;
        }
        return -1;
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
     * @throws \Exception
     */
    public function prepareContent(PHPCrawlerDocumentInfo $documentInfo)
    {
        $document = new \DOMDocument();
        $document->validateOnParse = false;
        $document->strictErrorChecking = false;

        if( $document->loadHTML($documentInfo->source, LIBXML_NOERROR ) )
        {
            return $document;
        }else{
            throw new \Exception("DOMDocument Error");
        }
    }

    /**
     * @param $document
     * @return int
     */
    public function extractContainedLinks(\DOMDocument $document)
    {
        $linkNodes = $document->getElementsByTagName("a");
        $num_links = $linkNodes->length;
        return $num_links;
    }

    /**
     * @param $document
     * @return int
     */
    public function extractContainedForms(\DOMDocument $document)
    {
        $formNodes = $document->getElementsByTagName("form");
        $num_forms = $formNodes->length;
        return $num_forms;
    }
}
