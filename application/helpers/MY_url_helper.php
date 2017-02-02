<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_page_in_url'))
{

        /**
         * 
         * @return int - value from 3rd segment in url if not exist vale 1,
         *  then if not integer show error will occured
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function get_page_in_url()
        {
                $CI = & get_instance();

                if ($int_value = $CI->uri->segment(4))
                {
                        if (is_numeric($int_value))
                        {
                                return $int_value;
                        }
                        show_error('Invalid request.');
                }

                /**
                 * else return 1 as default
                 */
                return 1;
        }

}
if (!function_exists('check_id_form_url'))
{

        /**
         * if not exist 404 will occurred
         * 
         * @param string $column  model to get table name
         * @param array $model column from table on database
         * @param string $id from url | default NULL to prevent error in case user modify url
         * @return row data from table
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function check_id_from_url($column, $model, $id = NULL)
        {
                if (is_null($id))
                {
                        show_404();
                }
                /**
                 * CI instance object
                 */
                $CI = & get_instance();

                $CI->load->model($model);
                $rs = $CI->$model->get(array(
                    $column => $id
                ));


                if (!$rs)
                {
                        show_404();
                }
                return $rs->row();
        }

}


if (!function_exists('save_current_url'))
{

        /**
         * save to database all url receive 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function save_current_url($usertype = NULL)
        {
                /**
                 * Returns current CI instance object
                 */
                $CI = & get_instance();
                $CI->load->model('Url_Model');

                $agent = NULL;

                $current_ip = $CI->input->ip_address();

                $CI->load->library('user_agent');

                if ($CI->agent->is_browser())
                {
                        $agent = $CI->agent->browser() . ' - ' . $CI->agent->version();
                }
                elseif ($CI->agent->is_robot())
                {
                        $agent = $CI->agent->robot();
                }
                elseif ($CI->agent->is_mobile())
                {
                        $agent = $CI->agent->mobile();
                }
                else
                {
                        $agent = 'Unidentified User Agent';
                }


                $current_url = current_url();

                //check value
                $rs = NULL;

                if ($usertype === 'admin')
                {
                        $rs = $CI->Url_Model->get(array(
                            'url_value'    => $current_url,
                            'url_agent'    => $agent,
                            'url_platform' => $CI->agent->platform(),
                            'admin_id'     => $CI->session->userdata('admin_id'),
                            'user_id'      => '-1',
                            'url_ip'       => $current_ip,
                        ));
                }
                else if ($usertype === 'client')
                {
                        $rs = $CI->Url_Model->get(array(
                            'url_value'    => $current_url,
                            'url_agent'    => $agent,
                            'url_platform' => $CI->agent->platform(),
                            'admin_id'     => '-1',
                            'user_id'      => $CI->session->userdata('client_id'),
                            'url_ip'       => $current_ip,
                        ));
                }
                else if ($usertype === 'client' || $usertype == NULL)
                {
                        $rs = $CI->Url_Model->get(array(
                            'url_value'    => $current_url,
                            'url_agent'    => $agent,
                            'url_platform' => $CI->agent->platform(),
                            'admin_id'     => '-1',
                            'user_id'      => '-1',
                            'url_ip'       => $current_ip,
                        ));
                }


                if (!$rs)
                {
                        //insert

                        if ($usertype === 'admin')
                        {
                                $CI->Url_Model->add(array(
                                    'url_value'    => $current_url,
                                    'url_agent'    => $agent,
                                    'url_platform' => $CI->agent->platform(),
                                    'admin_id'     => $CI->session->userdata('admin_id'),
                                    'user_id'      => '-1',
                                    'url_ip'       => $current_ip,
                                ));
                        }
                        else if ($usertype === 'client')
                        {
                                $CI->Url_Model->add(array(
                                    'url_value'    => $current_url,
                                    'url_agent'    => $agent,
                                    'url_platform' => $CI->agent->platform(),
                                    'admin_id'     => '-1',
                                    'user_id'      => $CI->session->userdata('client_id'),
                                    'url_ip'       => $current_ip,
                                ));
                        }
                        else
                        {
                                $CI->Url_Model->add(array(
                                    'url_value'    => $current_url,
                                    'url_agent'    => $agent,
                                    'url_platform' => $CI->agent->platform(),
                                    'admin_id'     => '-1',
                                    'user_id'      => '-1',
                                    'url_ip'       => $current_ip,
                                ));
                        }
                }
                else
                {
                        $row   = $rs->row();
                        //update
                        $count = $row->url_count;
                        $CI->Url_Model->update(array('url_count' => ++$count), array('url_id' => $row->url_id));
                }
        }

}

