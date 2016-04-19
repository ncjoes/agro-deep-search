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
class CrawlSetting extends A_DomainObject
{
    private $var_name;
    private $current_value;
    private $default_value;

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
        return $this;
    }
}