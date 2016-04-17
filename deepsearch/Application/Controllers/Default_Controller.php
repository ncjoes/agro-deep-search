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


/**
 * Class Default_Controller
 * @package Application\Controllers
 */
class Default_Controller extends A_Controller
{
    /**
     * @param RequestContext $requestContext
     */
    protected function doExecute(RequestContext $requestContext)
    {
        $data = array('page-title'=>"Nwuban Farms");

        $requestContext->setResponseData($data);
        $requestContext->setView('index.php');
    }
}