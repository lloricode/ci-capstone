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
                if ($CI->session->has_userdata($data))//check session if exist.
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
                        $CI->session->set_userdata($data, array($new_value));  //just create new one then initialize the first value.
                }
        }

}

if (!function_exists('unset_userdata_array'))
{

        /**
         * remove one value/index in session array
         * 
         * @param type $data
         * @param type $value_to_remove
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function unset_userdata_array($data, $value_to_remove)
        {
                $CI = &get_instance();
                if ($CI->session->has_userdata($data))//check session if exist.
                {
                        /**
                         * same old values
                         */
                        $old_values = array();

                        foreach ($CI->session->userdata($data) as $value)
                        {
                                if ($value == $value_to_remove)
                                {
                                        /**
                                         * just skip the value want to unset
                                         */
                                        continue;
                                }
                                $old_values[] = $value;
                        }
                        
                        if (count($old_values) == 0)
                        {
                                $CI->session->unset_userdata($data); //else unset userdata, because it has no value
                        }
                        else
                        {
                                $CI->session->set_userdata($data, $old_values); //replaca the value with removal if any.
                        }
                }
        }

}