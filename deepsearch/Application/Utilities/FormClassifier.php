<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/21/2016
 * Time:    2:16 PM
 **/


namespace Application\Utilities;


class FormClassifier
{
    private static $instance;

    private function __construct()
    {
    }

    public static function instance()
    {
        if( ! isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

}