<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends Admin_Controller {

        private $page_;
        private $limit;
        private $total_rows;

        function __construct() {
                parent::__construct();
                $this->lang->load('ci_courses');
                $this->load->model('Course_model');
                $this->load->library('pagination');

                /**
                 * pagination limit
                 */
                $this->limit      = 10;
                /**
                 * get total rows in users table
                 */
                $this->total_rows = $this->Course_model->total_rows();

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
        }

        /**
         * @author Jinkee Po <pojinkee1@gmail.com>
         */
        public function index() {

                //list the Courses
                $course_obj = $this->Course_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();

                /**
                 * check if has a result
                 * 
                 */
                if (!$course_obj) {
                        show_error('Invalid request');
                }



                /**
                 * where data array from db stored
                 */
                $table_data = array();

                foreach ($course_obj as $course) {

                        array_push($table_data, array(
                            my_htmlspecialchars($course->course_name),
                            my_htmlspecialchars($course->course_description),
                        ));
                }



                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_course_name_th'),
                    lang('index_course_desc_th')
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('admin/courses/index', $this->total_rows / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_course_heading');


                /**
                 * table of users ready,
                 * 
                 */
                /**
                 * templates for group controller
                 */
                $this->template['table_data_groups'] = $this->_render_page('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']        = 'table';


                /**
                 * rendering users view
                 */
                $this->_render_admin_page('admin/courses', $this->template);
        }

}
