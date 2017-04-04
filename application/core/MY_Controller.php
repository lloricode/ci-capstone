<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

        function __construct()
        {
                parent::__construct();

//                $this->load->dbutil();
//                $DB_NAME = 'ci_capstone';
//                if (!$this->dbutil->database_exists($DB_NAME))
//                {
//                        $this->dbforge->create_database($DB_NAME);
//                }

                if ($this->migration->current())
                {
                        $this->delete_all_query_cache();
                }

                /**
                 * we set here , must before check login or before calling a trigger for a name of event
                 */
                $this->ion_auth->set_hook(
                        'logged_in', 'check_log_multiple_user', $this/* $this because the class already extended */, 'check_if_multiple_logged_in_one_user', array()
                );
        }

        /**
         * 
         * @param type $view
         * @param type $data
         * @param type $returnhtml
         * @return type
         * @author ion_auth
         */
        public function render($view, $data = null, $returnhtml = false)
        {//I think this makes more sense
                //$this->viewdata = (empty($data)) ? $this->data : $data;

                $view_html = $this->load->view($view,$data, $returnhtml);

                if ($returnhtml)
                {
                        return $view_html; //This will return html on 3rd argument being true
                }
        }

        /**
         * this will call using 
         * $this->trigger_events(array(_____ , 'post_login_successful')); line 1012 :Ion_auth_model.php
         * in success login
         * 
         * ,this is set hook in constructor in auth controller
         * 
         * 
         * i put here htis method to controller, to prevent acces via url, because private is cannot in ion auth hook
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         * 
         */
        public function insert_last_login()
        {
                $this->load->library('user_agent');
                if ($this->agent->is_browser())
                {
                        $agent = $this->agent->browser() . ' ' . $this->agent->version();
                }
                elseif ($this->agent->is_robot())
                {
                        $agent = $this->agent->robot();
                }
                elseif ($this->agent->is_mobile())
                {
                        $agent = $this->agent->mobile();
                }
                else
                {
                        $agent = 'Unidentified User Agent';
                }

                $this->load->model('Users_last_login_model');
                return (bool) $this->Users_last_login_model->insert(array(
                            'user_id'    => $this->session->userdata('user_id'),
                            'ip_address' => $this->input->ip_address(),
                            'agent'      => $agent,
                            'platform'   => $this->agent->platform()
                ));
        }

        /**
         * ,this is set hook in constructor in auth controller
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function set_session_data_session()
        {
                //set the user name/last name in session
                $user_obj = $this->ion_auth->user()->row();
                $this->session->set_userdata(array(
                    'user_first_name'          => $user_obj->first_name,
                    'user_last_name'           => $user_obj->last_name,
                    'user_fullname'            => $user_obj->last_name . ', ' . $user_obj->first_name,
                    'user_current_logged_time' => $user_obj->last_login, //this will be use for checking multiple logged machines in one account
                    'user_groups_descriptions' => $this->current_group_string(),
                    'user_groups_names'        => $this->current_group_string('name'),
                ));
        }

        /**

         * @return string | all user_group of current logged user
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function current_group_string($type = 'description')
        {
                $return = '';
                foreach ($this->ion_auth->get_users_groups()->result() as $g)
                {
                        $return .= $g->$type . '|';
                }
                return trim($return, '|');
        }

        /**
         * delete all query cache by using one of model, cant statically call MY_Model so i did this 
         *       
         * using this with ion_auth update/insert/
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>  
         */
        public function delete_all_query_cache()
        {
                $this->load->model('User_model');
                $this->User_model->delete_cache();
        }

}

class CI_Capstone_Controller extends MY_Controller
{

        function __construct()
        {
                parent::__construct();
                if ( ! $this->ion_auth->logged_in())
                {
                        redirect(site_url('auth/login'), 'refresh');
                }
                /**
                 * check permission
                 */
                if ( ! in_array($this->uri->segment($this->config->item('segment_controller')), permission_controllers()))
                {
                        show_404();
                }

                if ( ! $this->Enrollment_status_model->status())
                {
                        if (in_array($this->uri->segment($this->config->item('segment_controller')), get_all_controller_with_enrollment()))
                        {
                                show_404();
                        }
                }
                $this->breadcrumbs->unshift(1, lang('home_label'), 'home');


                /**
                 * this is for /create-student-subject controller
                 * use this if navigate to another controller, it will unset session for subject offer
                 * to prevent passing session to another enrolling subjects in another students
                 */
                if ('create-student-subject' != str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller'))) &&
                        $this->session->has_userdata('curriculum_subjects__subject_offer_ids'))
                {
                        /**
                         * to modify the session name, make sure also modify in /create-student-subject controller
                         * 
                         *   $this->_session_name_  
                         */
                        $this->session->unset_userdata('curriculum_subjects__subject_offer_ids');
                }
        }

