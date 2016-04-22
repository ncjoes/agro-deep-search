<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/20/2016
 * Time:    9:15 AM
 **/


namespace Application\Utilities;


use Application\Models\Link;

class FrontierManager extends A_Utility
{
    private static $instance;
    private $crawl_line = array();

    private function __construct()
    {
        $this->reloadCrawLine();
    }

    /**
     * @return FrontierManager
     */
    public static function instance()
    {
        if( ! isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getCrawLine()
    {
        return $this->crawl_line;
    }

    public function getSizeOfCrawlLine()
    {
        return sizeof($this->crawl_line);
    }

    public function getMostRelevantLink()
    {
        return array_shift($this->crawl_line);
    }

    public function addToCrawlLine(Link $link)
    {
        array_push($this->crawl_line, $link->getUrl());
        return $this;
    }

    public function reloadCrawLine($MODE=1)
    {
        //TODO ...
        $link_objects = Link::getMapper('PageLink')->findRange();

        foreach ($link_objects as $link_object)
        {
            $this->crawl_line[] = $link_object->getUrl();
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}