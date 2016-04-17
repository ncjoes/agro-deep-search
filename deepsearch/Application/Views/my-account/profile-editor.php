<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Enugu Website
 * Date:    4/7/2016
 * Time:    9:28 PM
 **/

require_once("header.php");

$fields = $data['fields'];
?>
    <div class="row">
        <?php
        require_once("sidebar.php");
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h3 class="page-header">
                <span class="glyphicon glyphicon-edit"></span> Edit My Profile
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0)); ?>" class="btn btn-primary" title="View Profile"><span class="glyphicon glyphicon-user"></span> <span class="sr-only">View Profile</span></a>
                <a href="<?php home_url('/'.$rc->getRequestUrlParam(0).'/change-password/'); ?>" class="btn btn-primary" title="Change Password"><span class="glyphicon glyphicon-lock"></span> <span class="sr-only">Change Password</span></a>
            </h3>
            <div class="text-center mid-margin-bottom <?= (isset($data['status']) and $data['status']) ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $rc->getFlashData(); ?></div>

            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row">

                            <div class="col-md-4">
                                <!--Photo-->
                                <div class="form-group form-group-sm">
                                    <label for="photo">
                                        <span class="glyphicon glyphicon-picture"></span> Photo<br/>
                                        <img src="<?php home_url('/'.$fields['photo']) ?>" class="img-responsive img-thumbnail">
                                    </label>

                                    <input name="photo" id="photo" type="file" class="form-control">
                                    <p class="help-block">
                                        Max. file size: 150KB<br/>
                                        Formats: JPG
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-8">

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="title">Title</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="title" id="title" type="text" maxlength="50" class="form-control" value="<?= isset($fields['title']) ? $fields['title'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="first-name">First Name</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="first-name" id="first-name" required type="text" maxlength="100" class="form-control" value="<?= isset($fields['first-name']) ? $fields['first-name'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="middle-name">Middle Name</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="middle-name" id="middle-name" type="text" maxlength="100" class="form-control" value="<?= isset($fields['middle-name']) ? $fields['middle-name'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="last-name">Last Name</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="last-name" id="last-name" required type="text" maxlength="100" class="form-control" value="<?= isset($fields['last-name']) ? $fields['last-name'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="email" id="email" required type="email" maxlength="50" class="form-control" value="<?= isset($fields['email']) ? $fields['email'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="phone">Phone</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="phone" id="phone" required type="tel" maxlength="11" class="form-control" value="<?= isset($fields['phone']) ? $fields['phone'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="address1">Address 1</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="address1" id="address1" required type="text" maxlength="100" class="form-control" value="<?= isset($fields['address1']) ? $fields['address1'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="address2">Address 2</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input name="address2" id="address2" type="text" maxlength="50" class="form-control" value="<?= isset($fields['address2']) ? $fields['address2'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="city">City / Zip Code</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input name="city" id="city" required type="text" maxlength="50" class="form-control" placeholder="City" value="<?= isset($fields['city']) ? $fields['city'] : ''; ?>"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="zip_code" id="zip_code" type="number" maxlength="10" class="form-control" placeholder="######" value="<?= isset($fields['zip_code']) ? $fields['zip_code'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="state">State / Country</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input name="state" id="state" required type="text" maxlength="50" class="form-control" placeholder="State" value="<?= isset($fields['state']) ? $fields['state'] : ''; ?>"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input name="country" id="country" required type="text" maxlength="50" class="form-control" placeholder="Country" value="<?= isset($fields['country']) ? $fields['country'] : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label for="biography">Biography</label>
                                    <textarea name="biography" id="biography" class="form-control html-editor" spellcheck="true" style="height: 20em;"><?= isset($fields['biography']) ? $fields['biography'] : ''; ?></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="text-center">
                            <button name="save-changes" type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-save-file"></span> Save Changes
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