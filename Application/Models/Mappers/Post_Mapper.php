<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: thehouseoflaws.org
 * Date:    10/24/2015
 * Time:    10:26 PM
 */

namespace Application\Models\Mappers;

use \Application\Models;
use \System\Utilities\DateTime;

/**
 * Class Post_Mapper
 * @package Application\Models\Mappers
 */
class Post_Mapper extends A_Mapper
{
    /**
     * Post_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM bb_posts ORDER BY cardinality ASC;");
        $this->selectByTypeStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE post_type=:post_type ORDER BY cardinality ASC LIMIT :row_count OFFSET :offset;");
        $this->selectByGuidStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE guid=?");
        $this->selectByCategoryStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE category=? AND status=? ORDER BY cardinality ASC;");
        $this->selectByAuthorStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE author=? ORDER BY cardinality ASC;");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE status=? ORDER BY cardinality ASC;");
        $this->selectTypeByStatusStmt = self::$PDO->prepare("SELECT * FROM bb_posts WHERE post_type=:post_type AND status=:post_status ORDER BY cardinality ASC LIMIT :row_count OFFSET :offset;");
        $this->updateStmt = self::$PDO->prepare("UPDATE bb_posts SET post_type=?, guid=?, title=?, content=?, excerpt=?, featured_image=?, category=?, author=?, date_created=?, last_update=?, cardinality=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO bb_posts (post_type,guid,title,content,excerpt,featured_image,category,author,date_created,last_update,cardinality,status)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM bb_posts WHERE id=?");
    }

    /**
     * @param $post_type
     * @param int $row_count
     * @param int $offset
     * @return \System\Models\Collections\Collection
     */
    public function findByType($post_type, $row_count=10, $offset=0)
    {
        $this->selectByTypeStmt->bindParam(':post_type', $post_type, \PDO::PARAM_STR);
        $this->selectByTypeStmt->bindParam(':row_count', $row_count, \PDO::PARAM_INT);
        $this->selectByTypeStmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $this->selectByTypeStmt->execute();
        $raw_data = $this->selectByTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $guid
     * @return Models\A_DomainObject
     */
    public function findByGuid($guid)
    {
        return $this->findHelper($guid, $this->selectByGuidStmt, 'guid');
    }

    /**
     * @param $category
     * @param int $status
     * @return \System\Models\Collections\Collection
     */
    public function findByCategory($category, $status=1)
    {
        $this->selectByCategoryStmt->execute( array($category,$status) );
        $raw_data = $this->selectByCategoryStmt->fetchAll(\PDO::FETCH_ASSOC);
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
     * @param $post_type
     * @param $post_status
     * @param int $row_count
     * @param int $offset
     * @return \System\Models\Collections\Collection
     */
    public function findTypeByStatus($post_type, $post_status, $row_count=10, $offset=0)
    {
        $this->selectTypeByStatusStmt->bindParam(':post_type', $post_type, \PDO::PARAM_STR);
        $this->selectTypeByStatusStmt->bindParam(':post_status', $post_status, \PDO::PARAM_INT);
        $this->selectTypeByStatusStmt->bindParam(':row_count', $row_count, \PDO::PARAM_INT);
        $this->selectTypeByStatusStmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $this->selectTypeByStatusStmt->execute();
        $raw_data = $this->selectTypeByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $user_id
     * @return \System\Models\Collections\Collection
     */
    public function findByAuthor($user_id)
    {
        $this->selectByAuthorStmt->execute( array($user_id) );
        $raw_data = $this->selectByAuthorStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\Post";
    }

    /**
     * @param array $array
     * @return Models\Post
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setPostType($array['post_type']);
        $object->setGuid($array['guid']);
        $object->setTitle($array['title']);
        $object->setContent($array['content']);
        $object->setExcerpt($array['excerpt']);
        $object->setFeaturedImage($array['featured_image']);
        $object->setCategory($array['category']);
        $object->setAuthor($array['author']);
        $object->setDateCreated(DateTime::getDateTimeObjFromInt($array['date_created']));
        $object->setLastUpdate(DateTime::getDateTimeObjFromInt($array['last_update']));
        $object->setCardinality($array['cardinality']);
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
            $object->getPostType(),
            $object->getGuid(),
            $object->getTitle(),
            $object->getContent(),
            $object->getExcerpt(),
            is_object($object->getFeaturedImage()) ? $object->getFeaturedImage()->getId() : NULL,
            is_object($object->getCategory()) ? $object->getCategory()->getId() : NULL,
            $object->getAuthor()->getId(),
            $object->getDateCreated()->getDateTimeInt(),
            $object->getLastUpdate()->getDateTimeInt(),
            $object->getCardinality(),
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
            $object->getPostType(),
            $object->getGuid(),
            $object->getTitle(),
            $object->getContent(),
            $object->getExcerpt(),
            is_object($object->getFeaturedImage()) ? $object->getFeaturedImage()->getId() : NULL,
            is_object($object->getCategory()) ? $object->getCategory()->getId() : NULL,
            $object->getAuthor()->getId(),
            $object->getDateCreated()->getDateTimeInt(),
            $object->getLastUpdate()->getDateTimeInt(),
            $object->getCardinality(),
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