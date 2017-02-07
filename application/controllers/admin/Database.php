<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->dbutil();
                $this->lang->load('ci_db');
                $this->config->load('admin/table');
        }

        public function index()
        {


                $this->load->library('table');
                $this->table->set_template(array(
                    'table_open' => $this->config->item('table_open_bordered'),
                ));
                $this->table->set_heading('Name', 'Type', 'max_length', 'primary_key');

                foreach ($this->db->list_tables() as $db)
                {

                        $this->table->add_row(array(array('data' => '<h4>' . $db . '</h4>', 'colspan' => '4')));
                        foreach ($this->db->field_data($db) as $field)
                        {
                                $this->table->add_row($field->name, $field->type, $field->max_length, ($field->primary_key) ? 'YES' : 'NO');
                        }
                }

                $this->template['platform']   = $this->db->platform();
                $this->template['version']    = $this->db->version();
                $this->template['table']      = $this->table->generate();
                $this->template['controller'] = 'table';


                $this->template['backup_button'] = $this->_render_page('admin/_templates/button_view', array(
                    'href'         => 'admin/database/backup-database',
                    'button_label' => lang('db_back_up'),
                        ), TRUE);
                $this->template['bootstrap']     = $this->bootstrap();
                $this->_render_admin_page('admin/database', $this->template);
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function backup_database()
        {
                $this->load->helper('backup_database');
                backup_database('ci_capstone');
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function bootstrap()
        {
                /**
                 * for header
                 * 
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/jquery.dataTables.min.js',
                        'js/matrix.js',
                        'js/matrix.tables.js',
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
