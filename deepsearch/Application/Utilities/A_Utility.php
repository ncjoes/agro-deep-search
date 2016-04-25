<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/20/2016
 * Time:    9:15 AM
 **/


namespace Application\Utilities;


abstract class A_Utility
{
    /**
     * @param $string
     * @return string $hash
     */
    public static function hashString($string)
    {
        $hashed_string = md5($string);
        return $hashed_string;
    }

    public static function trimUrl($url)
    {
        $url_comp = parse_url($url);
        if(is_array($url_comp))
        {
            $url = "";
            if(isset($url_comp['scheme'])) $url .= strtolower(trim($url_comp['scheme'], "://"))."://";
            if(isset($url_comp['host'])) $url .= strtolower($url_comp['host']);
            if(isset($url_comp['port'])) $url .= ":".$url_comp['port'];
            if(isset($url_comp['path'])) $url .= "/".trim($url_comp['path'], "/")."/";
            if(isset($url_comp['query'])) $url .= "?".trim($url_comp['query'], "?");
            if(isset($url_comp['fragment'])) $url .= "#".trim($url_comp['fragment'], "#");
        }
        return  trim($url, " \t\n\r\v\\");
    }

    public static function trimFormMarkup($markup)
    {
        return trim($markup, " /\t\n\r\v\\");
    }

    public static function getDOMNodeHTML(\DOMNode $DOMNode)
    {
        $html = new \DOMDocument();
        $html->appendChild($html->importNode($DOMNode, true));
        return A_Utility::trimFormMarkup($html->saveHTML());
    }
}