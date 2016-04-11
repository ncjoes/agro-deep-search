<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Enugu Website
 * Date:    4/7/2016
 * Time:    10:51 PM
 **/

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-edit"></span> Edit My Profile
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0)); ?>" class="btn btn-primary" title="View Profile"><span class="glyphicon glyphicon-user"></span> <span class="sr-only">View Profile</span></a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/edit-profile/'); ?>" class="btn btn-primary" title="Edit Profile"><span class="glyphicon glyphicon-edit"></span> <span class="sr-only">Edit Profile</span></a>
            </h3>
            <div class="text-center mid-margin-bottom <?= (isset($data['status']) and $data['status']) ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">

                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="old-password">Old Password</label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="old-password" id="old-password" required type="password" maxlength="50" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="password1">New Password</label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="password1" id="password1" required type="password" maxlength="50" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="password2">Confirm New Password</label>
                                </div>
                                <div class="col-sm-9">
                                    <input name="password2" id="password2" required type="password" maxlength="50" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button name="change-password" type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-edit"></span> Change Password
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>