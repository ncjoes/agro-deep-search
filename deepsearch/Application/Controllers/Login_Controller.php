<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace Application\Controllers;

use Application\Models\UserPrivilege;
use Application\Utilities\AccessManager;
use System\Request\RequestContext;

/**
 * Class Login_Controller
 * @package Application\Controllers
 */
class Login_Controller extends A_Controller
{
    /**
     * @param RequestContext $requestContext
     */
    protected function doExecute(RequestContext $requestContext)
    {
        $requestContext->redirectIfSessionExists();
        $data = array('page-title'=>"Login");
        $requestContext->setView('page-login.php');
        $requestContext->setResponseData($data);

        if($requestContext->fieldIsSet('login', INPUT_POST))
        {
            $this->doLogin($requestContext);
        }
    }

    /**
     * @param RequestContext $requestContext
     * @throws \System\Exceptions\FormFieldNotFoundException
     */
    private function doLogin(RequestContext $requestContext)
    {
        $username = $requestContext->getField('username', INPUT_POST);
        $password = $requestContext->getField('password', INPUT_POST);
        $manager = AccessManager::instance();
        $logged_in = $manager->login($requestContext, $username, $password);

		if( $logged_in )
        {
            $session = $requestContext->getSession();
            if(is_object($session))
            {
                $command = UserPrivilege::getDefaultController($session->getPrivilege());
                $redirect = $requestContext->fieldIsSet('redirect', INPUT_GET) ? $requestContext->getField('redirect', INPUT_GET) : home_url('/'.$command.'/', 0);
                $requestContext->redirect($redirect);
            }
            $requestContext->setFlashData("Internal System Error");
            //TODO: Log this event
        }
        $requestContext->setFlashData( $manager->getMessage() );
	}
}