        /**
         * render views at one call
         * 
         * @param view $content current view page to be render
         * @param data $data data to be render also in current view 
         * @return null if content is missing
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function render($content, $data = NULL, $returnhtml = FALSE)
        {
                if ( ! $content)
                {
                        return NULL;
                }
                $data['user_info']   = $this->session->userdata('user_fullname') .
                        ' [' . $this->session->userdata('user_groups_descriptions') . ']';
                $data['navigations'] = navigations_main();

                $this->template['header']  = parent::render('admin/_templates/header', $data, TRUE);
                $this->template['content'] = parent::render($content, $data, TRUE);
                $this->template['footer']  = parent::render('admin/_templates/footer', $data, TRUE);

                parent::render('template', $this->template, $returnhtml);
        }

        /**
         * 
         * @param array $header header
         * @param array $table_data_rows rows
         * @param string $table_config table bootstrap
         * @param string $caption_lang caption
         * @param string $pagination | must generated html pagination | default = FALSE
         * @param bool $return_html either return html or not
         * @return string | generated html table with header/data/table-type/pagination depend on parameters
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function table_bootstrap($header, $table_data_rows, $table_config, $caption_lang, $pagination = FALSE, $return_html = FALSE)
        {
                $this->config->load('admin/table');
                $this->load->library('table');
                $this->table->set_heading($header);
                $this->table->set_template(array(
                    'table_open' => $this->config->item($table_config),
                ));
                $_data['caption_lang'] = $caption_lang;
                $_data['table_data']   = $this->table->generate($table_data_rows);
                $_data['pagination']   = $pagination;
                $generated_html_table  = parent::render('admin/_templates/table', $_data, $return_html);
                if ($return_html)
                {
                        return $generated_html_table;
                }
        }

        /**
         * 
         * @param string $_action
         * @param array $_inputs
         * @param string $_lang_header
         * @param string $_lang_button
         * @param string $_icon
         * @param array $_hidden_inputs
         * @param bool $return_html
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function form_boostrap($_action, $_inputs, $_lang_header, $_lang_button, $_icon, $_hidden_inputs = NULL, $return_html = FALSE, $_error = FALSE)
        {
                $_data['inputs']        = $_inputs;
                $_data['action']        = $_action;
                $_data['lang_header']   = $_lang_header;
                $_data['lang_button']   = $_lang_button;
                $_data['icon']          = $_icon;
                $_data['hidden_inputs'] = $_hidden_inputs;
                $_data['error']         = $_error;

                $generated_html_form = parent::render('admin/_templates/form', $_data, $return_html);
                if ($return_html)
                {
                        return $generated_html_form;
                }
        }

        /**
         * this will call using 
         * $this->trigger_events(array(_____ , 'post_update_user_successful')); line 1664 :Ion_auth_model.php
         * in success login
         * 
         * ,this is set hook in constructor in edit_user controller
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         * 
         */
        public function add_update_at_data_user_column($table, $user_id)
        {
                /**
                 * not using core My_Model, because, we needed is updated_at to be update
                 */
                /**
                 * for very specific, we use table set in ion auth config,
                 * see on set hook in edit_user controller
                 */
                return (bool) $this->db->update($table, array(
                            'updated_at' => time()
                                ), array('id' => $user_id));
        }

        /**
         * 
         * checking if one account log in another machine
         * ,this is set hook in constructor in MY_Controller
         * 
         * then will call this when trigger the name 'logged_in
         * 
         * 
         * this idea is came from https://github.com/benedmunds/CodeIgniter-Ion-Auth/issues/947
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function check_if_multiple_logged_in_one_user()
        {
                /**
                 * there is a back button, and i don't know why even logged out, 
                 * still reach this, so error occurred where get last_login,
                 *  because session not exit
                 */
                if ($this->session->userdata('identity'))#hmmm
                {
                        $last_logged_in_session = $this->session->userdata('user_current_logged_time');
                        $last_logged_in_db      = $this->ion_auth->user()->row()->last_login;

                        if ($last_logged_in_session != $last_logged_in_db)
                        {
                                $message = lang('another_logged_in_user_in_this_account');

                                /**
                                 * replace 'space' to 'undescore
                                 * because, it will appear in url
                                 */
                                $message = str_replace(' ', '_', $message);

                                redirect(site_url('auth/logout/' . $message), 'refresh');
                        }
                }
        }

}
