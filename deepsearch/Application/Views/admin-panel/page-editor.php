<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/7/2015
 * Time:    4:36 PM
 **/

require_once("header.php");

const MODE_CREATE = 'create-page';
const MODE_UPDATE = 'update-page';

switch($data['mode'])
{
    case(MODE_CREATE):{
        $fields = $rc->getAllFields(INPUT_POST);
        $default_action = array('name'=>$data['mode'], 'label'=>"Create Page");
    } break;
    case(MODE_UPDATE):{
        $fields = $data['fields'];
        $default_action = array('name'=>$data['mode'], 'label'=>"Update Page");
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
                <span class="glyphicon glyphicon-plus"></span> <?= $data['mode']==MODE_CREATE?"Create":"Update"; ?> Page
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/create-page/'); ?>" class="btn btn-primary" title="Create Page"><span class="glyphicon glyphicon-plus"></span> <span class="sr-only">create Page</span></a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/manage-pages/'); ?>" class="btn btn-primary" title="Manage Pages"><span class="glyphicon glyphicon-tasks"></span> <span class="sr-only">Manage Pages</span></a>
            </h3>
            <div class="text-center mid-margin-bottom <?= (isset($data['status']) and $data['status']) ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data" <?= $data['mode']==MODE_UPDATE ? 'action="'.home_url('/'.$rc->getRequestUrlParam(0).'/update-page/?page-id='.$data['page-id'],0).'"':''; ?>>
                <?php if($data['mode']==MODE_UPDATE){ ?><input type="hidden" name="page-id" value="<?= $data['page-id']; ?>"/><?php } ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label for="page-title"><span class="glyphicon glyphicon-leaf"></span> Title</label>
                            <input name="page-title" id="page-title" type="text" class="form-control" required value="<?= isset($fields['page-title']) ? $fields['page-title'] : ''; ?>" placeholder="Title of Page" spellcheck="true"/>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-url"><span class="glyphicon glyphicon-link"></span> Page URL</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php home_url('/page/')?></span>
                                <input name="page-url" id="page-url" type="text" class="form-control" required value="<?= isset($fields['page-url']) ? $fields['page-url'] : ''; ?>" placeholder="page-title" spellcheck="true"/>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-content"><span class="glyphicon glyphicon-pencil"></span> Content</label>
                            <textarea name="page-content" id="page-content" class="form-control html-editor" spellcheck="true" spellcheck="true" style="height: 30em;"><?= isset($fields['page-content']) ? $fields['page-content'] : ''; ?></textarea>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-excerpt"><span class="glyphicon glyphicon-star-empty"></span> Excerpt</label>
                            <textarea name="page-excerpt" id="page-excerpt" class="form-control html-editor" spellcheck="true" style="height: 10em;"><?= isset($fields['page-excerpt']) ? $fields['page-excerpt'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group form-group-sm">
                            <label for="page-type"><span class="glyphicon glyphicon-tag"></span> Page Type</label>
                            <select name="page-type" id="page-type" class="form-control" required>
                                <?php
                                foreach($data['page-types'] as $type_id => $type_name)
                                {
                                    ?>
                                    <option value="<?= $type_id; ?>" <?= selected($type_id, isset($fields['page-type']) ? $fields['page-type'] : null); ?>><?= $type_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group form-group-sm">
                            <label for="page-date"><span class="glyphicon glyphicon-calendar"></span> Date</label>
                            <div class="row">
                                <div class="col-xs-5">
                                    <?= drop_month('page-date[month]', isset($fields['page-date']['month']) ? $fields['page-date']['month'] : date('m'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-3 no-padding">
                                    <?= drop_month_days('page-date[day]', isset($fields['page-date']['day']) ? $fields['page-date']['day'] : date('d'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_years('page-date[year]', isset($fields['page-date']['year']) ? $fields['page-date']['year'] : date('Y'),date('Y')+1,date('Y')-1, 'class="form-control" required'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label for="page-time"><span class="glyphicon glyphicon-time"></span> Time</label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <?= drop_hours('page-time[hour]', isset($fields['page-time']['hour']) ? $fields['page-time']['hour'] : date('g'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_minutes('page-time[minute]', isset($fields['page-time']['minute']) ? $fields['page-time']['minute'] : date('i'), 'class="form-control" required'); ?>
                                </div>
                                <div class="col-xs-4">
                                    <?= drop_AmPM('page-time[am_pm]',  isset($fields['page-time']['am_pm']) ? $fields['page-time']['am_pm'] : date('A'), 'class="form-control" required'); ?>
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