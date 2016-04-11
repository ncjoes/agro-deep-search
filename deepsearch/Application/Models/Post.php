<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: thehouseoflaws.org
 * Date:    10/24/2015
 * Time:    12:51 PM
 */

namespace Application\Models;

use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

/**
 * Class Post
 * @package Application\Models
 */
class Post extends A_StatefulObject
{
    private $post_type;
    private $guid;
    private $title;
    private $content;
    private $excerpt;
    private $featured_image = null;
    private $category = null;
    private $author;
    private $date_created;
    private $last_update;
    private $cardinality;

    const TYPE_POST = 1;
    const TYPE_ABOUT = 2;
    const TYPE_OTHER = 4;

    /**
     * Post constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getPostType()
    {
        return $this->post_type;
    }

    /**
     * @param $post_type
     * @return $this
     */
    public function setPostType($post_type)
    {
        $this->post_type = $post_type;
        $this->markDirty();
        return $this;
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
        $this->guid = strtolower(str_replace(array(' ','/'), array('-','-'), $guid));
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExcerpt()
    {
        return (strlen($this->excerpt) ? $this->excerpt : sub_words($this->content,0,150) );
    }

    /**
     * @param $excerpt
     * @return $this
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeaturedImage()
    {
        if(! is_object($this->featured_image))
        {
            $this->featured_image = Upload::getMapper("Upload")->find($this->featured_image);
        }
        return $this->featured_image;
    }

    /**
     * @param Upload $featured_image
     * @return $this
     */
    public function setFeaturedImage($featured_image)
    {
        $this->featured_image = $featured_image;
        $this->markDirty();
        return $this;
    }

    /**
     * @return null
     */
    public function getCategory()
    {
        if(! is_object($this->category))
        {
            $this->category = PostCategory::getMapper("PostCategory")->find($this->category);
        }
        return $this->category;
    }

    /**
     * @param PostCategory $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        $this->markDirty();
        return $this;
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
     * @param User $author
     * @return $this
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
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param DateTime $date_created
     * @return $this
     */
    public function setDateCreated(DateTime $date_created)
    {
        $this->date_created = $date_created;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param DateTime $last_update
     * @return $this
     */
    public function setLastUpdate(DateTime $last_update)
    {
        $this->last_update = $last_update;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardinality()
    {
        if((int)$this->cardinality < 1)
        {
            $this->cardinality = 1;
        }
        return $this->cardinality;
    }

    /**
     * @param mixed $cardinality
     * @return Post
     */
    public function setCardinality($cardinality)
    {
        $this->cardinality = $cardinality;
        $this->markDirty();
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->getStatus() == self::STATUS_PUBLISHED;
    }
}