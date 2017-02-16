<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('time_list'))
{

        /**
         * 
         * create and array or time, depend on parameters given, 
         * 
         * return will be key is 24rhs,value is 12 hrs
         * 
         * 
         * 
         * @param string $start | default = 06:00
         * @param string $end | default = 18:30
         * @param int $hours_incrementation | default = 1
         * @param int $minute_incrementation | default = 30
         * @return array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function time_list($start = '06:00', $end = '18:30', $hours_incrementation = 1, $minute_incrementation = 30)
        {
                $arr [''] = 'Time';

                /**
                 * explode value, assuming value parameter is valid,so make sure, parameter has valid value,
                 * its ok, only developer will set this, not user
                 */
                list($s_h, $s_m) = explode(':', $start);
                list($e_h, $e_m) = explode(':', $end);

                for ($hh = $s_h; $hh <= $e_h; $hh += $hours_incrementation)
                {
                        /**
                         * default start/end in minute
                         */
                        $mm_start = 0;
                        $mm_end   = 60;
                        /**
                         * check if #hh loop is equal in parameter
                         */
                        if ($hh == $s_h)
                        {
                                /**
                                 * then set start minute for start $hh depend on parameter value
                                 */
                                $mm_start = $s_m;
                        }
                        /**
                         * for end minute in end hour
                         */
                        if ($hh == $e_h)
                        {
                                $mm_end = $e_m;
                        }
                        /**
                         * start the loop
                         */
                        for ($mm = $mm_start; $mm <= $mm_end; $mm += $minute_incrementation)
                        {
                                $hour   = $hh;
                                $minute = $mm;
                                if ($mm == 60)
                                {
                                        $hour ++;
                                        $minute = 0;
                                }
                                $time__ = str_pad($hour, 2, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($minute, 2, '0', STR_PAD_LEFT);

                                $arr[$time__] = convert_24_to_12hrs($time__);
                        }
                }

                return $arr;
        }

}

if (!function_exists('convert_24_to_12hrs'))
{

        /**
         * convert 24hr to 12 hr
         * 
         * sample: 13:00 to 1:00 PM
         * 
         * @param string $hr24
         * @return string | converted time to 12hr
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function convert_24_to_12hrs($hr24 = NULL)
        {
                if (!strpos($hr24, ':'))
                {
                        return 'invalid time format.';
                }
                if (empty($hr24) || is_null($hr24))
                {
                        return;
                }
                $ap = 'AM';
                list($hh, $mm) = explode(':', $hr24);

                if ($hh > 12)
                {
                        $hh -= 12;
                        $ap = 'PM';
                }

                return str_pad($hh, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mm, 2, '0', STR_PAD_LEFT) . ' ' . $ap;
        }

}

