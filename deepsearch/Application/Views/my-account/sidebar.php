<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PPSMB-Enugu Website
 * Date:    11/29/2015
 * Time:    1:19 PM
 **/

$requestContext = \System\Request\RequestContext::instance();
$method = $requestContext->getRequestUrlParam(1);

$group1 = array('edit-profile', 'change-password','');
?>
<div class="col-sm-3 col-md-2 sidebar">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-1">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1" class="btn-link">
                        <span class="glyphicon glyphicon-user"></span> My Account
                    </a>
                </h4>
            </div>
            <div id="collapse-1" class="panel-collapse collapse <?= in_array($method, $group1)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading-1">
                <div class="panel-body no-padding">
                    <ul class="btn-group btn-group-vertical list-unstyled">
                        <li><a href="<?php home_url('/my-account/edit-profile/'); ?>" class="btn"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
                        <li><a href="<?php home_url('/my-account/change-password/'); ?>" class="btn"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

