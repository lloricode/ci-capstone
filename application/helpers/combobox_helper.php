<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('_numbers_for_drop_down'))
{

        /**
         * 
         * @param int $s start
         * @param int $e end
         * @return array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com
         */
        function _numbers_for_drop_down($s, $e)
        {
                $array       = array();
             //   $array[NULL] = 'select';
                for ($i = $s; $i <= $e; $i++)
                {
                        $array[$i] = $i;
                }
                return $array;
        }

}