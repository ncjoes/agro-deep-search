<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/5/2015
 * Time:    10:47 PM
 **/

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-tags"></span> Manage Categories
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/add-category/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Category</span></a>
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=valid'); ?>" class="btn btn-success">Valid</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-danger">Deleted</a>
            </div>

            <?php
            if(is_object($data['categories']) and $data['categories']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="4" class="lead">Categories (<?= ucwords($data['status']); ?>)</td>
                            </tr>
                            <tr>
                                <td width="4%">SN</td>
                                <td>Caption</td>
                                <td>GUID</td>
                                <td width="5%"><input id="check_button" type="checkbox" onChange="checker('category-ids[]', 'check_button');" title="Select All"/></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['categories'] as $category)
                            {
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><?= $category->getName(); ?></td>
                                    <td>/<?= $category->getGuid(); ?></td>
                                    <td><input type="checkbox" name="category-ids[]" value="<?= $category->getId(); ?>"></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-group pull-right">
                        <?php
                        switch($data['status'])
                        {
                            case 'valid' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
                                <?php
                            } break;
                            default : {
                                ?>
                                <input name="action" type="submit" class="btn btn-danger" value="Delete">
                                <input name="action" type="submit" class="btn btn-success" value="Restore">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </form>
                <?php
            }
            else
            {
                ?>
                <div class="clear-both text-center text-primary">
                    <p class="lead">There are currently no <?= $data['status']; ?> categories.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>