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
        $index = rand(0, sizeof($this->crawl_line));
        return (isset($this->crawl_line[$index]) ? $this->crawl_line[$index] : null);
    }

    public function addToCrawlLine(Link $link)
    {
        return array_push($this->crawl_line, $link->getUrl());
    }

    public function reloadCrawLine($MODE=1)
    {
        //TODO ...
        $link_objects = Link::getMapper('Link')->findRange(Link::STATUS_UNVISITED, 5000);

        foreach ($link_objects as $link_object)
        {
            $this->crawl_line[] = A_Utility::trimUrl($link_object->getUrl());
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}