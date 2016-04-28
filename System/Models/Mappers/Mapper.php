<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models\Mappers;

use \Application\Config\ApplicationRegistry;
use \Application\Models\A_DomainObject;
use \System\Models\DomainObjectWatcher;
use \System\Models\Collections\Collection;

/**
 * Class Mapper
 * @package System\Models\Mappers
 */
abstract class Mapper
{
    protected static $PDO;

    /**
     * Mapper constructor.
     */
    public function __construct()
    {
        self::getPDO();
    }

    /**
     * @return \PDO
     * @throws \Exception
     */
    public static function getPDO()
    {
        if ( ! isset(self::$PDO) )
        {
            $dsn = ApplicationRegistry::getDSN();
            $user = ApplicationRegistry::getDbUser();
            $password = ApplicationRegistry::getDbUserPassword();

            if ( is_null( $dsn ) )
            {
                throw new \Exception( "No DSN" );
            }
            self::$PDO = new \PDO($dsn, $user, $password);
            self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$PDO;
    }
    /**
     * @param $id
     * @return mixed
     */
    public final function find($id )
    {
        return $this->findHelper($id, $this->selectStmt());
    }

    /**
     * @return Collection
     */
    public final function findAll( )
    {
        $this->selectAllStmt()->execute( array() );
        return $this->getCollection($this->selectAllStmt()->fetchAll( \PDO::FETCH_ASSOC ) );
    }

    /**
     * @param array $array
     * @return A_DomainObject
     */
    public final function createObject($array )
    {
        $old = $this->getFromMap( $array['id']);
        if ( is_object($old) ) { return $old; }
        //construct object
        $obj = $this->doCreateObject( $array );
        //keep record of object
        $this->addToMap($obj);
        $obj->markClean();

        return $obj;
    }

    /**
     * @param A_DomainObject $domainObject
     */
    public final function insert(A_DomainObject $domainObject)
    {
        $this->doInsert( $domainObject );
        $this->addToMap( $domainObject );
        $domainObject->markClean();
    }

    /**
     * @param A_DomainObject $domainObject
     */
    public final function update(A_DomainObject $domainObject)
    {
        $this->doUpdate( $domainObject );
        $domainObject->markClean();
    }

    /**
     * @param A_DomainObject $domainObject
     */
    public final function delete(A_DomainObject $domainObject)
    {
        $this->doDelete( $domainObject );
        $domainObject->markClean();
    }

    /**
     * @param mixed $key
     * @param \PDOStatement $statement
     * @param string $compulsory_index
     * @return A_DomainObject || null
     */
    protected final function findHelper($key, \PDOStatement $statement, $compulsory_index = 'id')
    {
        $old = $this->getFromMap( $key );
        if ($old)
        {
            return $old;
        }
        //do db stuff
        $statement->execute( ( is_array($key) ? $key : array($key) ) );
        $array = $statement->fetch();
        $statement->closeCursor();
        if( ! is_array($array) )
        {
            return null;
        }
        if ( ! isset($array[$compulsory_index]) )
        {
            return null;
        }
        return $this->createObject($array);
    }

    /**
     * @param $id
     * @return A_DomainObject || null
     */
    protected final function getFromMap($id )
    {
        return DomainObjectWatcher::exists( $this->targetClass(), $id );
    }

    /**
     * @param A_DomainObject $obj
     */
    protected final function addToMap(A_DomainObject $obj )
    {
        DomainObjectWatcher::add( $obj );
    }

    /**
     * @param array $raw
     * @return Collection
     */
    protected final function getCollection(array $raw )
    {
        return new Collection($this, $raw);
    }

    /**
     * @return mixed
     */
    public abstract function targetClass();

    /**
     * @param array $array
     * @return mixed
     */
    protected abstract function doCreateObject(array $array );

    /**
     * @param A_DomainObject $object
     * @return mixed
     */
    protected abstract function doInsert(A_DomainObject $object );

    /**
     * @param A_DomainObject $object
     * @return mixed
     */
    protected abstract function doUpdate(A_DomainObject $object );

    /**
     * @param A_DomainObject $object
     * @return mixed
     */
    protected abstract function doDelete(A_DomainObject $object );

    /**
     * @return mixed
     */
    protected abstract function selectStmt();

    /**
     * @return mixed
     */
    protected abstract function selectAllStmt();
}