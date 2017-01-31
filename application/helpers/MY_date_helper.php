<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('my_datetime_format'))
{

        /**
         * 
         * @return string value: %Y:%m:%d sample : 2016:12:31
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_datetime_format()
        {
                $datestring = '%Y:%m:%d';
                $time       = time();
                return mdate($datestring, $time);
        }

}

if (!function_exists('my_converter_datetime_format'))
{

        /**
         * 
         * @param string $timestamp
         * @param string time or date
         * @return string December 30, 20016
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_converter_datetime_format($timestamp, $dt)
        {
                if ($dt == 'date')
                {
                        $format = '%Y:%m:%d';
                        list($YY, $mm, $dd) = explode(':', mdate($format, $timestamp));
                        return $this->my_month_array($mm) . ' ' . $dd . ', ' . $YY;
                }
                elseif ($dt == 'time')
                {
                        $format = '%h:%i %a';
                        return mdate($format, $timestamp);
                }
        }

}

if (!function_exists('my_current_datetime_information'))
{

        /**
         * 
         * @return string December 30, 20016 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_current_datetime_information()
        {
                $datetimeformated = my_datetime_format();
                list($YY, $mm, $dd) = explode(':', $datetimeformated);
                $CI               = & get_instance();
                $CI->load->helper('month');
                return my_month_array($mm) . ' ' . $dd . ', ' . $YY;
        }

}