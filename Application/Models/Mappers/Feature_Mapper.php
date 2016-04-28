<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    11:02 PM
 **/


namespace Application\Models\Mappers;


use Application\Models;

/**
 * Class Feature_Mapper
 * @package Application\Models\Mappers
 */
class Feature_Mapper extends A_Mapper
{
    /**
     * Feature_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_features WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_features");
        $this->selectByContextStmt = self::$PDO->prepare("SELECT * FROM app_features WHERE context=?");
        $this->selectByMinAvgFreqStmt = self::$PDO->prepare("SELECT * FROM app_features WHERE avg_frequency=>?");
        $this->selectByContextAndMinAvgFreqStmt = self::$PDO->prepare("SELECT * FROM app_features WHERE context=? AND avg_frequency>=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_features SET term=?, context=?, avg_frequency=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_features (term,context,avg_frequency)VALUES(?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_features WHERE id=?");
    }

    /**
     * @param $context
     * @return \System\Models\Collections\Collection
     */
    public function findByContext($context)
    {
        $this->selectByContextStmt->execute( array($context) );
        $raw_data = $this->selectByContextStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $min_avg_freq
     * @return \System\Models\Collections\Collection
     */
    public function findByMinAvgFreq($min_avg_freq)
    {
        $this->selectByMinAvgFreqStmt->execute( array($min_avg_freq) );
        $raw_data = $this->selectByMinAvgFreqStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @param $context
     * @param $min_avg_freq
     * @return \System\Models\Collections\Collection
     */
    public function findByContextAndMinAvgFreq($context, $min_avg_freq)
    {
        $this->selectByContextAndMinAvgFreqStmt->execute( array($context, $min_avg_freq) );
        $raw_data = $this->selectByContextAndMinAvgFreqStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        return "Application\\Models\\Feature";
    }

    /**
     * @param array $array
     * @return Models\Crawl
     */
    protected function doCreateObject(array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setTerm($array['term']);
        $object->setContext($array['context']);
        $object->setAverageFrequency($array['avg_frequency']);

        return $object;
    }

    /**
     * @param Models\A_DomainObject $object
     * @return null
     */
    protected function doInsert(Models\A_DomainObject $object )
    {
        $values = array(
            $object->getTerm(),
            $object->getContext(),
            $object->getAverageFrequency()
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
            $object->getTerm(),
            $object->getContext(),
            $object->getAverageFrequency(),
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