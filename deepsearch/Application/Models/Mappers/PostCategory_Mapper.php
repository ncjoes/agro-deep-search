<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    11:56 AM
 */

namespace Application\Models\Mappers;

use Application\Models;

class PostCategory_Mapper extends A_Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM bb_post_categories WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM bb_post_categories");
        $this->selectByPamalinkStmt = self::$PDO->prepare("SELECT * FROM bb_post_categories WHERE guid=?");
        $this->selectByParentStmt = self::$PDO->prepare("SELECT * FROM bb_post_categories WHERE parent=? ORDER BY caption");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM bb_post_categories WHERE status=? ORDER BY caption");
        $this->updateStmt = self::$PDO->prepare("UPDATE bb_post_categories set guid=?, parent=?, caption=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO bb_post_categories (guid,parent,caption,status)VALUES(?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM bb_post_categories WHERE id=?");
    }

    public function findByGUID($guid)
    {
        return $this->findHelper($guid, $this->selectByPamalinkStmt, 'guid');
    }

    public function findByParent($parent_id)
    {
        $this->selectByParentStmt->execute( array($parent_id) );
        $raw_data = $this->selectByParentStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function targetClass()
    {
        return "Application\\Models\\PostCategory";
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setGuid($array['guid']);
        $object->setParent($array['parent']);
        $object->setName($array['caption']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getGuid(),
            is_object($object->getParent()) ? $object->getParent()->getId() : NULL,
            $object->getName(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getGuid(),
            is_object($object->getParent()) ? $object->getParent()->getId() : NULL,
            $object->getName(),
            $object->getStatus(),
            $object->getId()
        );
        $this->updateStmt->execute( $values );
    }

    protected function doDelete(Models\A_DomainObject $object )
    {
        $values = array( $object->getId() );
        $this->deleteStmt->execute( $values );
    }

    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }
}