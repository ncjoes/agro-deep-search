<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Controllers;

use System\Request\RequestContext;
use System\Exceptions;

abstract class Controller
{
    public function execute(RequestContext $requestContext)
    {
        $method = str_replace(' ','',ucwords(strtolower(str_replace('-',' ',$requestContext->getRequestUrlParam(1)))));
        if(method_exists($this, $method) and is_callable( array($this, $method ) ) )
        {
            return $this->$method($requestContext);
        }
        return $this->doExecute($requestContext);
    }

    protected abstract function doExecute(RequestContext $requestContext);
} 