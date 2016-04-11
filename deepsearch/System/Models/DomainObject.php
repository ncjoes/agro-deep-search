<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models;


use System\Models\Collections;
use System\Models\Mappers\Mapper;
use System\Models\Mappers\MapperRegistry;

abstract class DomainObject
{
    private $id = -1;

    /**
     * DomainObject constructor.
     * @param null $id
     */
    public function __construct($id=null )
    {
        if(is_null($id))
        {
            $this->markNew();
        }
        else
        {
            $this->id = $id;
        }
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->markDirty();
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collections\Collection
     */
    public function collection()
    {
        return self::getCollection( get_class( $this ) );
    }

    /**
     * @param $type
     * @return Collections\Collection
     */
    public static function getCollection($type)
    {
        return new Collections\Collection(self::getMapper($type), array() );
    }

    /**
     * @return Mapper
     */
    public function mapper()
    {
        return self::getMapper( get_class( $this ) );
    }

    /**
     * @param $class_name
     * @return Mapper
     */
    public static function getMapper($class_name)
    {
        return MapperRegistry::getMapper($class_name);
    }

    public function markNew()
    {
        DomainObjectWatcher::addNew($this);
    }
    public function markClean()
    {
        DomainObjectWatcher::addClean($this);
    }
    public function markDirty()
    {
        DomainObjectWatcher::addDirty($this);
    }
    public function markDelete()
    {
        DomainObjectWatcher::addDelete($this);
    }
}