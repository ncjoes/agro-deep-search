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


/**
 * Class Form
 * @package Application\Models
 */
/**
 * Class Form
 * @package Application\Models
 */
class Form extends A_DomainObject
{
    private $page_link;
    private $form_markup;
    private $relevance;

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
     * @return PageLink
     */
    public function getPageLink()
    {
        return $this->page_link;
    }

    /**
     * @param PageLink $page_link
     * @return Form
     */
    public function setPageLink(PageLink $page_link)
    {
        $this->page_link = $page_link;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormMarkup()
    {
        return $this->form_markup;
    }

    /**
     * @param mixed $form_markup
     * @return Form
     */
    public function setFormMarkup($form_markup)
    {
        $this->form_markup = $form_markup;
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