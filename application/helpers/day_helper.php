<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('my_day'))
{

        /**
         * 
         * @return String Sun,Mon
         */
        function my_day()
        {
                $time = time();
                return mdate('%D', $time);
        }

}

if (!function_exists('days'))
{

        /**
         * 
         * @param type $row
         * @return string
         */
        function days($row)
        {
                $d    = array(
                    'm'  => 'M',
                    't'  => 'T',
                    'w'  => 'W',
                    'th' => 'TH',
                    'f'  => 'F',
                    's'  => 'Sat',
                    'su' => 'Sun',
                );
                $days = '';
                foreach ($d AS $k => $v)
                {
                        $tmp = 'schedule_' . $k;
                        if ($row->$tmp)
                        {
                                $days .= $v;
                        }
                }
                if ($days == '')
                {
                        $days = '--';
                }
                return $days;
        }

}