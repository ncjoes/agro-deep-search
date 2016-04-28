<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

require_once("raw-header.php");
?>
<nav class="navbar navbar-inverse no-margin no-padding">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?php home_url()?>" class="navbar-brand"><span class="glyphicon glyphicon-home"></span> <?php site_info('name'); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form name="search-form" method="get" enctype="application/x-www-form-urlencoded" action="<?php home_url('/'); ?>" class="nav navbar-form navbar-left">
                <div class="form-group form-group-sm">
                    <label for="search">
                        <input name="search" id="search" type="search" required class="form-control" size="70" placeholder="Search" value="<?= isset($data['search-term']) ? $data['search-term'] : ''; ?>"/>
                    </label>
                </div>
                <div class="form-group form-group-sm">
                    <button id="run-search" class="btn btn-sm btn-primary">
                        <span class="glyphicon glyphicon-search"></span> Search
                    </button>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php site_info('parent-site-url'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
                <li <?= ($rc->isRequestUrl('page/about') ? 'class="active"': ''); ?>><a href="<?php home_url('/page/about/')?>">About</a></li>
                <li <?= ($rc->isRequestUrl('contact') ? 'class="active"': ''); ?>><a href="<?php home_url('/contact/')?>">Contact</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid height-85vh">
