<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/29/2016
 * Time:    1:55 AM
 **/

namespace Application\Controllers;


use System\Request\RequestContext;
use System\Models\DomainObjectWatcher;
use System\Utilities\DateTime;
use System\Utilities\UploadHandler;
use Application\Models\Post;
use Application\Models\Upload;
use Application\Models\PostCategory;
use Application\Models\Publication;

abstract class A_AdministrativeCommands_Controller extends A_UserCommands_Controller
{
    //Categories management
    protected function AddCategory(RequestContext $requestContext)
    {
        $data = array();

        $data['categories'] = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_APPROVED);

        if($requestContext->fieldIsSet('add', INPUT_POST))
        {
            $fields = $requestContext->getAllFields(INPUT_POST);
            $name = $fields['category-caption'];
            $guid = strtolower($fields['category-guid']);
            $parent = PostCategory::getMapper('PostCategory')->find($fields['category-parent']);

            if(strlen($name) and strlen($guid))
            {
                $new_category = new PostCategory();
                $new_category->setGuid($guid);
                if(is_object($parent)) $new_category->setParent($parent);
                $new_category->setName($name);
                $new_category->setStatus(PostCategory::STATUS_APPROVED);

                $requestContext->setFlashData("Category '{$name}' added successfully");
                $data['status'] = 1;
            }
            else
            {
                $requestContext->setFlashData('Mandatory fields not set');
                $data['status'] = 0;
            }
        }

        DomainObjectWatcher::instance()->performOperations();

