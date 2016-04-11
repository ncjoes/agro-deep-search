<?php
namespace Application\Models;

use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

class Session extends A_DomainObject implements I_StatefulObject
{
    private $user;
    private $privilege;
    private $start_time;
    private $user_agent;
    private $ip_address;
    private $last_activity_time;
    private $status;

    /**
     * Session constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @param $authorized_privileges
     * @return bool
     */
    public function isAuthorized($authorized_privileges)
    {
        if(!is_array($authorized_privileges))
        {
            $authorized_privileges = array($authorized_privileges);
        }
        foreach($authorized_privileges as $authorized_privilege)
        {
            if ($this->privilege == $authorized_privilege) return true;
        }
        return false;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Session
     */
    public function setUser($user)
    {
        $this->user = $user;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param integer $privilege
     * @return Session
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
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
     * @return $this
     */
    public function setStartTime(DateTime $start_time)
    {
        $this->start_time = $start_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * @param $user_agent
     * @return $this
     */
    public function setUserAgent($user_agent)
    {
        $this->user_agent = $user_agent;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * @param $ip_address
     * @return $this
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastActivityTime()
    {
        return $this->last_activity_time;
    }

    /**
     * @param DateTime $last_activity_time
     * @return $this
     */
    public function setLastActivityTime(DateTime $last_activity_time)
    {
        $this->last_activity_time = $last_activity_time;
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
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}