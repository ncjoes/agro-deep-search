<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    10:33 PM
 */

namespace Application\Models\Mappers;

use \System\Models\Mappers\Mapper as SystemMapper;

/**
 * Class A_Mapper
 * @package Application\Models\Mappers
 */
abstract class A_Mapper extends SystemMapper
{
    /**
     * A_Mapper constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}