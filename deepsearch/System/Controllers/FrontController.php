<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Controllers;

use \Application\Config\ApplicationHelper;
use \System\Models\DomainObjectWatcher;
use \Application\Controllers;
use \Application\Models;
use \System\Exceptions;
use \System\Request\RequestContext;

/**
 * Class FrontController
 * @package System\A_Controller
 */
final class FrontController
{
    /**
     * @var string
     * Directory of Page Controllers in Applications
     */
    private static $dir = "Application\\Controllers";

    /**
     * FrontController constructor.
     */
    private function __construct() {}

    /**
     *
     */
    public static function run()
    {
        $instance = new self();
        $instance->init();
        $instance->handleRequest();
    }

    /**
     *
     */
    public function init()
    {
        $applicationHelper = ApplicationHelper::instance();
        $applicationHelper->init();
    }

    /**
     *
     */
    public function handleRequest()
    {
        $requestContext = RequestContext::instance();
        $this->r_run($requestContext);
        DomainObjectWatcher::instance()->performOperations();
    }

    /**
     * @param RequestContext $requestContext
     * @param int $start
     */
    private function r_run(RequestContext $requestContext, $start=0)
    {
        //recursively run commands in a dynamic array
        $ctrl_chain = $requestContext->getControlChain();
        if(isset($ctrl_chain[$start]))
        {
            $this->getController( $ctrl_chain[$start] )->execute( $requestContext );
            $this->r_run($requestContext, ++$start);
        }
    }

    /**
     * @param string $action
     * @return Controller
     * @throws Exceptions\CommandNotFoundException
     * @throws \Exception
     */
    public function getController($action='Default' )
    {
        if ( preg_match( '/\W-/', $action ) )
        {
            throw new \Exception("Sorry, your request could not be understood.");
        }

        $action = strlen($action) ? $action : 'Default';

        $class_name = str_replace(' ','',ucwords( strtolower( str_replace('-',' ',$action) ) ) ).'_Controller';

        $file = (!empty(self::$dir)) ? self::$dir."\\".$class_name.'.php' : $class_name.'.php';
        if ( ! file_exists( $file ) )
        {
            //print_r($file);
            throw new Exceptions\CommandNotFoundException( "<br/>Can not find file ($file)" );
        }

        $class = self::$dir."\\{$class_name}";
        if ( ! class_exists( $class ) )
        {
            throw new Exceptions\CommandNotFoundException( "<br/>Can not find class: $class" );
        }
        $controller = new $class();
        return $controller;
    }
}