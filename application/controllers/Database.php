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

                $this->data['href']         = base_url('database/backup-database');
                $this->data['button_label'] = lang('db_back_up');
                $this->data['platform']     = $this->db->platform();
                $this->data['version']      = $this->db->version();
                $this->data['table']        = $this->table->generate();
                $this->data['controller']   = 'table';



                $this->my_header_view();
                $this->_render_page('admin/button_view', $this->data);
                $this->_render_page('admin/database', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

        public function backup_database()
        {
                $this->load->helper('backup_database');
                backup_database();
        }

}
