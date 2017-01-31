<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('my_htmlspecialchars'))
{

        /**
         * Convert special characters to HTML entities
         * 
         * @param string $string
         * @return string
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        function my_htmlspecialchars($string)
        {
                $_ci = get_instance();
                return htmlspecialchars($string, ENT_QUOTES, $_ci->config->item('charset'));
        }

}