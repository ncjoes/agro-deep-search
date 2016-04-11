<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/7/2015
 * Time:    5:39 AM
 **/

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-bullhorn"></span> Manage Posts
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/create-post/'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add News Post</span></a>
            </h3>

            <div class="btn-group pull-right">
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=published'); ?>" class="btn btn-success">Published</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=draft'); ?>" class="btn btn-default">Draft</a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted'); ?>" class="btn btn-warning">Deleted</a>
            </div>


            <?php
            if(is_object($data['posts']) and $data['posts']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="4" class="lead"><?= ucwords($data['status']); ?> Posts</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-list"></span> Post Details</td>
                                <td width="20%"><span class="glyphicon glyphicon-calendar"></span> Date</td>
                                <td width="8%">Order</td>
                                <td width="5%" class="text-center"><input id="check_button" type="checkbox" onChange="checker('post-ids[]', 'check_button');" title="Select All"/></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sn = 0;
                            foreach($data['posts'] as $post)
                            {
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= $post->getTitle(); ?></strong>
                                        <p><?= $post->getExcerpt(); ?></p>
                                    </td>
                                    <td><?= $post->getDateCreated()->getDateTimeStr(); ?></td>
                                    <td><input type="number" name="order[<?= $post->getId(); ?>]" value="<?= $post->getCardinality(); ?>" class="form-control"/></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="post-ids[]" value="<?= $post->getId(); ?>">
                                        <a class="btn" href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/update-post/?post-id='.$post->getId()); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                    </td>
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
                            case 'published' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-default" value="Un-Publish">
                                <?php
                            } break;
                            case 'draft' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-success" value="Publish">
                                <input name="action" type="submit" class="btn btn-warning" value="Delete">
                                <?php
                            } break;
                            case 'deleted' : {
                                ?>
                                <input name="action" type="submit" class="btn btn-default" value="Restore">
                                <input name="action" type="submit" class="btn btn-danger" value="Delete Permanently">
                                <?php
                            }
                        }
                        ?>
                        <input name="action" type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                </form>
                <?php
            }
            else
            {
                ?>
                <div class="clear-both text-center text-primary">
                    <p class="lead">There are currently no <?= $data['status']; ?> news posts.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>