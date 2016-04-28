<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Request;

use System\Models\DomainObjectWatcher;
use System\Exceptions;
use Application\Models\Session;
use Application\Utilities\AccessManager;

class RequestContext
{
    private static $instance;

    private $session;
    private $request_url;
    private $request_url_params;
    private $request_commands = array();
    private $request_data = array();
    private $request_cookies = array();
    private $request_files = array();
    private $flash_data = "";
    private $response_data = array();
    private $views_directory;
    private $view;


    /**
     * @return RequestContext
     */
    public static function instance()
    {
        if( ! isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * RequestContext constructor.
     */
    private function __construct()
    {
        //capture relevant inputs
        $this->request_cookies = $_COOKIE;
        $this->request_files = &$_FILES;
        $post_input_array = $_POST;
        $get_input_array = $_GET;

        //sanitize inputs
        $this->sanitizeInput($post_input_array);
        $this->sanitizeInput($get_input_array);

        //store inputs
        $this->setRequestData($post_input_array,INPUT_POST);
        $this->setRequestData($get_input_array, INPUT_GET);

        $this->setRequestUrl( site_info('deployment-path',false) , ""); //no slashes at the end of address
        $this->request_url_params = $this->processRequestUrlIntoArray();

        $this->views_directory = site_info('views-directory', false);
        $this->addControl( isset($this->request_url_params[0]) ? $this->request_url_params[0] : "Default" );
    }

    /**
     * @param $array
     */
    private function sanitizeInput(&$array)
    {
        if ($array !== FALSE && $array !== null)
        {
            foreach ($array as $key => $value)
            {
                if (is_array($array[$key]))
                {
                    $this->sanitizeInput($array[$key]);
                }
                else
                {
                    $array[$key] = html_entity_decode($array[$key]);
                }
            }
        }
    }

    /**
     * @param $array
     * @param $request_type
     */
    private function setRequestData($array, $request_type)
    {
        if(!empty($array) and $array !== FALSE && $array !== null)
        {
            $this->request_data[$request_type] = $array;
        }
    }

    /**
     * @return array
     */
    private function processRequestUrlIntoArray()
    {
        $raw = explode("/", $this->request_url);
        $processed = array();
        foreach($raw as $param)
        {
            if(strlen($param)) $processed[] = $param;
        }
        return $processed;
    }

    /**
     * @param $url
     * @param bool $replace
     */
    public function redirect($url, $replace=true)
    {
        DomainObjectWatcher::instance()->performOperations();
        header("Location:{$url}", $replace);
    }

    /**
     *
     */
    public function redirectIfSessionExists()
    {
        $possible_session = $this->getSession();
        if(! is_null($possible_session))
        {
            $user = $possible_session->getUser();
            $privilege = $user->getDefaultPrivilege();
            $redirect_url = home_url( '/'.$privilege->defaultController(), false );
            $this->redirect($redirect_url);
        }
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        if(!isset($this->session))
        {
            AccessManager::instance()->validateSession($this);
        }
        return $this->session;
    }

    /**
     * @param Session $session
     * @return $this
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return implode('/' , $this->request_url_params);
    }

    /**
     * @param string $replace_path
     * @param string $replacement
     */
    private function setRequestUrl($replace_path='', $replacement='')
    {
        $complete_url = $_SERVER['REQUEST_URI'];
        $complete_url_arr = explode('?', $complete_url);
        $fore_q_mark = $complete_url_arr[0];
        $this->request_url = substr( str_ireplace($replace_path, $replacement, $fore_q_mark) , 1);
    }

    /**
     * @param $url
     * @return bool
     */
    public function isRequestUrl($url)
    {
        return ( strtolower($url) == strtolower($this->getRequestUrl()) or strtolower($url)==strtolower($this->getRequestUrlParam(0)));
    }

    /**
     * @param $index
     * @return mixed || null
     */
    public function getRequestUrlParam($index)
    {
        if(isset($this->request_url_params[(int)$index]))
        {
            return $this->request_url_params[$index];
        }
        return null;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function addControl($command)
    {
        $this->request_commands[] = $command;
        return $this;
    }

    /**
     * @return array
     */
    public function getControlChain()
    {
        return $this->request_commands;
    }

    /**
     * @return $this
     */
    public function resetControlChain()
    {
        $this->request_commands = array();
        return $this;
    }

    /**
     * @param $field_name
     * @param $request_type
     * @return bool
     */
    public function fieldIsSet($field_name, $request_type)
    {
        if(isset($this->request_data[$request_type][$field_name]))
        {
            return true;
        }
        return false;
    }

    /**
     * @param $field_name
     * @param $request_type
     * @return mixed
     * @throws Exceptions\FormFieldNotFoundException
     */
    public function getField($field_name, $request_type)
    {
        if(isset($this->request_data[$request_type][$field_name]))
        {
            return $this->request_data[$request_type][$field_name];
        }
        throw new Exceptions\FormFieldNotFoundException("field '{$field_name}' not found in current request context");
    }

    /**
     * @param $request_type
     * @return mixed || array
     */
    public function getAllFields($request_type)
    {
        if(isset($this->request_data[$request_type]))
        {
            return $this->request_data[$request_type];
        }
        return null;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getCookie($name)
    {
        if(isset( $this->request_cookies[$name] ))
        {
            return $this->request_cookies[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAllCookies()
    {
        return $this->request_cookies;
    }

    /**
     * @param $name
     * @return null
     */
    public function getFile($name)
    {
        if(isset( $this->request_files[$name] ))
        {
            return $this->request_files[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAllFiles()
    {
        return $this->request_files;
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        return $this->response_data;
    }

    /**
     * @param array $data
     * @return RequestContext
     */
    public function setResponseData(array $data)
    {
        $this->response_data = array_merge($this->response_data, $data);
        return $this;
    }

    /**
     * @return string
     */
    public function getFlashData()
    {
        return $this->flash_data;
    }

    /**
     * @param string $flash_data
     * @return RequestContext
     */
    public function setFlashData($flash_data)
    {
        $this->flash_data = $flash_data;
        return $this;
    }

    /**
     * @return null
     */
    public function getView()
    {
        if(isset($this->view))
        {
            return $this->view;
        }
        return null;
    }

    /**
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     *
     */
    public function invokeView()
    {
        if($this->viewExists($this->getView()))
        {
            require_once($this->views_directory."/".$this->getView());
        }
        else
        {
            echo "<h1>File Not Found.</h1><h4>{$this->views_directory}/{$this->getView()}</h4>";
        }
    }

    /**
     * @param $view
     * @return bool
     */
    public function viewExists($view)
    {
        return (is_file($this->views_directory."/".$view)) ? true : false;
    }
}