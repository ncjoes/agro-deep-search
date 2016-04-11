<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: E-Stamp
 * Date:    3/19/2016
 * Time:    10:51 PM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

class Event extends A_DomainObject implements I_StatefulObject
{
    private $session;
    private $time;
    private $category;
    private $description;
    private $status;

    /**
     * Event constructor.
     * @param $id=null
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     * @return Event
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        $this->markDirty();
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param DateTime $time
     * @return Event
     */
    public function setTime(DateTime $time)
    {
        $this->time = $time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Event
     */
    public function setCategory($category)
    {
        $this->category = $category;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}