        $data['page-title'] = "Add Category";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/add-category.php');
    }

    protected function ManageCategories(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status', INPUT_GET) ? $requestContext->getField('status', INPUT_GET) : 'valid';
        $action = $requestContext->fieldIsSet('action', INPUT_POST) ? $requestContext->getField('action', INPUT_POST) : null;
        $category_ids = $requestContext->fieldIsSet('category-ids', INPUT_POST) ? $requestContext->getField('category-ids', INPUT_POST) : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($category_ids as $category_id)
                {
                    $category_obj = PostCategory::getMapper('PostCategory')->find($category_id);
                    if(is_object($category_obj)) $category_obj->setStatus(PostCategory::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($category_ids as $category_id)
                {
                    $category_obj = PostCategory::getMapper('PostCategory')->find($category_id);
                    if(is_object($category_obj)) $category_obj->setStatus(PostCategory::STATUS_VALID);
                }
            } break;
            case 'delete permanently' : {
                foreach($category_ids as $category_id)
                {
                    $category_obj = PostCategory::getMapper('PostCategory')->find($category_id);
                    if(is_object($category_obj)) $category_obj->markDelete();
                }
            } break;
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'valid' : {
                $categories = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_VALID);
            } break;
            case 'deleted' : {
                $categories = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_DELETED);
            } break;
            default : {
                $categories = PostCategory::getMapper('PostCategory')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['categories'] = $categories;
        $data['page-title'] = ucwords($status)." Categories";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/manage-categories.php');
    }

    //Post management
    protected function CreatePost(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'create-post';
        $data['page-title'] = "Create Post";
        $data['categories'] = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_APPROVED);

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/post-editor.php');

        if($requestContext->fieldIsSet($data['mode'], INPUT_POST))
        {
            $this->processPostEditor($requestContext);
        }
    }

    protected function UpdatePost(RequestContext $requestContext)
    {
        $post_id = $requestContext->fieldIsSet('post-id', INPUT_POST) ?
            $requestContext->getField('post-id', INPUT_POST) : $requestContext->getField('post-id', INPUT_GET);
        $post =  Post::getMapper('Post')->find($post_id);

        if(is_object($post))
        {
            $data = array();
            $data['mode'] = 'update-post';
            $data['page-title'] = "Update Post";
            $data['categories'] = PostCategory::getMapper('PostCategory')->findByStatus(PostCategory::STATUS_APPROVED);

            $fields = array();
            $fields['post-title'] = $post->getTitle();
            $fields['post-url'] = $post->getGuid();
            $fields['post-content'] = $post->getContent();
            $fields['post-excerpt'] = $post->getExcerpt();
            $fields['post-category'] = $post->getCategory()->getId();
            $fields['post-date']['month'] = $post->getDateCreated()->getMonth();
            $fields['post-date']['day'] = $post->getDateCreated()->getDay();
            $fields['post-date']['year'] = $post->getDateCreated()->getYear();
            $fields['post-time']['hour'] = date('g', $post->getDateCreated()->getDateTimeInt() );
            $fields['post-time']['minute'] = date('i', $post->getDateCreated()->getDateTimeInt() );
            $fields['post-time']['am_pm'] = date('A', $post->getDateCreated()->getDateTimeInt() );
            $fields['status'] = $post->getStatus();
            $data['post-id'] = $fields['post-id'] = $post->getId();
            $data['fields'] = $fields;

            $requestContext->setResponseData($data);
            $requestContext->setView('admin-panel/post-editor.php');

            if($requestContext->fieldIsSet($data['mode'],INPUT_POST))
            {
                $this->processPostEditor($requestContext);
            }
        }
        else{
            $requestContext->redirect(home_url('/'.$requestContext->getRequestUrlParam(0), false));
        }
    }

    private function processPostEditor(RequestContext $requestContext)
    {
        $data = $requestContext->getResponseData();
        $fields = $requestContext->getAllFields(INPUT_POST);

        $title = $fields['post-title'];
        $guid = strtolower( str_replace(array(' '), array('-'), $fields['post-url']) );
        $content = $fields['post-content'];
        $excerpt = $fields['post-excerpt'];
        $category = PostCategory::getMapper('PostCategory')->find($fields['post-category']);
        $date = $fields['post-date'];
        $time = $fields['post-time'];
        $status = $fields['status'];
        preProcessTimeArr($time);

        if(
            strlen($title)
            and strlen($guid)
            and strlen($content)
            and is_object($category)
            and checkdate($date['month'], $date['day'], $date['year'])
            and DateTime::checktime($time['hour'], $time['minute'])
        )
        {
            $post = $data['mode'] == 'create-post' ? new Post() : Post::getMapper('Post')->find($data['post-id']);
            if(is_object($post))
            {
                $post->setPostType(Post::TYPE_POST);
                $post->setGuid($guid);
                $post->setTitle($title);
                $post->setContent($content);
                $post->setExcerpt($excerpt);
                $post->setCategory($category);
                $post->setAuthor($requestContext->getSession()->getUser());
                $post->setDateCreated(new DateTime(mktime($time['hour'],$time['minute'],0,$date['month'],$date['day'],$date['year'])));
                $post->setLastUpdate(new DateTime());
                $post->setStatus($status);

                DomainObjectWatcher::instance()->performOperations();
                $requestContext->setFlashData($data['mode'] == 'create-post' ? "Post created successfully" : "Post updated successfully");

                $data['status'] = 1;
                $data['post-id'] = $post->getId();
                $data['mode'] = 'update-post';
                $data['fields'] = &$fields;
            }
        }else{
            $requestContext->setFlashData('Mandatory field(s) not set or invalid input detected');
            $data['status'] = 0;
        }
        $requestContext->setResponseData($data);
    }

    protected function ManagePosts(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status',INPUT_GET) ? $requestContext->getField('status',INPUT_GET) : 'published';
        $action = $requestContext->fieldIsSet('action',INPUT_POST) ? $requestContext->getField('action',INPUT_POST) : null;
        $post_ids = $requestContext->fieldIsSet('post-ids',INPUT_POST) ? $requestContext->getField('post-ids',INPUT_POST) : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_PUBLISHED);
                }
            } break;
            case 'un-publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'delete permanently' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->markDelete();
                }
            } break;
            case 'save changes' : {
                $post_orders = $requestContext->fieldIsSet('order', INPUT_POST) ?
                    $requestContext->getField('order', INPUT_POST) : array();
                foreach($post_orders as $post_id => $post_order)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setCardinality((int)$post_order);
                }
            }
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'published' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST, Post::STATUS_PUBLISHED);
            } break;
            case 'draft' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST, Post::STATUS_DRAFT);
            } break;
            case 'deleted' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST, Post::STATUS_DELETED);
            } break;
            default : {
                $posts = Post::getMapper('Post')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['posts'] = $posts;
        $data['page-title'] = ucwords($status)." News Posts";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/manage-posts.php');
    }

    //Page Management
    protected function CreatePage(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'create-page';
        $data['page-title'] = "Create Page";
        $data['page-types'] = array(Post::TYPE_ABOUT=>'About', Post::TYPE_OTHER=>'Others');

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/page-editor.php');

        if($requestContext->fieldIsSet($data['mode'], INPUT_POST))
        {
            $this->processPageEditor($requestContext);
        }
    }

    protected function UpdatePage(RequestContext $requestContext)
    {
        $page_id = $requestContext->fieldIsSet('page-id', INPUT_POST) ?
            $requestContext->getField('page-id', INPUT_POST) : $requestContext->getField('page-id', INPUT_GET);
        $page =  Post::getMapper('Post')->find($page_id);

        if(is_object($page))
        {
            $data = array();

            $data['mode'] = 'update-page';
            $data['page-title'] = "Update Page";
            $data['page-types'] = array(Post::TYPE_ABOUT=>'About', Post::TYPE_OTHER=>'Others');

            $fields = array();
            $fields['page-title'] = $page->getTitle();
            $fields['page-url'] = $page->getGuid();
            $fields['page-content'] = $page->getContent();
            $fields['page-excerpt'] = $page->getExcerpt();
            $fields['page-type'] = $page->getPostType();
            $fields['page-date']['month'] = $page->getDateCreated()->getMonth();
            $fields['page-date']['day'] = $page->getDateCreated()->getDay();
            $fields['page-date']['year'] = $page->getDateCreated()->getYear();
            $fields['page-time']['hour'] = date('g', $page->getDateCreated()->getDateTimeInt() );
            $fields['page-time']['minute'] = date('i', $page->getDateCreated()->getDateTimeInt() );
            $fields['page-time']['am_pm'] = date('A', $page->getDateCreated()->getDateTimeInt() );
            $fields['status'] = $page->getStatus();
            $data['page-id'] = $fields['page-id'] = $page->getId();
            $data['fields'] = $fields;

            $requestContext->setResponseData($data);
            $requestContext->setView('admin-panel/page-editor.php');

            if($requestContext->fieldIsSet($data['mode'], INPUT_POST))
            {
                $this->processPageEditor($requestContext);
            }
        }
        else{
            $requestContext->redirect(home_url('/'.$requestContext->getRequestUrlParam(0), false));
        }
    }

    private function processPageEditor(RequestContext $requestContext)
    {
        $page_types = array(Post::TYPE_ABOUT, Post::TYPE_OTHER);
        $data = $requestContext->getResponseData();
        $fields = $requestContext->getAllFields(INPUT_POST);

        $title = $fields['page-title'];
        $guid = strtolower( str_replace(array(' '), array('-'), $fields['page-url']) );
        $content = $fields['page-content'];
        $excerpt = $fields['page-excerpt'];
        $page_type = $fields['page-type'];
        $date = $fields['page-date'];
        $time = $fields['page-time'];
        $status = $fields['status'];
        preProcessTimeArr($time);

        if(
            strlen($title)
            and strlen($guid)
            and strlen($content)
            and in_array($page_type, $page_types)
            and checkdate($date['month'], $date['day'], $date['year'])
            and DateTime::checktime($time['hour'], $time['minute'])
        )
        {
            $post = $data['mode'] == 'create-page' ? new Post() : Post::getMapper('Post')->find($data['page-id']);
            if(is_object($post))
            {
                $post->setPostType($page_type);
                $post->setGuid($guid);
                $post->setTitle($title);
                $post->setContent($content);
                $post->setExcerpt($excerpt);
                $post->setAuthor($requestContext->getSession()->getUser());
                $post->setDateCreated(new DateTime(mktime($time['hour'],$time['minute'],0,$date['month'],$date['day'],$date['year']) ));
                $post->setLastUpdate(new DateTime());
                $post->setStatus($status);

                DomainObjectWatcher::instance()->performOperations();
                $requestContext->setFlashData($data['mode'] == 'create-page' ? "Page created successfully" : "Page updated successfully");

                $data['status'] = 1;
                $data['page-id'] = $post->getId();
                $data['mode'] = 'update-page';
                $data['fields'] = &$fields;
            }
        }else{
            $requestContext->setFlashData('Mandatory field(s) not set or invalid input detected');
            $data['status'] = 0;
        }
        $requestContext->setResponseData($data);
    }

    protected function ManagePages(RequestContext $requestContext)
    {
        $type = $requestContext->fieldIsSet('type', INPUT_GET) ? $requestContext->getField('type', INPUT_GET) : Post::TYPE_ABOUT;
        $status = $requestContext->fieldIsSet('status', INPUT_GET) ? $requestContext->getField('status', INPUT_GET) : 'published';
        $action = $requestContext->fieldIsSet('action', INPUT_POST) ? $requestContext->getField('action', INPUT_POST) : null;
        $post_ids = $requestContext->fieldIsSet('page-ids', INPUT_POST) ? $requestContext->getField('page-ids', INPUT_POST) : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DELETED);
                }
            } break;
            case 'publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_PUBLISHED);
                }
            } break;
            case 'restore' :
            case 'un-publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'delete permanently' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->markDelete();
                }
            } break;
            case 'save changes' : {
                $post_orders = $requestContext->fieldIsSet('order', INPUT_POST) ?
                    $requestContext->getField('order', INPUT_POST) : array();
                foreach($post_orders as $post_id => $post_order)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setCardinality((int)$post_order);
                }
            }
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'published' : {
                $posts = Post::getMapper('Post')->findTypeByStatus($type, Post::STATUS_PUBLISHED);
            } break;
            case 'draft' : {
                $posts = Post::getMapper('Post')->findTypeByStatus($type, Post::STATUS_DRAFT);
            } break;
            case 'deleted' : {
                $posts = Post::getMapper('Post')->findTypeByStatus($type, Post::STATUS_DELETED);
            } break;
            default : {
                $posts = Post::getMapper('Post')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['pages'] = $posts;
        $data['type'] = $type;
        $data['page-types'] = array(Post::TYPE_ABOUT=>'About', Post::TYPE_OTHER=>'Others');
        $data['page-title'] = ucwords($status)." Pages";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/manage-pages.php');
    }
}