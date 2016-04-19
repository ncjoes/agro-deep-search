<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/15/2016
 * Time:    12:27 AM
 **/


namespace Application\Models;


/**
 * Class Feature
 * @package Application\Models
 */
class Feature extends A_DomainObject
{
    private $term;
    private $context;
    private $average_frequency;

    const CONTEXT_URL = 1;
    const CONTEXT_ANCHOR = 2;
    const CONTEXT_S_TEXT = 3;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param string $term
     * @return Feature
     */
    public function setTerm($term)
    {
        $this->term = $term;
        $this->markDirty();
        return $this;
    }

    /**
     * @return int
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param int $context
     * @return Feature
     */
    public function setContext($context)
    {
        $this->context = $context;
        $this->markDirty();
        return $this;
    }

    /**
     * @return float
     */
    public function getAverageFrequency()
    {
        return $this->average_frequency;
    }

    /**
     * @param float $average_frequency
     * @return Feature
     */
    public function setAverageFrequency($average_frequency)
    {
        $this->average_frequency = $average_frequency;
        $this->markDirty();
        return $this;
    }
}