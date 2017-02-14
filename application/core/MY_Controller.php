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

                $this->migration->current();
                //load the preffer user language (if logged)
                if ($this->ion_auth->logged_in() OR $this->ion_auth->is_admin())
                {
                        $this->load->model('Language_model');
                        $data_return = $this->Language_model->where('user_id', $this->session->userdata('user_id'))->get();

                        if ($data_return)
                        {
                                $this->config->set_item('language', $data_return->language_value);
                        }
                }
        }

        /**
         * 
         * @param type $view
         * @param type $data
         * @param type $returnhtml
         * @return type
         * @author ion_auth
         */
        public function _render_page($view, $data = null, $returnhtml = false)
        {//I think this makes more sense
                $this->viewdata = (empty($data)) ? $this->data : $data;

                $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

                if ($returnhtml)
                {
                        return $view_html; //This will return html on 3rd argument being true
                }
        }

}

class CI_Capstone_Controller extends MY_Controller
{

        function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in())
                {
                        redirect(base_url('auth/login'), 'refresh');
                }
                /**
                 * check permission
                 */
                if (!in_array($this->uri->segment(1), permission_controllers()))
                {
                        show_404();
                }

                $this->breadcrumbs->unshift(1, 'Home', 'home');
        }

        /**
         * render views at one call
         * 
         * @param view $content current view page to be render
         * @param data $data data to be render also in current view 
         * @return null if content is missing
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function _render_admin_page($content, $data = NULL)
        {
                if (!$content)
                {
                        return NULL;
                }
                $data['user_info']           = $this->session->userdata('user_last_name') .
                        ', ' .
                        $this->session->userdata('user_first_name') .
                        ' [' . $this->current_gruop_string() . ']';
                $data['navigations']         = navigations_main();
                $data['setting_vavigations'] = navigations_setting();

                $this->template['header']  = $this->_render_page('admin/_templates/header', $data, TRUE);
                $this->template['content'] = $this->_render_page($content, $data, TRUE);
                $this->template['footer']  = $this->_render_page('admin/_templates/footer', $data, TRUE);

                $this->_render_page('template', $this->template);
        }

        private function current_gruop_string()
        {
                $return = '';
                foreach ($this->ion_auth->get_users_groups()->result() as $g)
                {
                        $return .= $g->name . '|';
                }
                return trim($return, '|');
        }

        /**
         * 
         * @param type $header
         * @param type $data
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function my_table_view($header, $data, $table_config)
        {
                $this->config->load('admin/table');
                $this->load->library('table');
                $this->table->set_heading($header);
                $this->table->set_template(array(
                    'table_open' => $this->config->item($table_config),
                ));
                return $this->table->generate($data);
        }

}
