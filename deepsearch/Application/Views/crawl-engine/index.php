<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    10:09 AM
 **/

require_once("header.php");
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1 main">
        <h3 class="page-header">Run Web Crawl</h3>
        <form method="post" enctype="multipart/form-data" action="">

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="url-option"><span class="glyphicon glyphicon-link"></span> URL To Crawl</label>
                    </div>
                    <div class="col-sm-10">
                        <select name="url-option" class="form-control" id="url-option">
                            <option value="1" <?= selected(1, isset($fields['url-option']) ? $fields['url-option'] : null); ?>>Get Most Relevant Link from Link-Frontier</option>
                            <option value="2" <?= selected(2, isset($fields['url-option']) ? $fields['url-option'] : null); ?>><label for="url">Custom URL</label></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm" id="url-input">
                <div class="row">
                    <div class="col-sm-2 col-md-1"><label for="url">URL</label></div>
                    <div class="col-sm-6 col-md-8">
                        <input name="url" id="url" type="url" class="form-control" value="<?= isset($fields['url']) ? $fields['url'] : ''; ?>" placeholder="http://www.site.com/"/>
                    </div>
                    <div class="col-sm-2 col-md-1"><label for="port">Port</label></div>
                    <div class="col-sm-2">
                        <input name="port" id="port" type="number" class="form-control" value="<?= isset($fields['port']) ? $fields['port'] : ''; ?>" placeholder="8080"/>
                    </div>
                </div>
            </div>
            <hr/>
            <?php
            require_once("Application/Views/_includes/crawler-config.php");
            ?>
            <hr/>
            <div class="text-center">
                <button name="start" type="submit" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-forward"></span> Start Crawl
                </button>
            </div>
        </form>
    </div>
</div>
<?php
require_once("footer.php");
?>
