<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/7/2015
 * Time:    4:55 PM
 **/

require_once("header.php");
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-book"></span> Manage Pages
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/create-page/?type='.$data['type']); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">Add Page</span></a>
            </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group pull-left">
                        <?php
                        foreach($data['page-types'] as $type_id => $type_name)
                        {
                            ?>
                            <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status='.$data['status'].'&type='.$type_id); ?>" class="btn btn-default <?= ($type_id==$data['type'])?'active':'';?>"><?= $type_name; ?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=published&type='.$data['type']); ?>" class="btn btn-success">Published</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=draft&type='.$data['type']); ?>" class="btn btn-default">Draft</a>
                        <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/'.$rc->getRequestUrlParam(1).'/?status=deleted&type='.$data['type']); ?>" class="btn btn-warning">Deleted</a>
                    </div>
                </div>
            </div>


            <?php
            if(is_object($data['pages']) and $data['pages']->size())
            {
                ?>
                <form method="post">
                    <div class="table-responsive clear-both">
                        <table class="table table-stripped table-bordered table-hover full-margin-top">
                            <thead>
                            <tr>
                                <td colspan="4" class="lead"><?= ucwords($data['status']); ?> Pages</td>
                            </tr>
                            <tr>
                                <td><span class="glyphicon glyphicon-list"></span> Page Details</td>
                                <td width="20%"><span class="glyphicon glyphicon-calendar"></span> Date</td>
                                <td width="8%">Order</td>
                                <td width="5%" class="text-center"><input id="check_button" type="checkbox" onChange="checker('page-ids[]', 'check_button');" title="Select All"/></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($data['pages'] as $post)
                            {
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= $post->getTitle(); ?></strong>
                                        <p><?= remove_text_formatting($post->getExcerpt()); ?></p>
                                    </td>
                                    <td><?= $post->getDateCreated()->getDateTimeStr(); ?></td>
                                    <td><input type="number" name="order[<?= $post->getId(); ?>]" value="<?= $post->getCardinality(); ?>" class="form-control"/></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="page-ids[]" value="<?= $post->getId(); ?>">
                                        <a class="btn" href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/update-page/?page-id='.$post->getId()); ?>"><span class="glyphicon glyphicon-edit"></span></a>
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
                    <p class="lead">There are currently no <?= $data['status']; ?> pages.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
require_once("footer.php");
?>