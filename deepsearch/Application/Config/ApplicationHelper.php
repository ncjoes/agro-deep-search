<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace Application\Config;

class ApplicationHelper
{
    private static $instance;
    private function __construct(){}

    static function instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //initialize Application
    function init()
    {
        date_default_timezone_set('Africa/Lagos');
    }
}