<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models;

class DomainObjectWatcher
{
    private $all = array();
    private $dirty = array();
    private $new = array();
    private $delete = array();
    private static $instance;

    private function __construct() { }

    public static function instance()
    {
        if ( ! self::$instance )
        {
            self::$instance = new DomainObjectWatcher();
        }
        return self::$instance;
    }

    public function globalKey( DomainObject $obj )
    {
        $key = get_class( $obj ).".".$obj->getId();
        return $key;
    }

    public static function add( DomainObject $obj )
    {
        $inst = self::instance();
        $inst->all[$inst->globalKey( $obj )] = $obj;
    }

    public static function exists($class_name, $id )
    {
        $inst = self::instance();
        $key = "$class_name.".".$id";
        if ( isset( $inst->all[$key] ) )
        {
            return $inst->all[$key];
        }
        return null;
    }

    public static function addDelete(DomainObject $obj )
    {
        $self = self::instance();
        $self->delete[$self->globalKey( $obj )] = $obj;
    }

    public static function addDirty(DomainObject $obj )
    {
        $inst = self::instance();
        if ( ! in_array( $obj, $inst->new, true ) )
        {
            $inst->dirty[$inst->globalKey( $obj )] = $obj;
        }
    }

    static function addNew(DomainObject $obj )
    {
        $inst = self::instance();
        // we don't yet have an id
        $inst->new[] = $obj;
    }

    static function addClean(DomainObject $obj )
    {
        $self = self::instance();
        unset( $self->delete[$self->globalKey( $obj )] );
        unset( $self->dirty[$self->globalKey( $obj )] );
        $self->new = array_filter( $self->new, function( $a ) use ( $obj ) { return !( $a === $obj ); });
    }

    public function performOperations()
    {
        //START TRANSACTION
        $this->processDeletedObjects($this->delete);
        $this->processNewObjects($this->new);
        $this->processModifiedObjects($this->dirty);
        //END TRANSACTION
    }

    private function processNewObjects(&$array)
    {
        $object = array_shift($array);
        if(is_object($object))
        {
            $object->mapper()->insert( $object );
            $this->processNewObjects($array);
        }
    }

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