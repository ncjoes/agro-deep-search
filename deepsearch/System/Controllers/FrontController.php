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
    private $file_path;
    private $class_path;

    /**
     * FrontController constructor.
     */
    private function __construct()
    {
        $this->file_path = dirname(__FILE__);
        $path_components = explode(DIRECTORY_SEPARATOR, $this->file_path);
        $path_components[sizeof($path_components)-2] = "Application";
        $this->file_path = implode(DIRECTORY_SEPARATOR, $path_components);

        $this->class_path = "Application\\Controllers";
    }

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
        global $NO_READ;
        $action = strlen($action) ? $action : 'Default';

        if ( preg_match( '/\W-/', $action ) ) throw new \Exception("Sorry, your request could not be understood.");
        if ( in_array($action, $NO_READ) ) throw new Exceptions\CommandNotFoundException("Sorry, your request could not be understood.");

        $class_name = str_replace(' ','',ucwords( strtolower( str_replace('-',' ',$action) ) ) ).'_Controller';
        $file = $this->file_path.DIRECTORY_SEPARATOR.$class_name.'.php';
        $class = $this->class_path."\\{$class_name}";

        if ( ! file_exists( $file ) )  throw new Exceptions\CommandNotFoundException( "Page /{$action} not found.");
        if ( ! class_exists( $class ) )  throw new \Exception( "Can not find Class: {$class}" );

        return new $class();
    }
}