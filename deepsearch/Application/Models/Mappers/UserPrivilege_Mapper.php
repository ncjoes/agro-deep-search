<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: E-Stamp
 * Date:    3/20/2016
 * Time:    9:20 AM
 **/

namespace Application\Models\Mappers;


use Application\Models;

/**
 * Class UserPrivilege_Mapper
 * @package Application\Models\Mappers
 */
class UserPrivilege_Mapper extends A_Mapper
{
    /**
     * UserPrivilege_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_users_privileges WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_users_privileges ORDER by category,name");
        $this->selectByUserIdStmt = self::$PDO->prepare("SELECT * FROM app_users_privileges WHERE user_id=? ORDER BY privilege ASC;");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM app_users_privileges WHERE status=? ORDER BY user_id,privilege;");
        $this->selectByPrivilegeStmt = self::$PDO->prepare("SELECT * FROM app_users_privileges WHERE privilege=?;");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_users_privileges SET user_id=?,privilege=?,status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_users_privileges (user_id,privilege,status)VALUES(?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_users_privileges WHERE id=?");
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
     * @param $user_id
     * @return \System\Models\Collections\Collection
     */
    public function findByUser($user_id)
    {
        $this->selectByUserIdStmt->execute( array($user_id) );
        $raw_data = $this->selectByUserIdStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $status
     * @return \System\Models\Collections\Collection
     */
    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\UserPrivilege";
    }

    /**
     * @param array $array
     * @return Models\UserPrivilege
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setUser(Models\User::getMapper("User")->find($array['user_id']));
        $object->setPrivilege($array['privilege']);
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
            $object->getUser()->getId(),
            $object->getPrivilege(),
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
            $object->getUser()->getId(),
            $object->getPrivilege(),
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