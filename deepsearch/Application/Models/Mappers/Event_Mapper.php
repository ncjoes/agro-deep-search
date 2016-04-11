<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: E-Stamp
 * Date:    3/20/2016
 * Time:    7:05 AM
 **/

namespace Application\Models\Mappers;


use Application\Models;
use System\Utilities\DateTime;

/**
 * Class Event_Mapper
 * @package Application\Models\Mappers
 */
class Event_Mapper extends A_Mapper
{
    /**
     * Event_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM bb_events_log WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM bb_events_log");
        $this->selectBySessionIDStmt = self::$PDO->prepare("SELECT * FROM bb_events_log WHERE session_id=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE bb_events_log SET session_id=?, time=?, category=?, description=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO bb_events_log (session_id,time,category,description,status)VALUES(?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM bb_events_log WHERE id=?");
    }

    /**
     * @param $session_id
     * @return \System\Models\Collections\Collection
     */
    public function findBySession($session_id)
    {
        $this->selectBySessionIDStmt->execute( array($session_id) );
        $raw_data = $this->selectBySessionIDStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\Event";
    }

    /**
     * @param array $array
     * @return Models\Event
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);

        $session = Models\Session::getMapper('Session')->find($array['session_id']);
        if(is_object($session)) $object->setSession($session);

        $object->setTime(DateTime::getDateTimeObjFromInt($array['time']));
        $object->setCategory($array['category']);
        $object->setDescription($array['description']);
        $object->setStatus($array['status']);

        return $object;
    }

    /**
     * @param Models\A_DomainObject $object
     * @return null
     */
    protected function doInsert(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getSession()->getId(),
            $object->getTime()->getDateTimeInt(),
            $object->getCategory(),
            $object->getDescription(),
            $object->getStatus()
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
            $object->getSession()->getId(),
            $object->getTime()->getDateTimeInt(),
            $object->getCategory(),
            $object->getDescription(),
            $object->getStatus(),
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