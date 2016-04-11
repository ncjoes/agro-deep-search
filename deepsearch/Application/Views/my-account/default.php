<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Enugu Website
 * Date:    4/7/2016
 * Time:    8:00 PM
 **/

require_once("header.php");
$user = $data['user'];
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <h2 class="page-header mid-margin-bottom no-padding">
                <span class="glyphicon glyphicon-user"></span> <?= $user->getNames(); ?>
            </h2>

            <div class="row">
                <div class="col-sm-3 col-sm-offset-1">
                    <p class="full-padding-all">
                        <?php
                        $photo = is_object($user->getPhoto()) ? $user->getPhoto()->getFullPath() : "Assets/images/faceless.png";
                        ?>
                        <img src="<?php home_url('/'.$photo) ?>" class="img-responsive img-thumbnail">
                    </p>
                </div>
                <div class="col-sm-7">
                    <p>
                        <span class="help-block">Names</span>
                        <b><?= $user->getNames(); ?></b>
                    </p>
                    <p>
                        <span class="help-block">Email</span>
                        <b><?= $user->getEmail(); ?></b>
                    </p>
                    <p>
                        <span class="help-block">Phone</span>
                        <b><?= $user->getPhone(); ?></b>
                    </p>
                    <p>
                        <span class="help-block">Address</span>
                        <b><?= $user->getAddress1(); ?></b>, <b><?= $user->getAddress2(); ?></b><br/>
                        City: <b><?= $user->getCity(); ?></b> (Zip: <b><?= $user->getZipCode(); ?></b>)<br/>
                        State: <b><?= $user->getState(); ?></b> | Country: <b><?= $user->getCountry(); ?></b>
                    </p>
                    <p>
                        <span class="help-block">Bio.</span>
                        <b><?= $user->getBiography(); ?></b>
                    </p>

                    <p>
                        <a href="<?php home_url('/my-account/edit-profile/')?>" class="btn btn-primary">Edit Profile</a>
                        <a href="<?php home_url('/my-account/change-password/')?>" class="btn btn-primary">Change Password</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php
require_once("footer.php");
?>