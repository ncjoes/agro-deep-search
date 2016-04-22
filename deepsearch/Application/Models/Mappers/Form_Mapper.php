<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    11:28 PM
 **/


namespace Application\Models\Mappers;


use Application\Models;

/**
 * Class Form_Mapper
 * @package Application\Models\Mappers
 */
class Form_Mapper extends A_Mapper
{
    /**
     * Form_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_forms WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_forms");
        $this->selectByPageLinkStmt = self::$PDO->prepare("SELECT * FROM app_forms WHERE link=?");
        $this->selectByHashStmt = self::$PDO->prepare("SELECT * FROM app_forms WHERE hash=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_forms SET link=?, markup=?, relevance=?, hash=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_forms (link,markup,relevance,hash)VALUES(?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_forms WHERE id=?");
    }

    /**
     * @param $page_link
     * @return \System\Models\Collections\Collection
     */
    public function findByPageLink($page_link)
    {
        $this->selectByPageLinkStmt->execute( array($page_link) );
        $raw_data = $this->selectByPageLinkStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param string $hash
     * @return Models\A_DomainObject
     */
    public function findByHash($hash)
    {
        return $this->findHelper($hash, $this->selectByHashStmt, 'hash');
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\Form";
    }

    /**
     * @param array $array
     * @return Models\CrawlSetting
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setPageLink(Models\Link::getMapper("Link")->find($array['link']));
        $object->setFormMarkup($array['markup']);
        $object->setRelevance($array['relevance']);

        return $object;
    }

    /**
     * @param Models\A_DomainObject $object
     * @return null
     */
    protected function doInsert(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getLink()->getId(),
            $object->getFormMarkup(),
            $object->getRelevance(),
            $object->getHash()
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
            $object->getLink()->getId(),
            $object->getFormMarkup(),
            $object->getRelevance(),
            $object->getHash(),
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