<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Web
 * Date:    3/25/2016
 * Time:    3:50 PM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;

class A_StatefulObject extends A_DomainObject implements I_StatefulObject
{
    private $status;

    /**
     * A_NamedObject constructor.
     * @param null $id
     */
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
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}