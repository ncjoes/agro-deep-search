<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Web
 * Date:    3/26/2016
 * Time:    4:38 AM
 **/

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <h1 class="page-header mid-margin-bottom no-padding">
                <span class="glyphicon glyphicon-dashboard"></span> Welcome to <?php site_info('short-name')?> Administration Panel.
            </h1>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <img src="<?php home_url("/Assets/images/admin-panel.png") ?>" class="img-responsive"/>
                </div>
            </div>
        </div>
    </div>
<?php
require_once("footer.php");
?>