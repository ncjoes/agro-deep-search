<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    9:26 PM
 */

namespace Application\Controllers;

use System\Request\RequestContext;
use Application\Models\UserPrivilege;

abstract class A_RestrictedControl extends A_Controller
{
    protected function securityPass(RequestContext $requestContext, $allowed_privileges, $redirect_control)
    {
        $session = $requestContext->getSession();
        if(! is_null($session) and $session->isAuthorized($allowed_privileges))
        {
            return true;
        }
        elseif(! is_null($session) and !$session->isAuthorized($allowed_privileges))
        {
            $requestContext->redirect( home_url( '/'.UserPrivilege::getDefaultController($session->getPrivilege()).'/', false ) );
        }
        else
        {
            $requestContext->redirect( home_url('/login/?redirect='.home_url('/'.$redirect_control, false), false) );
        }
        return false;
    }
}