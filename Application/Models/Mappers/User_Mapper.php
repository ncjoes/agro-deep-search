<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:28 PM
 */

namespace Application\Models\Mappers;


use Application\Models;

/**
 * Class User_Mapper
 * @package Application\Models\Mappers
 */
class User_Mapper extends A_Mapper
{
    /**
     * User_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM bb_users WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM bb_users");
        $this->selectByEmailStmt = self::$PDO->prepare("SELECT * FROM bb_users WHERE email=?");
        $this->selectByPhoneStmt = self::$PDO->prepare("SELECT * FROM bb_users WHERE phone=?");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM bb_users WHERE status=:status ORDER BY first_name, middle_name, last_name LIMIT :start, :limit");
        $this->updateStmt = self::$PDO->prepare("UPDATE bb_users SET photo=?,title=?,first_name=?,middle_name=?,last_name=?,email=?,phone=?,password=?,address1=?,address2=?,city=?,zip_code=?,state=?,country=?,biography=?,status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO bb_users (photo,title,first_name,middle_name,last_name,email,phone,password,address1,address2,city,zip_code,state,country,biography,status)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM bb_users WHERE id=?");
    }

    /**
     * @param $email
     * @return Models\A_DomainObject
     */
    public function findByEmail($email)
    {
        return $this->findHelper($email, $this->selectByEmailStmt, 'email');
    }

    /**
     * @param $phone
     * @return Models\A_DomainObject
     */
    public function findByPhone($phone)
    {
        return $this->findHelper($phone, $this->selectByPhoneStmt, 'phone');
    }

    /**
     * @param int $status
     * @param int $limit
     * @param int $start
     * @return \System\Models\Collections\Collection
     */
    public function findByStatus($status=1, $limit=10, $start=0)
    {
        $this->selectByStatusStmt->bindParam(':status', $status, \PDO::PARAM_INT);
        $this->selectByStatusStmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $this->selectByStatusStmt->bindParam(':start', $start, \PDO::PARAM_INT);
        $this->selectByStatusStmt->execute();
        return $this->getCollection( $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC) );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\User";
    }

    /**
     * @param array $array
     * @return Models\User
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setPhoto($array['photo']);
        $object->setTitle($array['title']);
        $object->setFirstName($array['first_name']);
        $object->setMiddleName($array['middle_name']);
        $object->setLastName($array['last_name']);
        $object->setEmail($array['email']);
        $object->setPhone($array['phone']);
        $object->setPassword($array['password']);
        $object->setAddress1($array['address1']);
        $object->setAddress2($array['address2']);
        $object->setCity($array['city']);
        $object->setZipCode($array['zip_code']);
        $object->setState($array['state']);
        $object->setCountry($array['country']);
        $object->setBiography($array['biography']);
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
            is_object($object->getPhoto()) ? $object->getPhoto()->getId() : NULL,
            $object->getTitle(),
            $object->getFirstName(),
            $object->getMiddleName(),
            $object->getLastName(),
            $object->getEmail(),
            $object->getPhone(),
            $object->getPassword(),
            $object->getAddress1(),
            $object->getAddress2(),
            $object->getCity(),
            $object->getZipCode(),
            $object->getState(),
            $object->getCountry(),
            $object->getBiography(),
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
            is_object($object->getPhoto()) ? $object->getPhoto()->getId() : NULL,
            $object->getTitle(),
            $object->getFirstName(),
            $object->getMiddleName(),
            $object->getLastName(),
            $object->getEmail(),
            $object->getPhone(),
            $object->getPassword(),
            $object->getAddress1(),
            $object->getAddress2(),
            $object->getCity(),
            $object->getZipCode(),
            $object->getState(),
            $object->getCountry(),
            $object->getBiography(),
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
        if(is_object( $object->getPhoto() )) $object->getPhoto()->mapper()->delete( $object->getPhoto() );
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