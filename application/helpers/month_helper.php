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
                    '01' => 'January',
                    '02' => 'February',
                    '03' => 'March',
                    '04' => 'April',
                    '05' => 'May',
                    '06' => 'June',
                    '07' => 'July',
                    '08' => 'Augost',
                    '09' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December',
                );
                return $month[$month_number];
        }

}