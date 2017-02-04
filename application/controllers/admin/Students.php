<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends Admin_Controller {

        private $page_;
        private $limit;
        private $total_rows;

        function __construct() {
                parent::__construct();
                $this->lang->load('ci_students');
                $this->load->model('Student_model');
                $this->load->library('pagination');

                /**
                 * pagination limit
                 */
                $this->limit      = 10;
                /**
                 * get total rows in the student table
                 */
                $this->total_rows = $this->Student_model->total_rows();

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

                //list students
                $student_obj = $this->Student_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();


                $table_data = array();

                if ($student_obj) {
                        show_error('Invalid request');

                        foreach ($student_obj as $student) {

                                array_push($table_data, array(
                                    my_htmlspecialchars($student->student_firstname),
                                    my_htmlspecialchars($student->student_middlename),
                                    my_htmlspecialchars($student->student_lastname),
                                    my_htmlspecialchars($student->student_school_id),
                                    my_htmlspecialchars($student->student_gender),
                                    my_htmlspecialchars($student->student_permanent_address),
                                    my_htmlspecialchars($student->course_id),
                                    my_htmlspecialchars($student->student_year_level),
                                ));
                        }
                }


                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_student_school_id_th'),
                    lang('index_student_firstname_th'),
                    lang('index_student_middlename_th'),
                    lang('index_student_lastname_th'),
                    lang('index_student_Gender_th'),
                    lang('index_student_permanent_address_th'),
                    lang('index_student_course_id_th'),
                    lang('index_student_year_level_th')
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('admin/students/index', $this->total_rows / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_student_heading');


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
                $this->_render_admin_page('admin/students', $this->template);
        }

}
