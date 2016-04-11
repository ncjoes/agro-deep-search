<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: E-Stamp
 * Date:    3/19/2016
 * Time:    9:05 AM
 **/

namespace Application\Models;


/**
 * Class A_NamedObject
 * @package Application\Models
 */
abstract class A_NamedObject extends A_DomainObject
{
    private $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->markDirty();
        return $this;
    }
}