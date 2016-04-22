<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: PPSMB-Enugu Website
 * Date:    11/29/2015
 * Time:    1:06 PM
 **/
require_once("raw-header.php");
?>
<body>
<div class="height-100vh bg-color-4">
    <nav class="navbar navbar-inverse bg-color1 navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php home_url('/'); ?>">
                    <span class="glyphicon glyphicon-home"></span> <?= site_info('name',0); ?>
                </a>
            </div>
            <div id="navbar" class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <?php
                    $session_user = $requestContext->getSession()->getUser();
                    $default_privilege = $session_user->getDefaultPrivilege();
                    ?>
                    <li class="dropdown <?=$rc->isRequestUrl('crawl-engine') ? 'active': ''; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-cloud-download"></span>
                            Crawl Engine
                            <span class="glyphicon glyphicon-collapse-down"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php home_url('/crawl-engine/'); ?>"><span class="glyphicon glyphicon-forward"></span> Run Crawl</a></li>
                            <li><a href="<?php home_url('/crawl-engine/manage-links/'); ?>"><span class="glyphicon glyphicon-link"></span> Link Frontier</a></li>
                            <li><a href="<?php home_url('/crawl-engine/manage-forms/'); ?>"><span class="glyphicon glyphicon-book"></span> Manage Forms</a></li>
                            <li><a href="<?php home_url('/crawl-engine/manage-features/'); ?>"><span class="glyphicon glyphicon-leaf"></span> Manage Features</a></li>
                            <li><a href="<?php home_url('/crawl-engine/default-last_crawl-settings/'); ?>"><span class="glyphicon glyphicon-cog"></span> Crawler Configurations</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?=$rc->isRequestUrl('admin-panel') ? 'active': ''; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-edit"></span>
                            Admin Panel
                            <span class="glyphicon glyphicon-collapse-down"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php home_url('/admin-panel/manage-posts/'); ?>">Manage Posts</a></li>
                            <li><a href="<?php home_url('/admin-panel/manage-pages/'); ?>">Manage Website Pages</a></li>
                            <li><a href="<?php home_url('/admin-panel/manage-categories/'); ?>">Manage Post Categories</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?= ($rc->isRequestUrl('my-account') ? 'active': ''); ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span> <?= $session_user->getFirstName(); ?> <span class="glyphicon glyphicon-collapse-down"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php home_url('/my-account/edit-profile')?>"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
                            <li><a href="<?php home_url('/my-account/change-password/')?>"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
                            <li><a href="<?php home_url('/logout/');?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container-fluid" id="container-main">
