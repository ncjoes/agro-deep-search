<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    3:50 PM
 */

namespace Application\Models;


use System\Models\Collections\Collection;
use System\Models\I_StatefulObject;

/**
 * Class User
 * @package Application\Models
 * @Alias Staff
 */
class User extends A_Person implements I_StatefulObject
{
    private $privileges;
    private $office;
    private $status;

    /**
     * User constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return Office
     */
    public function getOffice()
    {
        if(! is_object($this->office))
        {
            $staff_composite = BoardStaff::getMapper('BoardStaff')->findByUser($this->getId());
            $this->office = is_object($staff_composite) ? $staff_composite->getOffice() : null;
        }
        return $this->office;
    }

    /**
     * @param Office $office
     * @return User
     */
    public function setOffice(Office $office)
    {
        $this->office = $office;
        $this->markDirty();
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPrivileges()
    {
        if(!isset($this->privileges))
        {
            $this->privileges = UserPrivilege::getMapper("UserPrivilege")->findByUser($this->getId());
        }
        return $this->privileges;
    }

    /**
     * @return UserPrivilege
     */
    public function getDefaultPrivilege()
    {
        $default_privilege = null;
        $privileges = $this->getPrivileges();

        foreach($privileges as $privilege)
        {
            if($privilege->getStatus() == UserPrivilege::STATUS_ON)
                $default_privilege = $privilege;
        }

        return $default_privilege;
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
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}