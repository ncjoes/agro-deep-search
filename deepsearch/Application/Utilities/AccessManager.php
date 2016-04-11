<?php
namespace Application\Utilities;

use Application\Models\User;
use Application\Models\Session;
use System\Request\RequestContext;
use System\Utilities\DateTime;

//handles all aspects of authentication and authorization
/**
 * Class AccessManager
 * @package Application\Utilities
 */
class AccessManager
{
    private static $instance;
    private $message = null;
    private $host_name;
    private $cookie_name;

    /**
     * AccessManager constructor.
     */
    private function __construct()
    {
        $this->host_name = site_info('host-name', 0);
        $this->cookie_name = site_info('cookie-name', 0);
    }

    /**
     * @return AccessManager
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
     * @param $string
     * @return string $hash
     */
    public static function hashString($string)
    {
        $hashed_string = md5($string);
        return $hashed_string;
    }

    /**
     * @param RequestContext $requestContext
     * @param $username
     * @param $password
     * @return bool
     */
    public function login(RequestContext $requestContext, $username, $password)
    {
        if(!strlen($username) or !strlen($password))
        {
            $this->setMessage("Please supply a valid email/phone and password");
            return false;
        }

        $user_object = null;

        if(validate_email($username)){ $user_object = User::getMapper("User")->findByEmail($username); }
        elseif(validate_phone($username)){ $user_object = User::getMapper("User")->findByPhone($username); }
        else{
            $this->setMessage("Invalid Email/Phone");
            return false;
        }

        $password = $this->hashString($password);

        if(is_null($user_object))
        {
            $this->setMessage("Email/Phone ($username) not found.");
            return false;
        }
        elseif($user_object->getPassword() !== $password)
        {
            $this->setMessage("Invalid password !");
            return false;
        }
        elseif(is_object($user_object))
        {
            if($user_object->getStatus() == User::STATUS_INACTIVE)
            {
                $this->setMessage("This account has not been activated. Follow the link in the email sent to {$user_object->getEmail()} to activate  your account.");
                return false;
            }

            $default_privilege = $user_object->getDefaultPrivilege();
            if(! is_object($default_privilege))
            {
                $this->setMessage("This account has been locked. Please contact the admin for more information.");
                return false;
            }

            $this->startNewSession($requestContext, $user_object, $default_privilege->getPrivilege());
            $this->setMessage("Login successful");
            return true;
        }
        else//an internal error has probably occurred
        {
            $this->setMessage("Login attempt failed. Please try again later.<br/>If problem persists, contact the site administrator.");
        }
        return false;
    }

    /**
     * @param RequestContext $requestContext
     * @return bool
     */
    public function validateSession(RequestContext $requestContext)
    {
        $session_id = $requestContext->getCookie($this->cookie_name);
        $current_ip = $_SERVER['REMOTE_ADDR'];

        if(! is_null($session_id))
        {
            $session = Session::getMapper('Session')->find($session_id);
            if(
                is_object($session) and
                $session->getStatus() == Session::STATUS_ON and
                $session->getIpAddress() == $current_ip
            )
            {
                $session->setLastActivityTime(new DateTime());
                $requestContext->setSession($session);
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $session_id
     */
    public function logout($session_id)
    {
        $session = Session::getMapper('Session')->find($session_id);
        if(! is_null($session))
        {
            $session->setStatus(Session::STATUS_OFF);
        }
    }

    /**
     * @param RequestContext $requestContext
     * @param User $UserObj
     * @param integer $privilege
     * @return bool
     */
    private function startNewSession(RequestContext $requestContext, User $UserObj, $privilege)
    {
        $session = new Session();
        $session->setUser($UserObj);
        $session->setPrivilege($privilege);
        $session->setStartTime(new DateTime())->setLastActivityTime(new DateTime());
        $session->setUserAgent($_SERVER['HTTP_USER_AGENT'])->setIpAddress($_SERVER['REMOTE_ADDR']);
        $session->setStatus(Session::STATUS_ON);
        $session->mapper()->insert($session);

        if(setcookie( $this->cookie_name, $session->getId(), null, '/', $this->host_name) )
        {

            //TODO log this event

            $requestContext->setSession($session);
            $this->setMessage("Session started successfully");
            return true;
        }
        else//cookie could not be set
        {
            $session->mapper()->delete($session);
            $this->setMessage("Cookies could not be set. Please check your browser settings.");
        }
        return false;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}