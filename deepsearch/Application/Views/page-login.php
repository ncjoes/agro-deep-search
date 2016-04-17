<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Web
 * Date:    3/26/2016
 * Time:    4:25 AM
 **/

include_once('header-2.php');
?>
    <div>
        <h3 class="page-header">
            <small class="lead">Welcome to </small><?php site_info('short-name'); ?> Administrative Control Panel
        </h3>
    </div>
    <div class="row">
        <div class="col-md-7">
            <p>
                <img src="<?php home_url("/Assets/images/admin-panel-wide.png") ?>" class="img-responsive img-thumbnail"/>
            </p>
        </div>

        <div class="col-md-4 col-md-offset-1">
            <form action="<?php home_url('/login/'); ?>" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Login</legend>
                    <?php
                    if($rc->fieldIsSet('login',INPUT_POST))
                    {
                        ?>
                        <p class="text-danger bg-danger text-center">
                            <?php print_r($rc->getFlashData()); ?>
                        </p>
                        <?php
                    }
                    ?>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-xs-4 text-nowrap">
                                <label for="username" title="Email or Phone"><span class="glyphicon glyphicon-user"></span> Username</label>
                            </div>
                            <div class="col-xs-8">
                                <input name="username" id="username" type="text" class="form-control" maxlength="50" placeholder="Email or Phone"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="row">
                            <div class="col-xs-4 text-nowrap">
                                <label for="password"><span class="glyphicon glyphicon-lock"></span> Password</label>
                            </div>
                            <div class="col-xs-8">
                                <input name="password" id="password" type="password" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn-group pull-right">
                                <button name="login" id="login" type="submit" class="btn btn-primary">
                                    Login
                                    <span class="glyphicon glyphicon-log-in"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
<?php
include_once("footer.php");
?>