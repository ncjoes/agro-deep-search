<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/29/2015
 * Time:    1:19 PM
 **/

$requestContext = \System\Request\RequestContext::instance();
$method = $requestContext->getRequestUrlParam(1);

$group1 = array('add-school', 'update-school', 'manage-schools');
$group2 = array('add-staff', 'update-staff', 'manage-staff-list');
$group3 = array('create-post', 'update-post', 'manage-posts', 'add-category', 'manage-categories');
$group4 = array('create-page', 'update-page', 'manage-pages');
$group5 = array('create-memo', 'select-memo-recipients', 'edit-memo', 'manage-memos');
$group6 = array(
    'add-zone', 'update-zone', 'manage-zones',
    'add-lga', 'update-lga', 'manage-lgas',
    'add-section', 'update-section', 'manage-sections',
    'add-office', 'update-office', 'manage-offices',
    );
$group7 = array('add-publication', 'update-publication', 'manage-publications');
?>
<div class="col-sm-3 col-md-2 sidebar">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-2">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2" class="btn-link">
                        <span class="glyphicon glyphicon-user"></span> Board Staff
                    </a>
                </h4>
            </div>
            <div id="collapse-2" class="panel-collapse collapse <?= in_array($method, $group2)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-2">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/add-staff/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Add Staff</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-staff-list/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Staff List</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-3">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" class="btn-link">
                        <span class="glyphicon glyphicon-bullhorn"></span> Pub. Announcements
                    </a>
                </h4>
            </div>
            <div id="collapse-3" class="panel-collapse collapse <?= in_array($method, $group3)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-3">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/create-post/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Create Post</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-posts/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Posts</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-categories/'); ?>" class="btn"><span class="glyphicon glyphicon-tags"></span> Manage Categories</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-7">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-7" aria-expanded="false" aria-controls="collapse-7" class="btn-link">
                        <span class="glyphicon glyphicon-paste"></span> Official Publications
                    </a>
                </h4>
            </div>
            <div id="collapse-7" class="panel-collapse collapse <?= in_array($method, $group7)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-7">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/add-publication/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Add Publication</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-publications/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Publications</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-1">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" class="btn-link">
                        <span class="glyphicon glyphicon-education"></span> Schools Directory
                    </a>
                </h4>
            </div>
            <div id="collapse-1" class="panel-collapse collapse <?= in_array($method, $group1)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-1">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/add-school/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Add School</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-schools/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Schools</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-4">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="btn-link">
                        <span class="glyphicon glyphicon-duplicate"></span> Website Pages
                    </a>
                </h4>
            </div>
            <div id="collapse-4" class="panel-collapse collapse <?= in_array($method, $group4)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-4">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/create-page/'); ?>" class="btn"><span class="glyphicon glyphicon-plus-sign"></span> Create Page</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-pages/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Pages</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-5">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5" class="btn-link">
                        <span class="glyphicon glyphicon-envelope"></span> Insider Mail
                    </a>
                </h4>
            </div>
            <div id="collapse-5" class="panel-collapse collapse <?= in_array($method, $group5)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-5">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/compose-memo/'); ?>" class="btn"><span class="glyphicon glyphicon-edit"></span> Compose Memo</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-memos/'); ?>" class="btn"><span class="glyphicon glyphicon-tasks"></span> Manage Memos</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-6">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6" class="btn-link">
                        <span class="glyphicon glyphicon-cog"></span> Miscellaneous
                    </a>
                </h4>
            </div>
            <div id="collapse-6" class="panel-collapse collapse <?= in_array($method, $group6)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-6">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/admin-panel/manage-zones/'); ?>" class="btn"><span class="glyphicon glyphicon-globe"></span> Manage Zones</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-lgas/'); ?>" class="btn"><span class="glyphicon glyphicon-map-marker"></span> Manage LGAs</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-sections/'); ?>" class="btn"><span class="glyphicon glyphicon-flag"></span> Manage Board Sections</a></li>
                        <li><a href="<?php home_url('/admin-panel/manage-offices/'); ?>" class="btn"><span class="glyphicon glyphicon-briefcase"></span> Manage Board Offices</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

