<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/31/2015
 * Time:    10:47 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use System\Utilities\DateTime;

/**
 * Class Session_Mapper
 * @package Application\Models\Mappers
 */
class Session_Mapper extends A_Mapper
{
    /**
     * Session_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM bb_sessions WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM bb_sessions ORDER BY last_activity_time DESC");
        $this->selectByUserIdStmt = self::$PDO->prepare(
            "SELECT * FROM bb_sessions WHERE user_id=? ORDER BY last_activity_time DESC");
        $this->selectByPrivilegeStmt = self::$PDO->prepare(
            "SELECT * FROM bb_sessions WHERE privilege=? ORDER BY last_activity_time DESC");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE bb_sessions SET user_id=?, privilege=?, start_time=?, user_agent=?, ip_address=?, last_activity_time=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO bb_sessions (user_id,privilege,start_time,user_agent,ip_address,last_activity_time,status) VALUES (?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare(
            "DELETE FROM bb_sessions WHERE id=?");
    }

    /**
     * @param $user_id
     * @return \System\Models\Collections\Collection
     */
    public function findByUserId($user_id)
    {
        $this->selectByUserIdStmt->execute( array($user_id) );
        $raw_data = $this->selectByUserIdStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $privilege
     * @return \System\Models\Collections\Collection
     */
    public function findByPrivilege($privilege)
    {
        $this->selectByPrivilegeStmt->execute( array($privilege) );
        $raw_data = $this->selectByPrivilegeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\Session";
    }

    /**
     * @param array $array
     * @return mixed
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setUser(Models\User::getMapper('User')->find($array['user_id']));
        $object->setPrivilege($array['privilege']);
        $object->setStartTime(DateTime::getDateTimeObjFromInt($array['start_time']));
        $object->setUserAgent($array['user_agent']);
        $object->setIpAddress($array['ip_address']);
        $object->setLastActivityTime(DateTime::getDateTimeObjFromInt($array['last_activity_time']));
        $object->setStatus($array['status']);

        return $object;
    }

    /**
     * @param Models\A_DomainObject $object
     */
    protected function doInsert(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getUser()->getId(),
            $object->getPrivilege(),
            $object->getStartTime()->getDateTimeInt(),
            $object->getUserAgent(),
            $object->getIpAddress(),
            $object->getLastActivityTime()->getDateTimeInt(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    /**
     * @param Models\A_DomainObject $object
     */
    protected function doUpdate(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getUser()->getId(),
            $object->getPrivilege(),
            $object->getStartTime()->getDateTimeInt(),
            $object->getUserAgent(),
            $object->getIpAddress(),
            $object->getLastActivityTime()->getDateTimeInt(),
            $object->getStatus(),
            $object->getId()
        );
        $this->updateStmt->execute( $values );
    }

    /**
     * @param Models\A_DomainObject $object
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