<?php

defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('dash'))
{

        /**
         * Dash
         *
         * Takes multiple words separated by spaces and dash them
         *
         * @param	string	$str	Input string
         * @return	string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function dash($str)
        {
                return preg_replace('/[\s]+/', '-', trim(MB_ENABLED ? mb_strtolower($str) : strtolower($str)));
        }

}

// --------------------------------------------------------------------

if ( ! function_exists('inflector_int_unit'))
{

        function inflector_int_unit($int_value, $unit)
        {
                $int_value = (int) $int_value;
                if ($int_value === 0)
                {
                        return '--';
                }

                if ($int_value > 1)
                {
                        $unit = plural($unit);
                }

                return $int_value . ' ' . $unit;
        }

}