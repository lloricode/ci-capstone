<?php

defined('BASEPATH') or exit('no direct script allowed');
if (!function_exists('my_month_array'))
{

        /**
         * 
         * @param type $month_number
         * @return string 1=January 2=February, etc..
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_month_array($month_number)
        {
                $month = array(
                    1  => 'January',
                    2  => 'February',
                    3  => 'March',
                    4  => 'April',
                    5  => 'May',
                    6  => 'June',
                    7  => 'July',
                    8  => 'Augost',
                    9  => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December',
                );
                return $month[$month_number];
        }

}