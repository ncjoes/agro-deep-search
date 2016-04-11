<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    12/5/2015
 * Time:    11:34 PM
 **/

require_once("header.php");

$fields = $rc->getAllFields(INPUT_POST);
if($rc->fieldIsSet('add', INPUT_POST)) if($data['status']==1) $fields = array();
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-plus"></span> Add News Category
            </h3>
            <div class="text-center mid-margin-bottom <?= (isset($data['status']) and $data['status']) ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post">
                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="category-caption">Caption</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="category-caption" id="category-caption" type="text" class="form-control" required value="<?= isset($fields['category-caption']) ? $fields['category-caption'] : ''; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="category-guid">GUID</label>
                        </div>
                        <div class="col-sm-9">
                            <input name="category-guid" id="category-guid" type="text" class="form-control" required value="<?= isset($fields['category-guid']) ? $fields['category-guid'] : ''; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="category-parent">Parent</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" name="category-parent" id="category-parent">
                                <option>None</option>
                                <?php
                                foreach($data['categories'] as $category)
                                {
                                    ?>
                                    <option value="<?= $category->getId(); ?>" <?= selected($category->getId(), isset($fields['category-parent'])?$fields['category-parent']:null); ?>><?= $category->getName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="btn-group pull-right">
                    <button name="add" type="submit" class="btn btn-success">
                        Add Category <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
require_once("footer.php");
?>