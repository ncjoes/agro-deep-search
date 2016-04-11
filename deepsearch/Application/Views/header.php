<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

$requestContext = $rc = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();
$page_title = isset($data['page-title']) ? $data['page-title'] : site_info('name',0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="<?php site_info('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="J. C. Nwobodo">

    <title><?= $page_title; ?> :: <?php site_info('short-name'); ?></title>
    <link rel="icon" href="#">

    <!-- Custom CSS and Bootstrap core CSS -->
    <link href="<?php stylesheet_url(); ?>" type="text/css" rel="stylesheet">
</head>

<body>
<div id="outer-body-wrapper">
    <div id="inner-body-wrapper">

        <div class="container-fluid height-60vh">
