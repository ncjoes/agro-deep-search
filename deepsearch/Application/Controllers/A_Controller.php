<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    10:57 PM
 */

namespace Application\Controllers;


use System\Controllers\Controller;
use System\Request\RequestContext;

abstract class A_Controller extends Controller
{
    public function execute(RequestContext $requestContext)
    {
        $data = array();
        $data['search-term'] = $requestContext->fieldIsSet('search',INPUT_GET) ? $requestContext->getField('search',INPUT_GET) : '';
        $requestContext->setResponseData($data);

        parent::execute($requestContext);
    }
}