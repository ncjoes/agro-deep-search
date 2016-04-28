<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    5:14 PM
 */

namespace Application\Controllers;


use Application\Models\BoardStaff;
use Application\Models\Lga;
use Application\Models\School;
use Application\Models\Section;
use Application\Models\Office;
use Application\Models\User;
use Application\Models\Upload;
use Application\Models\UserPrivilege;
use Application\Models\Zone;
use Application\Utilities\AccessManager;
use System\Models\Collections\Collection;
use System\Models\DomainObjectWatcher;
use System\Request\RequestContext;
use System\Utilities\DateTime;
use System\Utilities\UploadHandler;

class AdminPanel_Controller extends A_AdministrativeCommands_Controller
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, UserPrivilege::UT_ADMIN, 'admin-panel'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data['page-title'] = "Admin Panel";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-panel/dashboard.php');
    }

    protected function AddLink(RequestContext $requestContext)
    {}

    protected function ManageLinks(RequestContext $requestContext)
    {}

    protected function AddForm(RequestContext $requestContext)
    {}

    protected function ManageForms(RequestContext $requestContext)
    {}

    protected function ManageFeatures(RequestContext $requestContext)
    {}
}