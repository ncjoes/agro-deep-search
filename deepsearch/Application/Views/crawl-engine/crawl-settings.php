<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    4:28 PM
 **/

require_once("header.php");
$fields = $data['fields'];
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1 main">
        <h3 class="page-header">Default Crawler Settings</h3>
        <form method="post" enctype="multipart/form-data" action="">
            <div class="text-center full-margin-bottom <?= (isset($data['status']) and $data['status']) ? 'text-success bg-success' : 'text-danger bg-danger';?>">
                <?= $rc->getFlashData(); ?>
            </div>
            <?php
            require_once("Application/Views/_includes/crawler-config.php");
            ?>
            <hr/>
            <div class="text-center">
                <p>
                    <button name="save-changes" value="1" type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-forward"></span> Save Changes
                    </button>
                </p>
                <button name="reset-all" type="submit" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-forward"></span> Reset All Settings
                </button>
            </div>
        </form>
    </div>
</div>
<?php
require_once("footer.php");
?>