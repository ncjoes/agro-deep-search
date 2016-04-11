<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: E-Stamp
 * Date:    3/19/2016
 * Time:    9:55 PM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;

class UserPrivilege extends A_DomainObject implements I_StatefulObject
{
    private $user;
    private $privilege;
    private $status;

    const UT_ADMIN = 1;
    const UT_EDITOR = 2;

    /**
     * UserPrivilege constructor.
     * @param $id=null
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
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
     * @return UserPrivilege
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
     * @param mixed $privilege
     * @return UserPrivilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
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
     * @return UserPrivilege
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }

    /**
     * @param $privilege
     * @return string
     */
    public static function getDefaultController($privilege)
    {
        $command = "default";
        switch(ucfirst($privilege))
        {
            case (self::UT_EDITOR) :{
                $command = 'editor-panel';
            } break;

            case (self::UT_ADMIN) :{
                $command = 'admin-panel';
            } break;
        }
        return $command;
    }

    /**
     * @return string
     */
    public function defaultController()
    {
        return self::getDefaultController($this->getPrivilege());
    }
}