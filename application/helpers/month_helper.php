<?php

defined('BASEPATH') or exit('no direct script allowed');
if ( ! function_exists('my_month_array'))
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

// ------------------------------------------------------------------------

if ( ! function_exists('get_months_in_between'))
{

        /**
         * get months in between
         * 
         * @param int $start
         * @param int $end
         * @return array of int
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function get_months_in_between($start, $end)
        {
                $output = array();
                if (($start < 1 OR $start > 12) OR ( $end < 1 OR $end > 12))
                {
                        show_error('invalid in ' . __FILE__ . ' at line:' . __LINE__);
                }
                if ($start < $end)
                {
                        for ($i = $start; $i < $end; $i ++ )
                        {
                                $output[] = $i;
                        }
                }
                elseif ($start > $end)
                {
                        for ($i = $start; $i <= 12; $i ++ )
                        {
                                $output[] = $i;
                        }
                        for ($i = 1; $i < $end; $i ++ )
                        {
                                $output[] = $i;
                        }
                }
                return $output;
        }

}