<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/19/2016
 * Time:    5:29 AM
 **/


namespace Application\Models\Mappers;


use Application\Models;
use System\Utilities\DateTime;

class PageLink_Mapper extends A_Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_page_links WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_page_links ORDER BY ext_reward DESC");
        $this->selectRangeStmt = self::$PDO->prepare("SELECT * FROM app_page_links ORDER BY ext_reward DESC LIMIT :num_rows OFFSET :offset");
        $this->selectByUrlHashStmt = self::$PDO->prepare("SELECT * FROM app_page_links WHERE url_hash=?");
        $this->selectByParentPageLinkStmt = self::$PDO->prepare("SELECT * FROM app_page_links WHERE parent_page_link=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_page_links SET url=?, url_hash=?, anchor=?, around_text=?, page_title=?, parent_page_link=?, last_crawl_time=?, target_distance=?, ext_reward=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_page_links (url,url_hash,anchor,around_text,page_title,parent_page_link,last_crawl_time,target_distance,ext_reward,status)VALUES(?,?,?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_page_links WHERE id=?");
    }

    /**
     * @param int $num_rows number of records to retrieve
     * @param int $offset offset from the first record
     * @return \System\Models\Collections\Collection
     */
    public function findRange($num_rows=10, $offset=0)
    {
        $this->selectRangeStmt->bindParam(':num_rows', $num_rows, \PDO::PARAM_INT);
        $this->selectRangeStmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $this->selectRangeStmt->execute();
        $raw_data = $this->selectRangeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $url_hash
     * @return \System\Models\Collections\Collection
     */
    public function findByUrlHash($url_hash)
    {
        return $this->findHelper($url_hash, $this->selectByUrlHashStmt, 'id');
    }

    /**
     * @param $parent_page_link
     * @return \System\Models\Collections\Collection
     */
    public function findByParentPageLink($parent_page_link)
    {
        $this->selectByParentPageLinkStmt->execute( array($parent_page_link) );
        $raw_data = $this->selectByParentPageLinkStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\PageLink";
    }

    /**
     * @param array $array
     * @return Models\CrawlSetting
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setUrl($array['url']);
        $object->setAnchor($array['anchor']);
        $object->setAroundText($array['around_text']);
        $object->setPageTitle($array['page_title']);
        $object->setParentPageLink($array['parent_page_link']);
        if(is_int($array['last_crawl_time']))$object->setLastCrawlTime(new DateTime($array['last_crawl_time']));
        $object->setTargetDistance($array['target_distance']);
        $object->setExpectedReward($array['ext_reward']);
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
            $object->getUrl(),
            $object->getUrlHash(),
            $object->getAnchor(),
            $object->getAroundTextStr(),
            $object->getPageTitle(),
            is_object($object->getParentPageLink()) ? $object->getParentPageLink()->getId() : $object->getParentPageLink(),
            is_object($object->getLastCrawlTime()) ? $object->getLastCrawlTime()->getDateTimeInt() : NULL,
            $object->getTargetDistance(),
            $object->getExpectedReward(),
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
            $object->getUrl(),
            $object->getUrlHash(),
            $object->getAnchor(),
            $object->getAroundTextStr(),
            $object->getPageTitle(),
            is_object($object->getParentPageLink()) ? $object->getParentPageLink()->getId() : $object->getParentPageLink(),
            is_object($object->getLastCrawlTime()) ? $object->getLastCrawlTime()->getDateTimeInt() : NULL,
            $object->getTargetDistance(),
            $object->getExpectedReward(),
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