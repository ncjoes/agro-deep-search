<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    11:04 PM
 */

$__autoload = array(
    "System/Functions/site-info.php",
    "System/Functions/functions-lib.php",
    "Application/Config/routes.php",
    "Application/Config/no-read.php",
    "System/Functions/form-elements.php"
    );
foreach($__autoload as $file)
{
    if(defined('PARENT_DIR')) $file = PARENT_DIR.'/'.$file;
    if(is_file($file))
    {
        require_once($file);
    }
    else
    {
        echo "<br/>File -- ".$file." -- not found" ;
        exit;
    }
}

function __autoload( $path )
{
    if( preg_match( '/\\\\/', $path ) )
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path );
    }
    if( preg_match('#PHPCrawl#', $path))
    {
        $path .= ".class.php";
    }
    else
    {
        $path .= ".php";
    }

    if(!is_file($path))
    {
        echo "File not found"."<br/>".$path;
        exit;
    }
    require_once($path);
}