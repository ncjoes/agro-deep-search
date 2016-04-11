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
        </div>
        <div id="navbar-footer" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a>&copy; <?= '2015 - '.date('Y').' '.site_info('name',0); ?></a></li>
            </ul>
<ul class="nav navbar-nav navbar-right">
    <li><a href="<?php site_info('contractor-url'); ?>" target="_blank"><span class="glyphicon glyphicon-certificate"></span> Powered By <?php site_info('contractor-name'); ?></a></li>
    <li><a href="<?php site_info('designer-url'); ?>" target="_blank" title="Built with BareBones PHP Framework by <?php site_info('designer-name') ?>"><span class="glyphicon glyphicon-picture"></span> Design</a></li>
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

</div>
</body>
</html>