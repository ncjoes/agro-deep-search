<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    5:35 AM
 **/

namespace Application\Controllers;


use Application\Models\Post;
use System\Request\RequestContext;

class Page_Controller extends A_PagePostController
{
    public function doExecute(RequestContext $requestContext)
    {
        parent::doExecute($requestContext);
        $data = $requestContext->getResponseData();
        $data['pages'] = Post::getMapper('Post')->findTypeByStatus($data['item']->getPostType() ,Post::STATUS_PUBLISHED);

        $requestContext->setResponseData($data);
        $requestContext->setView('page-single.php');
    }
}