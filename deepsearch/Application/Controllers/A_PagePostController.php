<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    1:55 PM
 */

namespace Application\Controllers;

use Application\Models\Post;
use System\Exceptions\CommandNotFoundException;
use System\Request\RequestContext;

abstract class A_PagePostController extends A_Controller
{
    protected function doExecute(RequestContext $requestContext)
    {
        $guid = $requestContext->getRequestUrlParam(1);
        if(strlen($guid))
        {
            $item = Post::getMapper('Post')->findByGuid($guid);
            if(is_object($item) and $item->getStatus() == Post::STATUS_PUBLISHED)
            {
                $data['item'] = $item;
                $data['page-title'] = $item->getTitle();
                $requestContext->setResponseData($data);
                return;
            }
            throw new CommandNotFoundException("Page /{$guid} not found");
        }
        $requestContext->redirect(home_url('/',false));
    }
}