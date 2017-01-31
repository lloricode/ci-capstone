<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

        function __construct()
        {
                parent::__construct();

                // load from spark
                //$this->load->spark('codeigniter-log/1.0.0');
                // load from CI library
                //if production will enable this 
                if (ENVIRONMENT === 'production')
                {

                        $this->load->library('lib_log');
                }
                $this->load->library(array('ion_auth', 'form_validation'));

                $this->load->library('session');

                //load the preffer user language (if logged)
                if ($this->ion_auth->logged_in() OR $this->ion_auth->is_admin())
                {
                        $this->load->model('Language_Model');
                        $data_return = $this->Language_Model->where('user_id', $this->session->userdata('user_id'))->get();

                        if ($data_return)
                        {
                                $this->config->set_item('language', $data_return->language_value);
                        }
                }

                $this->load->database();
                $this->load->helper(array('url', 'language'));

                $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

                $this->lang->load(array('ci_change_language', 'ci_validation', 'auth'));
        }

        public function _render_page($view, $data = null, $returnhtml = false)
        {//I think this makes more sense
                $this->viewdata = (empty($data)) ? $this->data : $data;

                $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

                if ($returnhtml)
                        return $view_html; //This will return html on 3rd argument being true
        }

        public function _get_csrf_nonce()
        {
                $this->load->helper('string');
                $key   = random_string('alnum', 8);
                $value = random_string('alnum', 20);
                $this->session->set_flashdata('csrfkey', $key);
                $this->session->set_flashdata('csrfvalue', $value);

                return array($key => $value);
        }

        public function _valid_csrf_nonce()
        {
                $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
                if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
                {
                        return TRUE;
                }
                else
                {
                        return FALSE;
                }
        }

}

class Admin_Controller extends MY_Controller
{

        function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
                {
                        redirect('auth/login', 'refresh');
                }
                $this->config->load('table');
                $this->load->helper('navigation');
        }

        /**
         * main administrator header view 
         */
        public function my_header_view()
        {
                $this->_render_page('admin/header', array(
                    'navigations'         => navigations_main(),
                    'setting_vavigations' => navigations_setting()
                ));
        }

        public function my_table_view($header, $data)
        {
                $this->load->library('table');
                $this->table->set_heading($header);
                $this->table->set_template(array(
                    'table_open' => $this->config->item('table_open_pagination'),
                ));
                return $this->table->generate($data);
        }

}

class Public_Controller extends MY_Controller
{

        function __construct()
        {
                parent::__construct();
        }

}
