<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/4/2015
 * Time:    11:24 PM
 */

//STRING PROCESSING
function recursive_implode($glue, $pieces)
{
    $build = array();
    foreach($pieces as $piece)
    {
        $build[] = is_array($piece) ? recursive_implode($glue, $piece) : ( is_object($piece) ? print_r($piece,true) : $piece);
    }
    return implode($glue, $build);
}

function format_text($raw_text)
{
    $all_paragraphs = explode("\n", $raw_text);
    $valid_paragraphs = array();
    foreach($all_paragraphs as $paragraph){if(strlen($paragraph)) $valid_paragraphs[] = $paragraph;}
    $formatted_text = '<p>'.implode('</p><p>', $valid_paragraphs).'</p>';

    return $formatted_text;
}

function remove_text_formatting($formatted_text)
{
    $raw_text = str_replace("</p><p>","\n", $formatted_text);
    $raw_text = str_replace(array("<p>","</p>"), array("",""), $raw_text);
    return $raw_text;
}

function num_words($string)
{
    $raw_words = explode(" ", $string);
    $processed_words = array();
    foreach($raw_words as $raw_word){if(strlen($raw_word)) $processed_words[] = $raw_word;}
    return sizeof($processed_words);
}

function sub_words($string, $start, $length)
{
    $words = explode(' ', $string);
    $return = array();
    $limit = sizeof($words);
    $start = $start <= $limit ? $start : 0;
    $len = $length <= ($limit - $start) ? $length : ($limit - $start);

    for($i = 0, $p = $start; $i < $len; ++$i, ++$p)
    {
        $return[] = $words[$p];
    }
    return implode(' ', $return);
}

function validate_email($email)
{
    $regexp = "/([_a-z0-9-]+)(.[_a-z0-9-]+)*@([a-z0-9-]+)(.[a-z0-9-]+)*(.[a-z]{2,6})/i";
    if(preg_match($regexp,$email))
    {
        return true;
    }
    return false;
}

function validate_webAddress($address)
{
    $regexp = "^([a-z]{3,4})://([a-z]+).(\.[_a-z0-9-]+).([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,6})$";
    if(preg_match($regexp,$address))
    {
        return true;
    }
    return false;
}

function validate_phone($phone)
{
    $mtn = array('0803','0806','0813','0816','0811','0814','0703','0706','0903');
    $etisalat = array('0809','0807','0819','0817','0818','0808','0708','0900','0909');
    $glo = array('0805','0815','0705');
    $others = array('0802','0812','0810','0701');
    $prefixes = array_merge($mtn,$etisalat);
    $prefixes = array_merge($prefixes, $glo);
    $prefixes = array_merge($prefixes, $others);

    foreach($prefixes as $prefix)
    {
        $regexp = "/(".$prefix.")([0-9]{7})/";
        if(preg_match($regexp,$phone)){return true;}
    }
    return false;
}

//FILE FUNCTIONS
function directory_size($directory)
{
    $directorySize=0;
    if ($dh = @opendir($directory))
    {
        while (($filename = readdir($dh)))
        {
            if ($filename != "." && $filename != "..")
            {
                if(is_file($directory."/".$filename))
                {
                    $directorySize += filesize($directory."/".$filename);
                }
                if(is_dir($directory."/".$filename))
                {
                    $directorySize += directory_size($directory."/".$filename);
                }
            }
        }
    }
    @closedir($dh);
    return $directorySize;
}

function remove_dir($dir)
{
    if ($dh = @opendir($dir))
    {
        /* Iterate through directory contents. */
        while (($file = readdir ($dh)) != false)
        {
            if (($file == ".") || ($file == "..")) continue;
            if (is_dir($dir . '/' . $file))
            {
                remove_dir($dir . '/' . $file);
            }
            else
            {
                unlink($dir . '/' . $file);
            }
        } #endWHILE

        @closedir($dh);
        rmdir($dir);
    } #endIF
} #end delete_directory()

function get_file_size_unit($file_size)
{
    switch (true) {
        case ($file_size/1024 < 1) :
            return intval($file_size ) ." Bytes" ;
            break;
        case ($file_size/1024 >= 1 && $file_size/(1024*1024) < 1)  :
            return intval($file_size/1024) ." KB" ;
            break;
        default:
            return intval($file_size/(1024*1024)) ." MB" ;
    }
}

//TIME MANIPULATION
function preProcessTimeArr(array &$time)
{
    $time['hour'] = (strtolower($time['am_pm'])=='pm' and $time['hour']!=12)? ($time['hour']+12) : $time['hour'];
    $time['hour'] = (strtolower($time['am_pm'])=='am' and $time['hour']==12)? 0 : $time['hour'];
}

function getTimeDifference($start,$current=null)
{
    $current = is_null($current) ? mktime() : $current;
    $period_sec = abs($current - $start);
    return seconds_to_str($period_sec);
}

function seconds_to_str($period_sec)
{
    $return_value = NULL;

    if($period_sec < 60)
    {
        $return_value = intval($period_sec).' secs.';
    }
    elseif($period_sec < 3600)
    {
        $return_value = (intval($period_sec/60)).' mins.';
    }
    elseif($period_sec >= 3600 and $period_sec < (3600 * 24) )
    {
        $hrs = intval($period_sec/3600);
        $return_value = ($hrs>0)? (($hrs>1) ? $hrs.' hrs ': $hrs.' hr ') : '';

        $min = intval(($period_sec%3600)/60);
        $return_value .= $min>0 ? $min.' min.' : '';
    }
    elseif($period_sec > (3600 * 24))
    {
        $days = intval($period_sec/(3600*24));
        $return_value .= ($days>0) ? (($days>1) ? $days.' days ': $days.' day ') : '';

        $hrs = ( intval( ($period_sec%(3600*24) ) /3600) );
        $return_value .= ($hrs>0)? (($hrs>1) ? $hrs.' hrs ': $hrs.' hr') : '';

        $min = intval(($period_sec%3600)/60);
        $return_value .= $min>0 ? $min.' min.' : '';
    }
    return $return_value;
}
function getYearsDifference($start,$current=null)
{
    $current = is_null($current) ? mktime() : $current;
    $period_sec = $current - $start;

    $years = (int)$period_sec/(60 * 60 * 24 * 365);
    return $years;
}
