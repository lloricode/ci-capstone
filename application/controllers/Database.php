<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->dbutil();
                $this->lang->load('ci_db');
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
                                $this->table->add_row($field->name, $field->type, $field->max_length, $field->primary_key);
                        }
                }

                $this->template['platform']   = $this->db->platform();
                $this->template['version']    = $this->db->version();
                $this->template['table']      = $this->table->generate();
                $this->template['controller'] = 'table';


                $this->template['backup_button'] = $this->_render_page('admin/_templates/button_view', array(
                    'href'         => 'database/backup-database',
                    'button_label' => lang('db_back_up'),
                        ), TRUE);

                $this->_render_admin_page('admin/database', $this->template);
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function backup_database()
        {
                $this->load->helper('backup_database');
                backup_database();
        }

}
