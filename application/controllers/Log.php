<?php

/**
 * @author Lloric Mayuga Gracia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends Admin_Controller
{


        private $page_;
        private $limit;
        private $total_rows;

        function __construct()
        {
                parent::__construct();

                $this->load->model('Log_model');

                $this->config->load('log');

                $this->load->library(array('table', 'pagination'));
                $this->config->load('admin/table');
                $this->table->set_template(array(
                    'table_open' => $this->config->item('table_open_bordered'),
                ));

                /**
                 * pagination limit
                 */
                $this->limit      = 10;
                /**
                 * get total rows in users table (no where| all data)
                 */
                $this->total_rows = $this->Log_model->total_rows();

                /**
                 * get the page from url
                 * 
                 * if has not, default $page will is 1
                 */
                $this->page_ = get_3rd_segment_as_int();
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
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
                $logs = $this->Log_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();

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
                $this->data['logs']       = $this->table->generate();
                $this->data['controller'] = 'table';



                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('log/index', $this->total_rows / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_heading');


                $this->_render_admin_page('admin/log', $this->data);
        }

}
