<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('set_userdata_array'))
{

        /**
         * store/append session
         * 
         * note: it will append new value if its unique
         * 
         * @param type $data
         * @param type $value
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function set_userdata_array($data, $new_value)
        {
                $CI = &get_instance();
                if (isset($_SESSION[$data]))
                {
                        /**
                         * to prevent same value
                         */
                        $unique_values = array();

                        foreach ($CI->session->userdata($data) as $value)
                        {
                                if (!in_array($value, $unique_values))//check if already one
                                {
                                        $unique_values[] = $value; //get the usinque value
                                }
                        }

                        if (!in_array($new_value, $unique_values))//check if already one
                        {
                                $unique_values[] = $new_value; //now append the new value
                        }

                        $CI->session->set_userdata($data, $unique_values); //replaca the value with additional one
                }
                else
                {
                        $CI->session->set_userdata($data, array($new_value));  //just create new one the initialize the value.
                }
        }

}