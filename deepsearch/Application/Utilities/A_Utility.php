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
        return strtolower( trim($url, " /\t\n\r\v\\") );
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