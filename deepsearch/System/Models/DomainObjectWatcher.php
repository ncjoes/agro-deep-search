<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models;

use System\Models\Mappers\Mapper;

/**
 * Class DomainObjectWatcher
 * @package System\Models
 */
class DomainObjectWatcher
{
    private $all = array();
    private $dirty = array();
    private $new = array();
    private $delete = array();
    private static $instance;

    /**
     * DomainObjectWatcher constructor.
     */
    private function __construct() { }

    /**
     * @return DomainObjectWatcher
     */
    public static function instance()
    {
        if ( ! self::$instance )
        {
            self::$instance = new DomainObjectWatcher();
        }
        return self::$instance;
    }

    /**
     * @param DomainObject $obj
     * @return string
     */
    public function globalKey(DomainObject $obj )
    {
        $key = get_class($obj).".".$obj->getId();
        return $key;
    }

    /**
     * @param DomainObject $obj
     */
    public static function add(DomainObject $obj )
    {
        $inst = self::instance();
        $inst->all[$inst->globalKey( $obj )] = $obj;
    }

    /**
     * @param $class_name
     * @param $id
     * @return mixed|null
     */
    public static function exists($class_name, $id )
    {
        $inst = self::instance();
        $key = $class_name.".".$id;
        if ( isset( $inst->all[$key] ) )
        {
            return $inst->all[$key];
        }
        return null;
    }

    /**
     * @param DomainObject $obj
     */
    public static function addDelete(DomainObject $obj )
    {
        $self = self::instance();
        $self->delete[$self->globalKey( $obj )] = $obj;
    }

    /**
     * @param DomainObject $obj
     */
    public static function addDirty(DomainObject $obj )
    {
        $inst = self::instance();
        if ( ! in_array( $obj, $inst->new, true ) )
        {
            $inst->dirty[$inst->globalKey( $obj )] = $obj;
        }
    }

    /**
     * @param DomainObject $obj
     */
    public static function addNew(DomainObject $obj )
    {
        $inst = self::instance();
        // we don't yet have an id
        $inst->new[] = $obj;
    }

    /**
     * @param DomainObject $obj
     */
    public static function addClean(DomainObject $obj )
    {
        $self = self::instance();
        unset( $self->delete[$self->globalKey( $obj )] );
        unset( $self->dirty[$self->globalKey( $obj )] );
        $self->new = array_filter( $self->new, function( $a ) use ( $obj ) { return ( spl_object_hash($a) != spl_object_hash($obj) ); });
    }

    public static function unwatch(DomainObject $obj)
    {
        $self = self::instance();
        $self->addClean($obj);
        $key = $self->globalKey($obj);
        if(isset($self->all[ $key ])) unset($self->all[ $key ]);
    }

    public function reloadObject(DomainObject $obj)
    {
        $id = $obj->getId();
        $mapper = $obj->mapper();

        $obj->mapper()->update($obj);
        $this->unwatch($obj);
        unset($obj);

        $new_obj = $mapper->find($id);
        return $new_obj;
    }

    /**
     * @throws \Exception
     */
    public function performOperations()
    {
        //START TRANSACTION
        Mapper::getPDO()->exec("START TRANSACTION");

        $this->processDeletedObjects($this->delete);
        $this->processNewObjects($this->new);
        $this->processModifiedObjects($this->dirty);

        //END TRANSACTION
        Mapper::getPDO()->exec("COMMIT;");
    }

    /**
     * @param $array
     */
    private function processNewObjects(&$array)
    {
        $object = array_shift($array);
        if(is_object($object))
        {
            $object->mapper()->insert( $object );
            $this->processNewObjects($array);
        }
    }

    /**
     * @param $array
     */
    private function processDeletedObjects(&$array)
    {
        $object = array_shift($array);
        if(is_object($object))
        {
            $object->mapper()->delete( $object );
            $key = $this->globalKey($object);
            if(isset($this->all[ $key ])) unset($this->all[ $key ]);
            $this->processDeletedObjects($array);
        }
    }

    /**
     * @param $array
     */
    private function processModifiedObjects(&$array)
    {
        $object = array_shift($array);
        if(is_object($object))
        {
            $object->mapper()->update( $object );
            $this->processModifiedObjects( $array );
        }
    }
}