<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_excel');
                $this->load->model('Group_model');
                $this->load->library('pagination');

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
                $this->breadcrumbs->unshift(2, 'Groups', 'groups');
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {

                // set the flash data error message if there is one
                // $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                //list the users
                $group_obj = $this->Group_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();

                /**
                 * where data array from db stored
                 */
                $table_data = array();
                /**
                 * check if has a result
                 * 
                 * sometime pagination can replace a page that has no value by crazy users :)
                 */
                if ($group_obj)
                {
                        foreach ($group_obj as $group)
                        {

                                array_push($table_data, array(
                                    my_htmlspecialchars($group->name),
                                    my_htmlspecialchars($group->description),
                                ));
                        }
                }
                /*
                 * preparing html table
                 */
                /*
                 * header
                 */
                $header = array(
                    lang('index_groups_th'),
                    lang('index_group_desc_th')
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('admin/groups/index', $this->Group_model->count_rows() / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_heading');


                /**
                 * table of users ready,
                 * so whole html table with datas passing as var table_data_users
                 */
                /**
                 * templates for group controller
                 */
                $this->template['table_data_groups'] = MY_Controller::_render('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']        = 'table';

                $this->template['bootstrap'] = $this->bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/groups', $this->template);
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
