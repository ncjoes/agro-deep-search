<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/15/2016
 * Time:    12:39 AM
 **/


namespace Application\Models;
use System\Utilities\DateTime;


/**
 * Class PageLink
 * @package Application\Models
 */
class Link extends A_StatefulObject
{
    private $crawl;
    private $url;
    private $url_hash = null;
    private $anchor;
    private $around_text = array('before'=>"", 'after'=>"");
    private $page_title = "";
    private $parent_link;
    private $last_crawl_time;
    private $target_distance;
    private $expected_reward;

    const AROUND_TEXT_SEPARATOR = "\n----\n";

    /**
     * PageLink constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return Crawl
     */
    public function getCrawl()
    {
        if(! is_object($this->crawl))
        {
            $this->crawl = Crawl::getMapper('Crawl')->find($this->crawl);
        }
        return $this->crawl;
    }

    /**
     * @param mixed $crawl
     * @return mixed
     */
    public function setCrawl($crawl)
    {
        $this->parent_link = $crawl;
        $this->markDirty();
        return $this;
    }
    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrlHash()
    {
        if(is_null($this->url_hash)) $this->url_hash = md5($this->url);
        return $this->url_hash;
    }

    /**
     * @return string
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @param string $anchor
     * @return Link
     */
    public function setAnchor($anchor)
    {
        $this->anchor = $anchor;
        $this->markDirty();
        return $this;
    }

    /**
     * @return array
     */
    public function getAroundText()
    {
        return $this->around_text;
    }

    /**
     * @return array
     */
    public function getAroundTextStr()
    {
        return implode(self::AROUND_TEXT_SEPARATOR, $this->around_text);
    }

    /**
     * @return string
     */
    public function getTextBefore()
    {
        return $this->around_text['before'];
    }

    public function setTextBefore($text)
    {
        $this->around_text['before'] = $text;
    }

    /**
     * @return string
     */
    public function getTextAfter()
    {
        return $this->around_text['after'];
    }

    public function setTextAfter($text)
    {
        $this->around_text['after'] = $text;
    }

    /**
     * @param string $text
     * @return Link
     */
    public function setAroundText($text)
    {
        $text_comp = explode(self::AROUND_TEXT_SEPARATOR, $text);
        $this->around_text['before'] = $text_comp[0];
        $this->around_text['after'] = $text_comp[1];
        $this->markDirty();
        return $this;
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->page_title;
    }

    /**
     * @param string $page_title
     * @return Link
     */
    public function setPageTitle($page_title)
    {
        $this->page_title = $page_title;
        $this->markDirty();
        return $this;
    }

    /**
     * @return Link
     */
    public function getParentLink()
    {
        if(! is_object($this->parent_link))
        {
            $this->parent_link = $this->mapper()->find($this->parent_link);
        }
        return $this->parent_link;
    }

    /**
     * @param mixed $parent_link
     * @return mixed
     */
    public function setParentLink($parent_link)
    {
        $this->parent_link = $parent_link;
        $this->markDirty();
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastCrawlTime()
    {
        return $this->last_crawl_time;
    }

    /**
     * @param DateTime $last_crawl_time
     * @return Link
     */
    public function setLastCrawlTime(DateTime $last_crawl_time)
    {
        $this->last_crawl_time = $last_crawl_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return int
     */
    public function getTargetDistance()
    {
        return $this->target_distance;
    }

    /**
     * @param int $target_distance
     * @return Link
     */
    public function setTargetDistance($target_distance)
    {
        $this->target_distance = $target_distance;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpectedReward()
    {
        return $this->expected_reward;
    }

    /**
     * @param mixed $expected_reward
     * @return Link
     */
    public function setExpectedReward($expected_reward)
    {
        $this->expected_reward = $expected_reward;
        $this->markDirty();
        return $this;
    }
}