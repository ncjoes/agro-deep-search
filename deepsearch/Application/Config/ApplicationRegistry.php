<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace Application\Config;

class ApplicationRegistry
{
    static private $instance;
    static private $dsn = "mysql:dbname=www_nwubanfarms_deepsearch;host=localhost";
    static private $db_user = "root";
    static private $db_user_password = "";
    static private $site_info = array(
        'charset'               => "UTF-8",
        'host-name'             => "127.0.0.1",
        'cookie-name'           => "DS_SESSION_ID",
        'site-url'              => "http://127.0.0.1/www/PhoenixLabs/nwubanfarms.com/deepsearch",
        'deployment-path'       => 'www/PhoenixLabs/nwubanfarms.com/deepsearch',
        'views-directory'       => 'Application/Views',
        'stylesheet-url'        => "Assets/css/style.css",
        'name'                  => "Nwuban Farms DeepSearch",
        'short-name'            => "DeepSearch",
        'contact-email'         => "info@nwubanfarms.com",
        'contact-phone'         => "",
        'webmail-url'           => "http://mailbox.nwubanfarms.com/",
        'facebook-page'         => "http://facebook.com/nwubanfarms/",
        'youtube-channel'       => "#",
        'twitter-handle'        => "#",
        'google-plus'           => "#",
        'designer-url'          => "https://ng.linkedin.com/in/jcnwobodo",
        'designer-name'         => "C. Joseph (Fibonacci)",
        'contractor-url'        => "#",
        'development-mode'      => false
    );

    private function __construct(){}

    static function instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static function getDSN()
    {
        return self::$dsn;
    }

    static function getDbUser()
    {
        return self::$db_user;
    }

    static function getDbUserPassword()
    {
        return self::$db_user_password;
    }

    static function siteInfo()
    {
        return self::$site_info;
    }
}