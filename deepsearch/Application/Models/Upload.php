<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:02 PM
 */

namespace Application\Models;

use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

class Upload extends A_DomainObject implements I_StatefulObject
{
    private $author;
    private $upload_time;
    private $location;
    private $file_name;
    private $file_size;
    private $status;

    /**
     * Upload constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
        $this->setStatus(self::STATUS_PENDING);
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        return $this->getLocation()."/".$this->getFileName();
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        if(! is_object($this->author))
        {
            $this->author = User::getMapper("User")->find($this->author);
        }
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Upload
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUploadTime()
    {
        return $this->upload_time;
    }

    /**
     * @param mixed $upload_time
     * @return Upload
     */
    public function setUploadTime(DateTime $upload_time)
    {
        $this->upload_time = $upload_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return Upload
     */
    public function setLocation($location)
    {
        $this->location = $location;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     * @return Upload
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * @param mixed $file_size
     * @return Upload
     */
    public function setFileSize($file_size)
    {
        $this->file_size = $file_size;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Upload
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}