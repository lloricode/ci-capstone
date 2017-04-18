<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$CI     = & get_instance();
$buffer = $CI->output->get_output();

$CI->output->set_output(_compress($buffer));
$CI->output->_display();

function _compress($buffer)
{
        if (ENVIRONMENT != 'production')
        {
                return $buffer;
        }
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s',
            '/\>(\s)+\</'
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            "//&lt;![CDATA[\n" . '\1' . "\n//]]>",
            '><'
        );

        return preg_replace($search, $replace, $buffer);
}
