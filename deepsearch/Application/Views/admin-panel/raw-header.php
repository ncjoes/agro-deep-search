<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: E-Stamp
 * Date:    3/24/2016
 * Time:    4:45 AM
 **/

$requestContext = $rc = \System\Request\RequestContext::instance();
$data = $rc->getResponseData();
$page_title = isset($data['page-title']) ? $data['page-title'] : site_info('name',0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="J. C. Nwobodo">
    <link rel="icon" href="<?php home_url('/Assets/images/enugu-state-logo.png'); ?>">

    <title><?= $page_title; ?> :: <?php site_info('short-name'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php home_url('/Assets/css/style.css'); ?>" type="text/css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php home_url('/Assets/css/dashboard.css'); ?>" type="text/css" rel="stylesheet">

    <!-- Additional Headers -->
    <?= isset($extra_headers) ? $extra_headers : ''; ?>
</head>