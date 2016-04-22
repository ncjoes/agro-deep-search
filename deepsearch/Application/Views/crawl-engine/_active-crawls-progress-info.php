<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/20/2016
 * Time:    8:20 PM
 **/

$rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();
$current_crawl = $data['current-crawl'];
?>
    <input name="crawl-status-code" id="crawl-status-code" type="hidden" value="<?= $data['status']; ?>">
    <input name="crawler-id" id="crawler-id" type="hidden" value="<?= $data['cid']; ?>">
<?php
switch ($data['status'])
{
    case -1 :
    {
        ?>
        <div class="text-center full-margin-bottom text-info bg-info">No active crawler processes running at the moment<br/><?= $rc->getFlashData();?></div>
        <?php
    } break;
    case 0 :
    {
        ?>
        <div class="text-center full-margin-bottom text-danger bg-danger">Crawling process has been terminated<br/><?= $rc->getFlashData();?></div>
        <?php
    } break;
    case 1 :
    {
        ?>
        <div class="text-center full-margin-bottom text-success bg-success">Crawling process has been completed successfully</div>
        <?php
    } break;
    case 2 :
    {
        ?>
        <div class="text-center full-margin-bottom text-info bg-info">Running Crawl <?= $current_crawl->getCrawlerId(); ?> / <?= $current_crawl->getStartUrl()?></div>
        <?php
    } break;
}

if($data['status'] == 1 or $data['status'] == 2)
{
?>
    <div class="row text-center">
        <div class="col-sm-2 col-sm-offset-0 col-xs-5 col-xs-offset-1">
            <small>Links Followed</small>
            <h3><?= $current_crawl->getNumLinksFollowed(); ?></h3>
        </div>
        <div class="col-sm-2 col-sm-offset-0 col-xs-5 col-xs-offset-0">
            <small>Documents Received</small>
            <h3><?= $current_crawl->getNumDocumentsReceived(); ?></h3>
        </div>
        <div class="col-sm-2 col-sm-offset-0 col-xs-5 col-xs-offset-1">
            <small>Links Extracted</small>
            <h3><?= $current_crawl->getNumLinksExtracted(); ?></h3>
        </div>
        <div class="col-sm-2 col-sm-offset-0 col-xs-5 col-xs-offset-0">
            <small>Forms Extracted</small>
            <h3><?= $current_crawl->getNumFormsExtracted(); ?></h3>
        </div>
        <div class="col-sm-2 col-sm-offset-0 col-xs-5 col-xs-offset-1">
            <small>Bandwidth Usage</small>
            <h3>~<?= get_file_size_unit($current_crawl->getNumByteReceived()); ?></h3>
        </div>
        <div class="col-sm-2 col-sm-offset-0 col-xs-5 col-xs-offset-0">
            <small>Time Elapsed</small>
            <h3><?= seconds_to_str($current_crawl->getProcessRunTime()); ?></h3>
        </div>
    </div>
<?php
}