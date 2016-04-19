<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/15/2016
 * Time:    1:18 AM
 **/


namespace Application\Models;


use System\Utilities\DateTime;

/**
 * Class Crawl
 * @package Application\Models
 */
class Crawl extends A_StatefulObject
{
    private $crawler_id;
    private $start_time;
    private $end_time;

    const STATUS_COMPLETE = 1;
    const STATUS_ONGOING = 2;
    const STATUS_TERMINATED = 0;

    /**
     * Crawl constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getCrawlerId()
    {
        return $this->crawler_id;
    }

    /**
     * @param mixed $crawler_id
     * @return Crawl
     */
    public function setCrawlerId($crawler_id)
    {
        $this->crawler_id = $crawler_id;
        $this->markDirty();
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param DateTime $start_time
     * @return Crawl
     */
    public function setStartTime(DateTime $start_time)
    {
        $this->start_time = $start_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param DateTime $end_time
     * @return Crawl
     */
    public function setEndTime(DateTime $end_time)
    {
        $this->end_time = $end_time;
        $this->markDirty();
        return $this;
    }
}