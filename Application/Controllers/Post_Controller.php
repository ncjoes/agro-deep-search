<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Web
 * Date:    3/28/2016
 * Time:    4:11 AM
 **/

namespace Application\Controllers;


use Application\Models\Post;
use Application\Models\PostCategory;
use System\Exceptions\CommandNotFoundException;
use System\Request\RequestContext;

class Post_Controller extends A_PagePostController
{
    protected function doExecute(RequestContext $requestContext)
    {
        //present post if it exists
        if($this->viewPost($requestContext)) return true;

        //do fault stuff
        $data['page-title'] = site_info('short-name',false)." Announcements";
        $data['posts'] = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST ,Post::STATUS_PUBLISHED);
        $data['categories'] = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_VALID);

        $requestContext->setResponseData($data);
        $requestContext->setView("post-default.php");

        return true;
    }

    protected function viewPost(RequestContext $requestContext)
    {
        $guid = $requestContext->getRequestUrlParam(1);
        if(strlen($guid))
        {
            $item = Post::getMapper('Post')->findByGuid($guid);
            if(is_object($item) and $item->getStatus() == Post::STATUS_PUBLISHED)
            {
                $data['item'] = $item;
                $data['page-title'] = $item->getTitle();
                $data['posts'] = Post::getMapper('Post')->findByCategory($item->getCategory()->getId() ,Post::STATUS_PUBLISHED);
                $data['categories'] = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_VALID);

                $requestContext->setResponseData($data);
                $requestContext->setView("post-single.php");
                return true;
            }
            throw new CommandNotFoundException("Page /{$guid} not found");
        }
        return false;
    }

    protected function category(RequestContext $requestContext)
    {
        $guid = $requestContext->getRequestUrlParam(2);
        if(strlen($guid))
        {
            $item = PostCategory::getMapper('PostCategory')->findByGuid($guid);
            if(is_object($item) and $item->getStatus() == PostCategory::STATUS_VALID)
            {
                $data['item'] = $item;
                $data['page-title'] = site_info('short-name',false)." Announcements - ".$item->getName();
                $data['posts'] = Post::getMapper('Post')->findByCategory($item->getId() ,Post::STATUS_PUBLISHED);
                $data['categories'] = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_VALID);

                $requestContext->setResponseData($data);
                $requestContext->setView("post-category.php");
                return true;
            }
            throw new CommandNotFoundException("Category /{$guid} not found");
        }
        $requestContext->redirect(home_url('/'.$requestContext->getRequestUrlParam(0),false));
    }
}