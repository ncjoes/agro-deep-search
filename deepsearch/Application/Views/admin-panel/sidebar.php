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

$group3 = array('create-post', 'update-post', 'manage-posts', 'add-category', 'manage-categories');
$group4 = array('create-page', 'update-page', 'manage-pages');
?>
<div class="col-sm-3 col-md-2 sidebar">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">

        <!--
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-3">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" class="btn-link">
                        <span class="glyphicon glyphicon-bullhorn"></span> News Posts
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
        -->
        
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
        
    </div>

</div>

