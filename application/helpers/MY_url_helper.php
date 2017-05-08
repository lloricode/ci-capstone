<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_page_in_url'))
{

        /**
         * 
         * @return int - value from $CI->config->item('segment_pagination')'th segment OR assigned index in url if not exist value 1,
         *  then if not integer show error will occurred
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function get_page_in_url($index = NULL)
        {
                $CI = & get_instance();

                $page_number = NULL;

                if ( ! is_null($index))
                {
                        $page_number = $CI->input->get($index, TRUE);
                        if (is_null($page_number))
                        {
                                $page_number = 1;
                        }
                }
                else
                {
                        $page_number = $CI->uri->segment($CI->config->item('segment_pagination'), 1); //if not exits, return is 1
                }

                if ( ! is_numeric($page_number) OR $page_number < 1 OR is_null($page_number))
                {
                        show_error('Invalid request.');
                }

                return $page_number;
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('check_id_form_url'))
{

        /**
         * if not exist error will occurred.
         * 
         * @param string $column  model to get table name
         * @param array $model column from table on database
         * @param string $id_name from url 
         * @param string|array $relation relation table | default == FALSE
         * @return object data from model
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function check_id_from_url($column, $model, $id_name, $relation = FALSE)
        {
                /**
                 * CI instance object
                 */
                $CI = & get_instance();

                /**
                 * check if id is set
                 */
                if ( ! $CI->input->get($id_name))
                {
                        $bgtr = '';
                        if (ENVIRONMENT === 'development')
                        {
                                $bt     = debug_backtrace();
                                $caller = array_shift($bt);
                                $bgtr   = br(2) . $caller['file'] . ': ' . $caller['line'];
                        }
                        show_error('id ' . bold($id_name) . ' required.' . $bgtr);
                }

                $id = $CI->input->get($id_name);

                /**
                 * load model dynamically
                 */
                $CI->load->model($model);

                /**
                 * prepare model
                 */
                $loaded_model = $CI->$model;

                /**
                 * relation
                 */
                //additionnal cache name
                $cache_name = '';
                if ($relation)
                {
                        if ( ! is_array($relation))
                        {
                                /**
                                 * convert to array if not
                                 */
                                $relation = array($relation);
                        }

                        /**
                         * add multiple relation
                         */
                        foreach ($relation as $rel)
                        {
                                /**
                                 * add relation if exist
                                 */
                                $with       = 'with_' . $rel;
                                $loaded_model->$with();
                                $cache_name .= '_' . $with; //sometimes this will not unique, so better include this.
                        }
                }

                /**
                 * get the data
                 */
                $obj = $loaded_model->
                        //just to make sure to create unique cache name
                        set_cache('check_id_from_url' . $cache_name . '_$column' . $column . '_$model' . $model . '_$id_name' . $id_name . '_id' . $id)->
                        get(array(
                    $column => $id
                ));
                /**
                 * no data so no object found
                 */
                if ( ! $obj)
                {
                        show_error('No result found in given id_name ' . bold($id_name) . '.');
                }
                return $obj;
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('uri_all_segments'))
{

        /**
         * 
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function uri_all_segments()
        {
                $__get = '';
                if ($_get_ = get_instance()->input->get())
                {
                        $__get .= '?';
                        foreach ($_get_ as $k => $v)
                        {
                                $__get .= $k . '=' . $v . '&';
                        }
                        $__get = trim($__get, '&');
                }
                return $__get;
        }

}

//
//if (!function_exists('save_current_url'))
//{
//
//        /**
//         * save to database all url receive 
//         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
//         */
//        function save_current_url($usertype = NULL)
//        {
//                /**
//                 * Returns current CI instance object
//                 */
//                $CI = & get_instance();
//                $CI->load->model('Url_Model');
//
//                $agent = NULL;
//
//                $current_ip = $CI->input->ip_address();
//
//                $CI->load->library('user_agent');
//
//                if ($CI->agent->is_browser())
//                {
//                        $agent = $CI->agent->browser() . ' - ' . $CI->agent->version();
//                }
//                elseif ($CI->agent->is_robot())
//                {
//                        $agent = $CI->agent->robot();
//                }
//                elseif ($CI->agent->is_mobile())
//                {
//                        $agent = $CI->agent->mobile();
//                }
//                else
//                {
//                        $agent = 'Unidentified User Agent';
//                }
//
//
//                $current_url = current_url();
//
//                //check value
//                $rs = NULL;
//
//                if ($usertype === 'admin')
//                {
//                        $rs = $CI->Url_Model->get(array(
//                            'url_value'    => $current_url,
//                            'url_agent'    => $agent,
//                            'url_platform' => $CI->agent->platform(),
//                            'admin_id'     => $CI->session->userdata('admin_id'),
//                            'user_id'      => '-1',
//                            'url_ip'       => $current_ip,
//                        ));
//                }
//                else if ($usertype === 'client')
//                {
//                        $rs = $CI->Url_Model->get(array(
//                            'url_value'    => $current_url,
//                            'url_agent'    => $agent,
//                            'url_platform' => $CI->agent->platform(),
//                            'admin_id'     => '-1',
//                            'user_id'      => $CI->session->userdata('client_id'),
//                            'url_ip'       => $current_ip,
//                        ));
//                }
//                else if ($usertype === 'client' OR $usertype == NULL)
//                {
//                        $rs = $CI->Url_Model->get(array(
//                            'url_value'    => $current_url,
//                            'url_agent'    => $agent,
//                            'url_platform' => $CI->agent->platform(),
//                            'admin_id'     => '-1',
//                            'user_id'      => '-1',
//                            'url_ip'       => $current_ip,
//                        ));
//                }
//
//
//                if (!$rs)
//                {
//                        //insert
//
//                        if ($usertype === 'admin')
//                        {
//                                $CI->Url_Model->add(array(
//                                    'url_value'    => $current_url,
//                                    'url_agent'    => $agent,
//                                    'url_platform' => $CI->agent->platform(),
//                                    'admin_id'     => $CI->session->userdata('admin_id'),
//                                    'user_id'      => '-1',
//                                    'url_ip'       => $current_ip,
//                                ));
//                        }
//                        else if ($usertype === 'client')
//                        {
//                                $CI->Url_Model->add(array(
//                                    'url_value'    => $current_url,
//                                    'url_agent'    => $agent,
//                                    'url_platform' => $CI->agent->platform(),
//                                    'admin_id'     => '-1',
//                                    'user_id'      => $CI->session->userdata('client_id'),
//                                    'url_ip'       => $current_ip,
//                                ));
//                        }
//                        else
//                        {
//                                $CI->Url_Model->add(array(
//                                    'url_value'    => $current_url,
//                                    'url_agent'    => $agent,
//                                    'url_platform' => $CI->agent->platform(),
//                                    'admin_id'     => '-1',
//                                    'user_id'      => '-1',
//                                    'url_ip'       => $current_ip,
//                                ));
//                        }
//                }
//                else
//                {
//                        $row   = $rs->row();
//                        //update
//                        $count = $row->url_count;
//                        $CI->Url_Model->update(array('url_count' => ++$count), array('url_id' => $row->url_id));
//                }
//        }
//
//}
//
