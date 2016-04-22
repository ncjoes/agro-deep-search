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
    private $session_id;
    private $num_links_followed = 0;
    private $num_documents_received = 0;
    private $num_links_extracted = 0;
    private $num_forms_extracted = 0;
    private $num_byte_received = 0.0;
    private $process_run_time = 0.0;
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
        $this->start_time = new DateTime();
    }

    /**
     * @return mixed
     */
    public function getCrawlerId()
    {
        return $this->crawler_id;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param mixed $session_id
     * @return Crawl
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
        $this->markDirty();
        return $this;
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
     * @return mixed
     */
    public function getNumLinksFollowed()
    {
        return $this->num_links_followed;
    }

    /**
     * @param mixed $num_links_followed
     * @return Crawl
     */
    public function setNumLinksFollowed($num_links_followed)
    {
        $this->num_links_followed = $num_links_followed;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumDocumentsReceived()
    {
        return $this->num_documents_received;
    }

    /**
     * @param mixed $num_documents_received
     * @return Crawl
     */
    public function setNumDocumentsReceived($num_documents_received)
    {
        $this->num_documents_received = $num_documents_received;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumLinksExtracted()
    {
        return $this->num_links_extracted;
    }

    /**
     * @param mixed $num_links_extracted
     * @return Crawl
     */
    public function setNumLinksExtracted($num_links_extracted)
    {
        $this->num_links_extracted = $num_links_extracted;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumFormsExtracted()
    {
        return $this->num_forms_extracted;
    }

    /**
     * @param mixed $num_forms_extracted
     * @return Crawl
     */
    public function setNumFormsExtracted($num_forms_extracted)
    {
        $this->num_forms_extracted = $num_forms_extracted;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumByteReceived()
    {
        return $this->num_byte_received;
    }

    /**
     * @param mixed $num_byte_received
     * @return Crawl
     */
    public function setNumByteReceived($num_byte_received)
    {
        $this->num_byte_received = $num_byte_received;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcessRunTime()
    {
        return $this->process_run_time;
    }

    /**
     * @param mixed $process_run_time
     * @return Crawl
     */
    public function setProcessRunTime($process_run_time)
    {
        $this->process_run_time = $process_run_time;
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