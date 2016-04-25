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
use Application\Models\CrawlSetting;
use Application\Models\Link;
use Application\Models\Form;
use System\Models\DomainObjectWatcher;
use System\Utilities\DateTime;

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
                if(strlen($DocInfo->referer_url))
                {
                    $plink = $this->findLinkObj($DocInfo->referer_url);
                    $plink->setUrl($DocInfo->referer_url);
                    $plink->setAnchor($DocInfo->refering_linktext);
                }

                $link = $this->findLinkObj($DocInfo->url);
                $link->setUrl($DocInfo->url);
                if(isset($plink) and is_object($plink)) $link->setParentLink($plink);
                $link->setLastCrawl($crawl);
                $link->setLastCrawlTime(new DateTime());
                $link->setStatus(Link::STATUS_VISITED);

                //handle received document
                if($DocInfo->received_completely)
                {
                    if($this->classifyPage() >= 0.5) //page belongs to our domain of interest
                    {
                        libxml_use_internal_errors(true);
                        $document = $this->prepareContent($DocInfo);

                        $page_title = $document->getElementsByTagName('title');
                        if(is_object($page_title->item(0))) $link->setPageTitle($page_title->item(0)->textContent);
                        $num_links_extracted = $this->extractContainedLinks($DocInfo, $link);
                        $num_forms_extracted = $this->extractContainedForms($document, $link);
                        $crawl->setNumLinksExtracted($crawl->getNumLinksExtracted() + $num_links_extracted);
                        $crawl->setNumFormsExtracted($crawl->getNumFormsExtracted() + $num_forms_extracted);
                        libxml_clear_errors();
                        unset($document);
                    }
                }
                else //handle links that could not be retrieved
                {
                    $link->setExpectedReward(0.0);
                }

                //Update Crawl Process Record
                $crawl->setNumLinksFollowed($crawl->getNumLinksFollowed() + 1);
                $crawl->setNumDocumentsReceived($crawl->getNumDocumentsReceived() + ($DocInfo->received == true ? 1 : 0));
                $crawl->setNumByteReceived( $crawl->getNumByteReceived() + ($DocInfo->received == true ? $DocInfo->bytes_received + $DocInfo->header_bytes_received : 0));
                $crawl->setProcessRunTime(mktime() - $crawl->getStartTime()->getDateTimeInt());
                $crawl->mapper()->update($crawl);

                //send progress report to browser
                if (PHP_SAPI == "cli") $lb = "\n"; else $lb = "<br />";
                $line = ($crawl->getNumLinksFollowed())." | ".$DocInfo->http_status_code." - ".$DocInfo->url." [";
                if ($DocInfo->received_completely == true) $line .= $DocInfo->bytes_received; else $line .= "N/R";
                $line .= "]";
                echo $line.$lb."- - - ".$lb;

                try
                {
                    //Wrap-up process
                    DomainObjectWatcher::instance()->performOperations();
                }
                catch (\Exception $e)
                {
                    echo "<hr/>".$e->getMessage()."<br/>";
                    if(site_info('development-mode',false)==true) echo getExceptionTraceString($e);
                    echo "<hr/>";
                }

                flush();
                return +10;
            }
            return -10;
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
        $document->preserveWhiteSpace = false;
        $document->loadHTML($documentInfo->source);

        return $document;
    }

    /**
     * @param $documentInfo PHPCrawlerDocumentInfo
     * @param $plink Link
     * @return int
     */
    public function extractContainedLinks(PHPCrawlerDocumentInfo $documentInfo, Link $plink)
    {
        $num_links_extracted = 0;
        $linkNodes = $documentInfo->links_found;
        $num_links_contained = sizeof($linkNodes);

        $filter_rules = CrawlSetting::getMapper('CrawlSetting')->findByVarName('addURLFilterRule')->getCurrentValue();

        for($i = 0; $i < $num_links_contained; ++$i)
        {
            $linkNode = $linkNodes[$i];
            if(! preg_match("#\.(".$filter_rules.")$# i", $linkNode['url_rebuild']))
            {
                $link = $this->findLinkObj($linkNode['url_rebuild']);
                $link->setUrl($linkNode['url_rebuild']);
                $link->setAnchor($linkNode['linktext']);
                $link->setParentLink($plink);
                if($link->getId() == $link::DEFAULT_ID)
                {
                    $num_links_extracted++;
                    $link->setExpectedReward(0.5);
                    $link->setStatus(Link::STATUS_UNVISITED);
                }
            }
        }
        return $num_links_extracted;
    }

    /**
     * @param \DOMDocument $document
     * @param $link Link
     * @return int
     */
    public function extractContainedForms(\DOMDocument $document, Link $link)
    {
        $num_forms_extracted = 0;
        $formNodes = $document->getElementsByTagName("form");
        $num_forms_contained = $formNodes->length;
        for($i = 0; $i < $num_forms_contained; ++$i)
        {
            $markup = A_Utility::getDOMNodeHTML($formNodes->item($i));
            $form = $this->findFormObj($markup);
            $form->setLink($link);
            $form->setMarkup($markup);
            if($form->getId() == $form::DEFAULT_ID)
            {
                $num_forms_extracted++;
                $form->setRelevance(Form::REL_UNKNOWN);
            }
        }
        if($num_forms_contained) $link->setExpectedReward(0.6);
        return $num_forms_extracted;
    }

    /**
     * @param $url
     * @return Link
     */
    public function findLinkObj($url)
    {
        $link = Link::getMapper("Link")->findByUrlHash(md5(A_Utility::trimUrl($url)));
        $link = is_object($link) ? $link : new Link();
        return $link;
    }

    /**
     * @param $markup
     * @return Form
     */
    public function findFormObj($markup)
    {
        $form = Form::getMapper("Form")->findByHash(md5(A_Utility::trimFormMarkup($markup)));
        $form = is_object($form) ? $form : new Form();
        return $form;
    }
}
