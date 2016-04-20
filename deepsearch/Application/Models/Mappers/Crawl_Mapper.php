<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    10:38 PM
 **/


namespace Application\Models\Mappers;


use Application\Models;
use System\Utilities\DateTime;

class Crawl_Mapper extends A_Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_crawls WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_crawls");
        $this->selectByCrawlerIdStmt = self::$PDO->prepare("SELECT * FROM app_crawls WHERE crawler_id=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_crawls SET crawler_id=?, num_links_followed=?, num_documents_received=?, num_byte_received=?, process_run_time=?, start_time=?, end_time=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_crawls (crawler_id,num_links_followed,num_documents_received,num_byte_received,process_run_time,start_time,end_time,status)VALUES(?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_crawls WHERE id=?");
    }

    /**
     * @param $crawler_id
     * @return \System\Models\Collections\Collection
     */
    public function findByCrawlerId($crawler_id)
    {
        return $this->findHelper($crawler_id, $this->selectByCrawlerIdStmt);
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\Crawl";
    }

    /**
     * @param array $array
     * @return Models\CrawlSetting
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setCrawlerId($array['crawler_id']);
        $object->setNumLinksFollowed($array['num_links_followed']);
        $object->setNumDocumentsReceived($array['num_documents_received']);
        $object->setNumByteReceived($array['num_bytes_received']);
        $object->setProcessRunTime($array['process_run_time']);
        $object->setStartTime(new DateTime($array['start_time']));
        $object->setEndTime(new DateTime($array['end_time']));
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
            $object->getCrawlerId(),
            $object->getNumLinksFollowed(),
            $object->getNumDocumentsReceived(),
            $object->getNumByteReceived(),
            $object->getProcessRunTime(),
            $object->getStartTime()->getDateTimeInt(),
            is_object($object->getEndTime()) ? $object->getEndTime()->getDateTimeInt() : NULL,
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
            $object->getCrawlerId(),
            $object->getNumLinksFollowed(),
            $object->getNumDocumentsReceived(),
            $object->getNumByteReceived(),
            $object->getProcessRunTime(),
            $object->getStartTime()->getDateTimeInt(),
            is_object($object->getEndTime()) ? $object->getEndTime()->getDateTimeInt() : NULL,
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