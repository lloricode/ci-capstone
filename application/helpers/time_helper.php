<?php

defined('BASEPATH') or exit('no direct script allowed');

if ( ! function_exists('time_list'))
{

        /**
         * 
         * create and array for time, depend on parameters given, 
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
        function time_list($tmp = TRUE, $start = '06:00', $end = '18:30', $hours_incrementation = 1, $minute_incrementation = 30)
        {
                $arr = array();
                if ($tmp)
                {
                        $arr [''] = 'Time';
                }
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

// ------------------------------------------------------------------------

if ( ! function_exists('convert_24_to_12hrs'))
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
                if ( ! strpos($hr24, ':'))
                {
                        return 'invalid time format.';
                }
                if (empty($hr24) OR is_null($hr24))
                {
                        return;
                }
                $ap = 'AM';
                list($hh, $mm) = explode(':', $hr24);

                if ($hh >= 12)
                {
                        $hh -= ($hh == 12) ? 0 : 12;
                        $ap = 'PM';
                }

                return str_pad($hh, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mm, 2, '0', STR_PAD_LEFT) . ' ' . $ap;
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('convert_12_to_24hrs'))
{

        function convert_12_to_24hrs($hr12 = NULL)
        {
//                if (!strpos($hr24, ':') OR !strpos($hr24, ' ') OR !strpos($hr24, 'M'))
//                {
//                        return 'invalid time format.';
//                }
                list($time, $ap) = explode(' ', $hr12);
                list($hh, $mm) = explode(':', $time);
                if ($ap == 'PM')
                {
                        $hh += 12;
                }
                return $hh . ':' . $mm;
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('convert_24hrs_to_seconds'))
{

        function convert_24hrs_to_seconds($hr24)
        {
                list($hh, $mm) = explode(':', $hr24);
                $sec = 0;
                $sec += ($hh * 60 * 60);
                $sec += ($mm * 60);
                return (int) $sec;
        }

}

