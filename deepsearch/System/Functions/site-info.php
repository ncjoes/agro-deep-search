<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/23/2015
 * Time:    3:11 PM
 */

function site_info($index, $show = true)
{
    $site_info = \Application\Config\ApplicationRegistry::siteInfo();
    $return_value = null;
    if(isset($site_info[$index])){$return_value = $site_info[$index];}
    if($show){ echo $return_value;} else {return $return_value; }
}

function home_url($appendage='', $show = true)
{
    $return_value = site_info('site-url', false).$appendage;
    if($show){ echo $return_value;} else {return $return_value; }
}

function stylesheet_url($show = true)
{
    $return_value = site_info('site-url', false)."/".site_info('stylesheet-url', false);
    if($show){ echo $return_value;} else {return $return_value; }
}

function is_development()
{
    return (!is_null(site_info('development-mode', false)) ? site_info('development-mode', false) : true);
}