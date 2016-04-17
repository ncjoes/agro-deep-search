<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/6/2015
 * Time:    7:26 PM
 **/

require_once("header.php");

const MODE_CREATE = 'create-post';
const MODE_UPDATE = 'update-post';

switch($data['mode'])
{
    case(MODE_CREATE):{
        $fields = $rc->getAllFields(INPUT_POST);
        $default_action = array('name'=>MODE_CREATE, 'label'=>"Create Post");
    } break;
    case(MODE_UPDATE):{
        $fields = $data['fields'];
        $default_action = array('name'=>MODE_UPDATE, 'label'=>"Update Post");
    } break;
}
$fields['status'] = isset($fields['status']) ? $fields['status'] : 1;
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-plus"></span> <?= $data['mode']==MODE_CREATE?"Create":"Update"; ?> Post
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/create-post/'); ?>" class="btn btn-primary" title="Create post"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">create post</span></a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/manage-posts/'); ?>" class="btn btn-primary" title="Manage posts"><span class="glyphicon glyphicon-tasks"></span> <span class="sr-only">Manage posts</span></a>
            </h3>
            <div class="text-center mid-margin-bottom <?= (isset($data['status']) and $data['status']) ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data" <?= $data['mode']==MODE_UPDATE? 'action="'.home_url('/'.$rc->getRequestUrlParam(0).'/update-post/?post-id='.$data['post-id'],0).'"':''; ?>>
                <?php if($data['mode']==MODE_UPDATE){ ?><input type="hidden" name="post-id" value="<?= $data['post-id']; ?>"/><?php } ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label for="post-title"><span class="glyphicon glyphicon-leaf"></span> Title</label>
                            <input name="post-title" id="post-title" type="text" maxlength="150" class="form-control" value="<?= isset($fields['post-title']) ? $fields['post-title'] : ''; ?>" placeholder="Title of Your Post" required/>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-url"><span class="glyphicon glyphicon-link"></span> Post URL</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php home_url('/post/')?></span>
                                <input name="post-url" id="post-url" type="text" maxlength="255" class="form-control" value="<?= isset($fields['post-url']) ? $fields['post-url'] : ''; ?>" placeholder="post-title" required/>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-content"><span class="glyphicon glyphicon-pencil"></span> Content</label>
                            <textarea name="post-content" id="post-content" class="form-control html-editor" spellcheck="true"" style="height: 30em;"><?= isset($fields['post-content']) ? $fields['post-content'] : ''; ?></textarea>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-excerpt"><span class="glyphicon glyphicon-star-empty"></span> Excerpt</label>
                            <textarea name="post-excerpt" id="post-excerpt" class="form-control html-editor" spellcheck="true" style="height: 10em;"><?= isset($fields['post-excerpt']) ? $fields['post-excerpt'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-sm">
                            <label for="post-category"><span class="glyphicon glyphicon-tag"></span> Category</label>
                            <select name="post-category" id="post-category" class="form-control" required>
                                <?php
                                foreach($data['categories'] as $category)
                                {
                                    ?>
                                    <option value="<?= $category->getId(); ?>" <?= selected($category->getId(), isset($fields['post-category'])?$fields['post-category']:null); ?>><?= $category->getName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group form-group-sm">
                            <label for="post-date"><span class="glyphicon glyphicon-calendar"></span> Date</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <?= drop_month('post-date[month]', isset($fields['post-date']['month']) ? $fields['post-date']['month'] : date('m'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_month_days('post-date[day]', isset($fields['post-date']['day']) ? $fields['post-date']['day'] : date('d'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_years('post-date[year]', isset($fields['post-date']['year']) ? $fields['post-date']['year'] : date('Y'), date('Y')+2, date('Y')-2, 'class="form-control" required'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="post-time"><span class="glyphicon glyphicon-time"></span> Time</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <?= drop_hours('post-time[hour]', isset($fields['post-time']['hour']) ? $fields['post-time']['hour'] : date('g'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_minutes('post-time[minute]', isset($fields['post-time']['minute']) ? $fields['post-time']['minute'] : date('i'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_AmPM('post-time[am_pm]',  isset($fields['post-time']['am_pm']) ? $fields['post-time']['am_pm'] : date('A'), 'class="form-control" required'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label for="status"><span class="glyphicon glyphicon-tag"></span> Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="<?= 1; ?>" <?= selected(1, isset($fields['status']) ? $fields['status'] : null); ?>>Published</option>
                                <option value="<?= 2; ?>" <?= selected(2, isset($fields['status']) ? $fields['status'] : null); ?>>Draft</option>
                                <option value="<?= 0; ?>" <?= selected(0, isset($fields['status']) ? $fields['status'] : null); ?>>Trash</option>
                            </select>
                        </div>

                        <div class="text-right">
                            <button name="<?= $default_action['name']; ?>" type="submit" class="btn btn-primary">
                                <span class="glyphicon <?= $data['mode']==MODE_CREATE?'glyphicon-plus':'glyphicon-edit'; ?>"></span> <?= $default_action['label']; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
require_once ("Application/Views/_includes/tinymce_config.php");
require_once("footer.php");
?>