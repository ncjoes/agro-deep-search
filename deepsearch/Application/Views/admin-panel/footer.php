<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/29/2015
 * Time:    1:14 PM
 **/

$rc = \System\Request\RequestContext::instance();
$mode = "navbar-fixed-bottom";
?>
</div><!--/container-fluid-->

<!-- Bottom navbar -->
<nav class="navbar navbar-default navbar-inverse navbar-static-top footer-nav <?= isset($mode) && is_string($mode) ? $mode : ''; ?>">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-footer" aria-expanded="false" aria-controls="navbar-footer">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">&copy; <?= date('Y').' '.site_info('short-name',0); ?></a>
        </div>
        <div id="navbar-footer" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li <?= ($rc->isRequestUrl('page/privacy-policy') ? 'class="active"': ''); ?>><a href="<?php home_url('/page/privacy-policy'); ?>">Privacy</a></li>
                <li <?= ($rc->isRequestUrl('page/terms-of-use') ? 'class="active"': ''); ?>><a href="<?php home_url('/page/terms-of-use'); ?>">Terms</a></li>
                <li>
                    <a href="<?php site_info('designer-url'); ?>" target="_blank" title="Built with BareBones PHP Framework by <?php site_info('designer-name') ?>">
                        <span class="glyphicon glyphicon-picture"></span> Credits
                    </a>
                </li>
                <li><a href="#top" title="Back Up"><span class="glyphicon glyphicon-circle-arrow-up"></span></a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php home_url('/Assets/js/jquery.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/barebones.js'); ?>"></script>
<?= isset($extra_footers) ? $extra_footers : ""; ?>

</div>
</body>
</html>