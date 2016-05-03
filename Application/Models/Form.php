<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/15/2016
 * Time:    12:34 AM
 **/


namespace Application\Models;
use Application\Utilities\A_Utility;


/**
 * Class Form
 * @package Application\Models
 */
class Form extends A_DomainObject
{
    private $link;
    private $text;
    private $hash = null;
    private $markup;
    private $relevance = null;

    const REL_NEGATIVE = -1;
    const REL_UNKNOWN = 0;
    const REL_POSITIVE = 1;

    /**
     * Form constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return Link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param Link $link
     * @return Form
     */
    public function setLink(Link $link)
    {
        $this->link = $link;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return mixed
     */
    public function getMarkup()
    {
        return $this->markup;
    }

    /**
     * @param mixed $markup
     * @return Form
     */
    public function setMarkup($markup)
    {
        $this->markup = A_Utility::trimFormMarkup($markup);
        strip_tags_rv($this->markup);
        $this->text = recursive_str_replace(array("\n","\r"), " ", $this->markup);
        $this->text = recursive_str_replace("  ", " ", $this->text);
        $this->hash = md5($this->markup);
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelevance()
    {
        return $this->relevance;
    }

    /**
     * @param mixed $relevance
     * @return Form
     */
    public function setRelevance($relevance)
    {
        $this->relevance = $relevance;
        $this->markDirty();
        return $this;
    }
}