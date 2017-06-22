<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('set_userdata_array'))
{

        /**
         * store/append session
         * 
         * note: it will append new value if its unique
         * 
         * @param type $data
         * @param type $value
         * @param type $unique
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function set_userdata_array($data, $new_value, $unique = FALSE)
        {
                $CI = &get_instance();
                if ($CI->session->has_userdata($data))//check session if exist.
                {
                        /**
                         * to prevent same value
                         */
                        $new_set_values = array();

                        foreach ($CI->session->userdata($data) as $value)
                        {
                                if ($unique)
                                {
                                        if ( ! in_array($value, $new_set_values))//check if already one
                                        {
                                                $new_set_values[] = $value; //get the unique value
                                        }
                                }
                                else
                                {
                                        $new_set_values[] = $value;
                                }
                        }
                        if ($unique)
                        {
                                if ( ! in_array($new_value, $new_set_values))//check if already one
                                {
                                        $new_set_values[] = $new_value; //now append the new value
                                }
                        }
                        else
                        {
                                $new_set_values[] = $new_value;
                        }
                        $CI->session->set_userdata($data, $new_set_values); //replaca the value with additional one
                }
                else
                {
                        $CI->session->set_userdata($data, array($new_value));  //just create new one then initialize the first value.
                }
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('unset_value_userdata_array'))
{

        /**
         * remove one value/index in session array
         * 
         * @param type $data
         * @param type $value_to_remove
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function unset_value_userdata_array($data, $value_to_remove)
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

// ------------------------------------------------------------------------

if ( ! function_exists('set_session_current_user_data'))
{

        function set_session_current_user_data()
        {
                $CI               = &get_instance();
                $is_dean          = FALSE;
                $dean_course_id   = NULL;
                $dean_course_code = NULL;
                if ($CI->ion_auth->in_group($CI->config->item('user_group_dean')))
                {
                        $is_dean = TRUE;
                        $CI->load->model('Dean_course_model');
                        $obj     = $CI->Dean_course_model->where(array(
                                    'user_id' => $CI->ion_auth->get_user_id()
                                ))->set_cache('Dean_course_model_get_' . $CI->ion_auth->get_user_id())->get();
                        if ($obj)
                        {
                                $CI->load->model('Course_model');
                                $dean_course_id   = $obj->course_id;
                                $dean_course_code = $CI->Course_model->set_cache('Course_model_get_' . $obj->course_id)->get($obj->course_id)->course_code;
                        }
                }
                //set the user name/last name in session
                $user_obj = $CI->ion_auth->user()->row();
                $CI->session->set_userdata(array(
                    'user_first_name'          => $user_obj->first_name,
                    'user_last_name'           => $user_obj->last_name,
                    'user_fullname'            => $user_obj->last_name . ', ' . $user_obj->first_name,
                    'gen_code'                 => $user_obj->gen_code, //this will be use for checking multiple logged machines in one account
                    'user_groups_descriptions' => _current_group_string(),
                    'user_groups_names'        => _current_group_string('name'),
                    'user_is_dean'             => $is_dean,
                    'user_dean_course_id'      => $dean_course_id,
                    'user_dean_course_code'    => $dean_course_code,
                ));
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('_current_group_string'))
{


        function _current_group_string($type = 'description')
        {
                $return = '';
                foreach (get_instance()->ion_auth->get_users_groups()->result() as $g)
                {
                        $return .= $g->$type . '|';
                }
                return trim($return, '|');
        }

}