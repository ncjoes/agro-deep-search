<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace Application\Controllers;

use System\Request\RequestContext;
use Application\Utilities\AccessManager;

class Logout_Controller extends A_Controller
{
    protected function doExecute(RequestContext $requestContext)
    {
        $requestContext->setView('index.php');

        if(! is_null($requestContext->getSession()))
        {
            $manager = AccessManager::instance();
            $manager->logout($requestContext->getSession()->getId());
            $redirect = $requestContext->fieldIsSet('redirect',INPUT_GET) ? $requestContext->getField('redirect',INPUT_GET) : home_url('/login/', false);
            $requestContext->redirect($redirect);
        }
    }
}