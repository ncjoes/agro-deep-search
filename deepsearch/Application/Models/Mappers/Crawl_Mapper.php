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
        $this->selectBySessionIdStmt = self::$PDO->prepare("SELECT * FROM app_crawls WHERE session_id=? AND status=? ORDER BY id DESC");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM app_crawls WHERE status=? ORDER BY id DESC");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE app_crawls SET 
                                  crawler_id=?, 
                                  session_id=?, 
                                  start_url=?,
                                  num_links_followed=?, 
                                  num_documents_received=?, 
                                  num_links_extracted=?,
                                  num_forms_extracted=?,
                                  num_bytes_received=?, 
                                  process_run_time=?, 
                                  start_time=?, 
                                  end_time=?, 
                                  status=? 
                    WHERE id=?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO app_crawls 
                        (crawler_id,session_id,start_url,num_links_followed,num_documents_received,num_links_extracted,num_forms_extracted,num_bytes_received,process_run_time,start_time,end_time,status)
                        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
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

    public function findBySessionId($session_id, $status=2)
    {
        $this->selectBySessionIdStmt->execute( array($session_id, $status) );
        $raw_data = $this->selectBySessionIdStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
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
        $object->setSessionId($array['session_id']);
        $object->setStartUrl($array['start_url']);
        $object->setNumLinksFollowed($array['num_links_followed']);
        $object->setNumDocumentsReceived($array['num_documents_received']);
        $object->setNumLinksExtracted($array['num_links_extracted']);
        $object->setNumFormsExtracted($array['num_forms_extracted']);
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
            $object->getSessionId(),
            is_object($object->getStartUrl()) ? $object->getStartUrl()->getId() : NULL,
            $object->getNumLinksFollowed(),
            $object->getNumDocumentsReceived(),
            $object->getNumLinksExtracted(),
            $object->getNumFormsExtracted(),
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
            $object->getSessionId(),
            is_object($object->getStartUrl()) ? $object->getStartUrl()->getId() : NULL,
            $object->getNumLinksFollowed(),
            $object->getNumDocumentsReceived(),
            $object->getNumLinksExtracted(),
            $object->getNumFormsExtracted(),
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