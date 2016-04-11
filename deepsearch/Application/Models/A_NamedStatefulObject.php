<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: ANPC.NET
 * Date:    1/29/2016
 * Time:    3:03 PM
 **/


namespace Application\Models;


use System\Models\I_StatefulObject;

abstract class A_NamedStatefulObject extends A_NamedObject implements I_StatefulObject
{
    private $status;

    public function __construct($id=null)
    {
        parent::__construct($id);
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
     * @return A_DomainObject
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}