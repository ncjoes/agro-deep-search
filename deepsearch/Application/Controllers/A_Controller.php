<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    10:57 PM
 */

namespace Application\Controllers;


use Application\Models\Post;
use System\Controllers\Controller;
use System\Request\RequestContext;

abstract class A_Controller extends Controller
{
    public function execute(RequestContext $requestContext)
    {
        $data = array();
        $data['footer']['about-pages'] = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_ABOUT ,Post::STATUS_PUBLISHED, 8);
        $data['footer']['recent-posts'] = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST ,Post::STATUS_PUBLISHED, 8);
        $requestContext->setResponseData($data);

        parent::execute($requestContext);
    }
}