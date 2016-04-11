<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:10 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use System\Utilities\DateTime;

/**
 * Class Upload_Mapper
 * @package Application\Models\Mappers
 */
class Upload_Mapper extends A_Mapper
{
    /**
     * Upload_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM bb_uploads WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM bb_uploads");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM bb_uploads WHERE status=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE bb_uploads SET author=?, upload_time=?, location=?, file_name=?, file_size=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO bb_uploads (author,upload_time,location,file_name,file_size,status)VALUES(?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM bb_uploads WHERE id=?");
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
        return "Application\\Models\\Upload";
    }

    /**
     * @param array $array
     * @return Models\Upload
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setAuthor($array['author']);
        $object->setUploadTime(DateTime::getDateTimeObjFromInt($array['upload_time']));
        $object->setLocation($array['location']);
        $object->setFileName($array['file_name']);
        $object->setFileSize($array['file_size']);
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
            is_object($object->getAuthor()) ? $object->getAuthor()->getId() : NULL,
            $object->getUploadTime()->getDateTimeInt(),
            $object->getLocation(),
            $object->getFileName(),
            $object->getFileSize(),
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
            is_object($object->getAuthor()) ? $object->getAuthor()->getId() : NULL,
            $object->getUploadTime()->getDateTimeInt(),
            $object->getLocation(),
            $object->getFileName(),
            $object->getFileSize(),
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
        if(is_file($object->getFullPath())) unlink($object->getFullPath());
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