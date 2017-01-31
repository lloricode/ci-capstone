<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('my_day'))
{

        /**
         * 
         * @return String Sun,Mon
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
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
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
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