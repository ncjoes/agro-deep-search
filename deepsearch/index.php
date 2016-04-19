<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

//Load Pre-run functions and classes
require("__autoload.php");

//Run Application
use \System\Exceptions;
use \System\Request\RequestContext;
use \System\Controllers\FrontController;

$requestContext = RequestContext::instance();

try
{
    if($_SERVER['HTTP_HOST'] != site_info('host-name',false))
    {
        header('Location:'.home_url('/',false));
    }

    $request_url = $requestContext->getRequestUrl();

    if(isset($ROUTES[$request_url])) header('Location:'.home_url('/'.$ROUTES[$request_url], 0));

    if(is_file($request_url))
    {
        $request_url_components = explode('/', $request_url);
        $file_path = dirname($request_url);
        $file_name = $request_url_components[sizeof($request_url_components)-1];

        if( ! in_array($request_url, $NO_READ) and ! in_array($file_path, $NO_READ) and ! in_array($file_name, $NO_READ) )
        {
            //echo $request_url;
            readfile($request_url);
            exit;
        }
    }

    FrontController::run();
}
catch (Exceptions\CommandNotFoundException $exception)
{
    $response = $exception->getMessage();
    if(site_info('development-mode',false)==true){$response .= "<br/>".recursive_implode("<br/>", $exception->getTrace());}

    $data = array('page-title'=>'404: Not Found', 'message'=>$response);
    $requestContext->setResponseData($data);
    $requestContext->setView('page-error.php');
}
catch (Exceptions\FormFieldNotFoundException $exception){}
catch (\PDOException $exception)
{
    $response = $exception->getMessage();
    if(site_info('development-mode',false)==true){$response .= "<br/>".recursive_implode("<br/>", $exception->getTrace());}

    $data = array('page-title'=>'Database Error', 'message'=>$response);
    $requestContext->setResponseData($data);
    $requestContext->setView('page-error.php');
}
catch (\Exception $exception)
{
    $response = $exception->getMessage();
    if(site_info('development-mode',false)==true){$response .= "<br/>".recursive_implode("<br/>", $exception->getTrace());}

    $data = array('page-title'=>'Internal Error', 'message'=>$response);
    $requestContext->setResponseData($data);
    $requestContext->setView('page-error.php');
}

$requestContext->invokeView();