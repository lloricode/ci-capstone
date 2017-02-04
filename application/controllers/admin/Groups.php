<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends Admin_Controller {

        private $page_;
        private $limit;
        private $total_rows;

        function __construct() {
                parent::__construct();
                $this->lang->load('ci_excel');
                $this->load->model('Group_model');
                $this->load->library('pagination');

                /**
                 * pagination limit
                 */
                $this->limit      = 10;
                /**
                 * get total rows in users table (no where| all data)
                 */
                $this->total_rows = $this->Group_model->total_rows();

                /**
                 * get the page from url
                 * 
                 * if has not, default $page will is 1
                 */
                $this->page_ = get_page_in_url();
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index() {

                // set the flash data error message if there is one
                // $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                //list the users
                $group_obj = $this->Group_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();

                /**
                 * check if has a result
                 * 
                 * sometime pagination can replace a page that has no value by crazy users :)
                 */
                if (!$group_obj) {
                        show_error('Invalid request');
                }



                /**
                 * where data array from db stored
                 */
                $table_data = array();

                foreach ($group_obj as $group) {

                        array_push($table_data, array(
                            my_htmlspecialchars($group->name),
                            my_htmlspecialchars($group->description),
                        ));
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
                $this->data['pagination'] = $this->pagination->generate_link('admin/groups/index', $this->total_rows / $this->limit);

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
                $this->template['table_data_groups'] = $this->_render_page('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']        = 'table';


                /**
                 * rendering users view
                 */
                $this->_render_admin_page('admin/groups', $this->template);
        }

}
