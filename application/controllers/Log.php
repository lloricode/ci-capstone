<?php

/**
 * @author Lloric Mayuga Gracia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                $this->load->model('Log_Model');

                $this->config->load('log');

                $this->load->library('table');
                $this->config->load('admin/table');
                $this->table->set_template(array(
                    'table_open' => $this->config->item('table_open_pagination'),
                ));
        }

        public function index()
        {

                //store colum nnames of logs table
                $key = array();
                foreach ($this->db->field_data($this->config->item('log_table_name')) as $field)
                {
                        $key[] = $field->name;
                }
                //set ass header table
                $this->table->set_heading($key);

                //get data from database table logs
                $logs = $this->Log_Model->get_all();

                //if has vale
                if ($logs)
                {
                        foreach ($logs as $k => $v)
                        {
                                $tmp = array();
                                //loop every clomn names
                                foreach ($key as $kk => $vv)
                                {
                                        $tmp[$kk] = $v->$vv;
                                }
                                $this->table->add_row($tmp);
                        }
                }
                $data['logs']       = $this->table->generate();
                $data['controller'] = 'table';
                $this->_render_admin_page('admin/log', $data);
        }

}
