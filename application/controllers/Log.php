<?php

/**
 * @author Lloric Mayuga Gracia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

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
                $this->limit = 10;

                /**
                 * get the page from url
                 * 
                 * if has not, default $page will is 1
                 */
                $this->page_ = get_page_in_url();
                $this->breadcrumbs->unshift(2, 'Settings', '#');
                $this->breadcrumbs->unshift(3, 'Error Logs', 'log');
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
                $this->data['pagination'] = $this->pagination->generate_link('log/index', $this->Log_model->count_rows() / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption']   = lang('index_heading');
                $this->data['bootstrap'] = $this->bootstrap();

                $this->_render_admin_page('admin/log', $this->data);
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
