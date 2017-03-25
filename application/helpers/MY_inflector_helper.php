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