<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    10:16 PM
 **/


namespace Application\Models;


/**
 * Class CrawlSetting
 * @package Application\Models
 */
/**
 * Class CrawlSetting
 * @package Application\Models
 */
class CrawlSetting extends A_DomainObject
{
    private $var_name;
    private $current_value;
    private $default_value;
    private $multi_valued = false;

    /**
     * CrawlSetting constructor.
     * @param null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getVarName()
    {
        return $this->var_name;
    }

    /**
     * @param mixed $var_name
     * @return CrawlSetting
     */
    public function setVarName($var_name)
    {
        $this->var_name = $var_name;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentValue()
    {
        return $this->current_value;
    }

    /**
     * @param mixed $current_value
     * @return CrawlSetting
     */
    public function setCurrentValue($current_value)
    {
        $this->current_value = $current_value;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }

    /**
     * @param mixed $default_value
     * @return CrawlSetting
     */
    public function setDefaultValue($default_value)
    {
        $this->default_value = $default_value;
        $this->markDirty();
        return $this;
    }

    /**
     * @return boolean
     */
    public function isMultiValued()
    {
        return $this->multi_valued;
    }

    /**
     * @param boolean $multi_valued
     * @return CrawlSetting
     */
    public function setMultiValued($multi_valued)
    {
        $this->multi_valued = $multi_valued;
        $this->markDirty();
        return $this;
    }
}