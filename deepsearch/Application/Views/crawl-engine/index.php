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
$fields = $data['fields'];
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1 main">
        <h3 class="page-header">Run Web Crawl</h3>
        <form method="post" enctype="multipart/form-data" action="<?php home_url('/crawl-engine/run-crawl/'); ?>">

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="url-option"><span class="glyphicon glyphicon-link"></span> URL To Crawl</label>
                    </div>
                    <div class="col-sm-10">
                        <select name="url-option" class="form-control" id="url-option" onchange="toggleNodeDisplay('url-input-node')">
                            <option value="1" <?= selected(1, isset($fields['url-option']) ? $fields['url-option'] : null); ?>>Get Most Relevant Link from Link-Frontier</option>
                            <option value="2" <?= selected(2, isset($fields['url-option']) ? $fields['url-option'] : null); ?>><label for="url">Custom URL</label></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm" id="url-input-node" style="display:<?= (isset($fields['url-option']) and $fields['url-option']==2) ? 'block' : 'none'; ?>">
                <div class="row">
                    <div class="col-sm-2 col-md-1"><label for="setURL">URL</label></div>
                    <div class="col-sm-6 col-md-8">
                        <input name="val[setURL]" id="setURL" type="url" class="form-control" value="<?= isset($fields['val']['setURL']) ? $fields['val']['setURL'] : home_url(null, false); ?>" placeholder="http://www.site.com/"/>
                    </div>
                    <div class="col-sm-2 col-md-1"><label for="setPort">Port</label></div>
                    <div class="col-sm-2">
                        <input name="val[setPort]" id="setPort" type="number" class="form-control" value="<?= isset($fields['val']['setPort']) ? $fields['val']['setPort'] : ''; ?>" placeholder="8080"/>
                    </div>
                </div>
            </div>
            <hr/>
            <?php
            require_once("Application/Views/_includes/crawler-config.php");
            ?>
            <hr/>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6 col-sm-3 col-sm-offset-3 text-right">
                        <label for="max-run-time">Maximum Run Time (in minutes)</label>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <input name="max-run-time" id="max-run-time" type="number" class="form-control" value="<?= isset($fields['max-run-time']) ? $fields['max-run-time'] : '10'; ?>" placeholder="10"/>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button name="run-craw" type="submit" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-forward"></span> Run Crawl
                </button>
            </div>
        </form>
    </div>
</div>
<?php
require_once("footer.php");
?>
