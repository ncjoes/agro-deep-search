<?php
/**
 * Phoenix Laboratories NG.
 * Author: N. C. Joseph (phoenixlabs.ng@gmail.com)
 * Project: staff_portal
 * Date: 7/8/15
 * Time: 10:50 PM
 */

namespace System\Utilities;

class DateTime
{
    private $micro_time;

    public function __construct($micro_time=null)
    {
        $this->micro_time = is_null($micro_time) ? mktime() : $micro_time;
    }

    public static function getDateTimeObjFromInt($micro_time)
    {
        return new self($micro_time);
    }

    public function getDateTimeInt()
    {
        return $this->micro_time;
    }
    public function getDateTimeStr($date_separator="-", $time_separator=":")
    {
        return date("d{$date_separator}m{$date_separator}Y | g{$time_separator}i{$time_separator}s A",$this->micro_time);
    }
    public function getDateTimeStrF($format)
    {
        return date($format, $this->micro_time);
    }

    public function getYear()
    {
        return date('Y',$this->micro_time);
    }
    public function getMonth()
    {
        return date('m',$this->micro_time);
    }
    public function getDay()
    {
        return date('d',$this->micro_time);
    }
    public function getHour()
    {
        return date('g',$this->micro_time);
    }
    public function getMinute()
    {
        return date('i',$this->micro_time);
    }
    public function getSeconds()
    {
        return date('s',$this->micro_time);
    }
    public function getAmPm()
    {
        return date('A',$this->micro_time);
    }

    public static function checktime($hour=0, $minute=0, $seconds=0)
    {
        if (($hour >= 0 and $hour <= 23) and ($minute >= 0 and $minute <= 59) and ($seconds >= 0 and $seconds <= 59))
        {
            return true;
        }
        return false;
    }
}