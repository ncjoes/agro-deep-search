<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    11:44 AM
 */

namespace Application\Models;


/**
 * Class PostCategory
 * @package Application\Models
 */
class PostCategory extends A_NamedStatefulObject
{
    private $guid;
    private $parent;

    const TYPE_POST = 'post';

    const STATUS_VALID = 1;
    const STATUS_DELETED = 0;
    /**
     * PostCategory constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param $guid
     * @return $this
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        if(! is_object($this->parent))
        {
            $this->parent = $this->mapper()->find($this->parent);
        }
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return PostCategory
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->markDirty();
        return $this;
    }
}