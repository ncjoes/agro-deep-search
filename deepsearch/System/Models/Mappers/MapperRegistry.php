<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models\Mappers;

//caching mapper objects
class MapperRegistry
{
    static private $App_Mappers_Dir = "Application\\Models\\Mappers\\";
    static private $mapper_objects = array();

    /**
     * @param $class_name
     * @return Mapper
     */
    static function getMapper($class_name)
    {
        $arr = explode('\\', $class_name);
        $root_class_name = $arr[sizeof($arr)-1];
        $mapper_class_name = self::$App_Mappers_Dir."{$root_class_name}_Mapper";

        if(!isset(self::$mapper_objects[$mapper_class_name]) or !is_object(self::$mapper_objects[$mapper_class_name]))
        {
            self::$mapper_objects[$mapper_class_name] = new $mapper_class_name();
        }
        return self::$mapper_objects[$mapper_class_name];
    }
} 