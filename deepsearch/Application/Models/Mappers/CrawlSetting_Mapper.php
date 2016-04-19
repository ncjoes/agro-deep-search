<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    10:20 PM
 **/


namespace Application\Models\Mappers;


use Application\Models;

/**
 * Class CrawlSetting_Mapper
 * @package Application\Models\Mappers
 */
class CrawlSetting_Mapper extends A_Mapper
{
    /**
     * CrawlSetting_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_crawl_settings WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_crawl_settings");
        $this->selectByVarNameStmt = self::$PDO->prepare("SELECT * FROM app_crawl_settings WHERE var_name=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_crawl_settings SET var_name=?, current_value=?, default_value=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_crawl_settings (var_name,current_value,default_value)VALUES(?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_crawl_settings WHERE id=?");
    }

    /**
     * @param $var_name
     * @return \System\Models\Collections\Collection
     */
    public function findByVarName($var_name)
    {
        return $this->findHelper($var_name, $this->selectByVarNameStmt, 'var_name');
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\CrawlSetting";
    }

    /**
     * @param array $array
     * @return Models\CrawlSetting
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setVarName($array['var_name']);
        $object->setCurrentValue($array['current_value']);
        $object->setDefaultValue($array['default_value']);

        return $object;
    }

    /**
     * @param Models\A_DomainObject $object
     * @return null
     */
    protected function doInsert(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getVarName(),
            $object->getCurrentValue(),
            $object->getDefaultValue()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    /**
     * @param Models\A_DomainObject $object
     * @return null
     */
    protected function doUpdate(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getVarName(),
            $object->getCurrentValue(),
            $object->getDefaultValue(),
            $object->getId()
        );
        $this->updateStmt->execute( $values );
    }

    /**
     * @param Models\A_DomainObject $object
     * @return null
     */
    protected function doDelete(Models\A_DomainObject $object )
    {
        $values = array( $object->getId() );
        $this->deleteStmt->execute( $values );
    }

    /**
     * @return \PDOStatement
     */
    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    /**
     * @return \PDOStatement
     */
    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }
}