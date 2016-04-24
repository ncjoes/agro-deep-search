<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/23/2016
 * Time:    11:01 AM
 **/


namespace Application\Controllers;


use Application\Models\UserPrivilege;
use System\Models\DomainObjectWatcher;
use System\Request\RequestContext;

class CrawlEngineManager_Controller extends A_AdministrativeCommands_Controller
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, UserPrivilege::UT_ADMIN, 'crawl-engine-manager'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data = array();
        $data['page-title'] = "Run Web Crawl";

        $requestContext->setResponseData($data);
        $requestContext->setView('crawl-engine/dashboard.php');
    }

    protected function ManageLinks(RequestContext $requestContext)
    {
    }
}