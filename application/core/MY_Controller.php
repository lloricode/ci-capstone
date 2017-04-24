<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

        function __construct()
        {
                parent::__construct();


                if ($this->migration->current())
                {
                        $this->delete_all_query_cache();
                }

                /**
                 * there is a back button, 
                 * still reach this, so ignore this
                 */
//                if ($this->session->has_userdata('user_id'))
//                {
//                        $this->ion_auth->set_hook(
//                                'post_login_remembered_user_successful', 'just_notify_user_remember_event', $this/* $this because the class already extended */, 'just_notify_user_remember', array()
//                        );
//                }
                if ($this->session->has_userdata('user_id'))
                {
                        $this->ion_auth->set_hook(
                         /*       'pre_set_session'*/ 'post_login_remembered_user', 'set_session_data_session_event', $this/* $this because the class already extended */, 'set_session_data_session', array()
                        );
                }
        }

        public function set_session_data_session()
        {
                // show_error('aaaa');
                $is_dean          = FALSE;
                $dean_course_id   = NULL;
                $dean_course_code = NULL;
                if ($this->ion_auth->in_group($this->config->item('user_group_dean')))
                {
                        $is_dean = TRUE;
                        $this->load->model('Dean_course_model');
                        $obj     = $this->Dean_course_model->where(array(
                                    'user_id' => $this->ion_auth->get_user_id()
                                ))->get();
                        if ($obj)
                        {
                                $this->load->model('Course_model');
                                $dean_course_id   = $obj->course_id;
                                $dean_course_code = $this->Course_model->get($obj->course_id)->course_code;
                        }
                }
                //set the user name/last name in session
                $user_obj = $this->ion_auth->user()->row();
                $this->session->set_userdata(array(
                    'user_first_name'          => $user_obj->first_name,
                    'user_last_name'           => $user_obj->last_name,
                    'user_fullname'            => $user_obj->last_name . ', ' . $user_obj->first_name,
                    'gen_code'                 => $user_obj->gen_code, //this will be use for checking multiple logged machines in one account
                    'user_groups_descriptions' => $this->_current_group_string(),
                    'user_groups_names'        => $this->_current_group_string('name'),
                    'user_is_dean'             => $is_dean,
                    'user_dean_course_id'      => $dean_course_id,
                    'user_dean_course_code'    => $dean_course_code,
                ));
        }

        private function _current_group_string($type = 'description')
        {
                $return = '';
                foreach (get_instance()->ion_auth->get_users_groups()->result() as $g)
                {
                        $return .= $g->$type . '|';
                }
                return trim($return, '|');
        }

//        public function just_notify_user_remember()
//        {
//                $this->load->helper('session');
//                set_session_data_session();
//                /**
//                 * just a temporary
//                 */
//                $this->session->set_flashdata('message', bootstrap_success('User Exntended Login!!'));
//        }

        /**
         * 
         * @param type $view
         * @param type $data
         * @param type $returnhtml
         * @return type
         * @author ion_auth
         */
        public function render($view, $data = null, $returnhtml = false)
        {
                $view_html = $this->load->view($view, $data, $returnhtml);

                if ($returnhtml)
                {
                        return $view_html; //This will return html on 3rd argument being true
                }
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
                $data['search_form'] = parent::render('admin/_templates/search', $data, TRUE);
                $data['navigations'] = navigations_main();

                $template['header']  = parent::render('admin/_templates/header', $data, TRUE);
                $template['content'] = parent::render($content, $data, TRUE);
                $template['footer']  = parent::render('admin/_templates/footer', $data, TRUE);

                parent::render('template', $template, $returnhtml);
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
        public function table_bootstrap($header, $table_data_rows, $table_config_or_template, $header_lang, $pagination = FALSE, $return_html = FALSE, $caption = NULL, $bootsrap = TRUE)
        {

                $this->config->load('admin/table');
                $this->load->library('table');

                $temp_template = NULL;
                if (is_array($table_config_or_template))
                {
                        /**
                         * if array so its template
                         */
                        $temp_template = $table_config_or_template;
                }
                else
                {
                        /**
                         * just table open
                         */
                        $temp_template['table_open'] = $this->config->item($table_config_or_template);
                }
                $this->table->set_template($temp_template);

                $this->table->set_heading($header);
                $this->table->set_caption($caption);

                $_data['header_lang']      = $header_lang;
                $_data['table_data']       = $this->table->generate($table_data_rows);
                $_data['pagination']       = $pagination;
                $_data['bootstrap_output'] = $bootsrap;
                $generated_html_table      = parent::render('admin/_templates/table', $_data, $return_html);
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

}
