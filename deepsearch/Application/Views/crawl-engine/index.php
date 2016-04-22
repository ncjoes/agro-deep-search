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

$extra_headers = "<link href=\"".home_url('/Assets/css/crawl-engine.css',false)."\" type=\"text/css\" rel=\"stylesheet\">";
require_once("header.php");
$fields = $data['fields'];
$sid = $data['sid'];
?>
<script type="text/javascript">
    var intervalHandle;

    function refreshMonitorStatus()
    {
        setTimeout(function () {
            intervalHandle = setInterval(function ()
            {
                var cid = document.getElementById('crawler-id').getAttribute('value');
                htmlGetRequest("<?= home_url('/crawl-engine/crawl-progress-info/', false) ?>", "<?= 'sid='.$sid; ?>&cid="+cid, refreshStatusText );
                var $contents = $('#crawled-links-view').contents();
                $contents.scrollTop($contents.height());
            }, 2000 );

            setTimeout(function () {
                showNode('crawler-monitor');
            }, 3000);
        }, 1000)
    }

    function refreshStatusText( html )
    {
        var crawler_status_code = document.getElementById('crawl-status-code').getAttribute('value');
        if (crawler_status_code == 1)
        {
            clearInterval(intervalHandle);
            document.getElementById('monitor-display-toggle').removeAttribute('disabled');
            document.getElementById('crawl-process-starter').removeAttribute('disabled');
            document.getElementById('process-stopper').setAttribute('disabled', 'disabled');
        }
        else
        {
            document.getElementById('crawl-progress-info').innerHTML = html;
            document.getElementById('crawl-process-starter').setAttribute('disabled', 'disabled');
        }
    }
</script>

<div class="row">
    <div class="col-md-10 col-md-offset-1 main">
        <h3 class="page-header">Run Web Crawl</h3>
        <form method="post" enctype="multipart/form-data" action="<?php home_url('/crawl-engine/run-crawl/'); ?>" target="crawled-links-view"
              onsubmit="refreshMonitorStatus('monitor-display-toggle');">

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
                        <input name="val[setPort]" id="setPort" type="number" class="form-control" value="<?= isset($fields['val']['setPort']) ? $fields['val']['setPort'] : '8080'; ?>" placeholder="8080"/>
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
                    <div class="col-xs-5 col-xs-offset-1 col-sm-3 col-sm-offset-3 text-right">
                        <label for="max-run-time">Maximum Run Time (in minutes)</label>
                    </div>
                    <div class="col-xs-5 col-sm-2">
                        <input name="max-run-time" id="max-run-time" type="number" class="form-control" value="<?= isset($fields['max-run-time']) ? $fields['max-run-time'] : '30'; ?>" placeholder="30"/>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button name="crawl-process-starter" id="crawl-process-starter" type="submit" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-forward"></span> Run Crawl
                </button>
            </div>
        </form>
    </div>
</div>
</div><!--/container-fluid-->

<div id="crawler-monitor" style="display: none;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <h2 class="page-header text-center">Crawler Process Monitor</h2>
                <div id="crawl-progress-info">
                    <input name="crawl-status-code" id="crawl-status-code" type="hidden" value="-1">
                    <input name="crawler-id" id="crawler-id" type="hidden" value="-1">
                </div>
                <hr/>
                <iframe frameborder="0" id="crawled-links-view" align="middle" allowtransparency="1" name="crawled-links-view" scrolling="auto"></iframe>
                <hr/>
                <div class="text-center">
                    <p>
                        <button id="monitor-display-toggle" class="btn btn-primary" onclick="window.location = document.URL;" disabled="disabled">
                            <span class="glyphicon glyphicon-modal-window"></span> Close Monitor
                        </button>
                    </p>
                    <p>
                        <button id="process-stopper" class="btn btn-sm btn-danger" onclick="clearInterval(intervalHandle); window.location = document.URL;">
                            <span class="glyphicon glyphicon-off"></span> Stop Crawl
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
<?php
require_once("footer.php");
?>
