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
                    '01' => lang('cal_january'),
                    '02' => lang('cal_february'),
                    '03' => lang('cal_march'),
                    '04' => lang('cal_april'),
                    '05' => lang('cal_mayl'), //bugs on CI
                    '06' => lang('cal_june'),
                    '07' => lang('cal_july'),
                    '08' => lang('cal_august'),
                    '09' => lang('cal_september'),
                    '10' => lang('cal_october'),
                    '11' => lang('cal_november'),
                    '12' => lang('cal_december')
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