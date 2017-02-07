<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends Admin_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_students');
                $this->load->model(array('Student_model', 'Course_model'));
                $this->load->library('pagination');

                /**
                 * pagination limit
                 */
                $this->limit = 10;

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
        }

        /**
         * @author Jinkee Po <pojinkee1@gmail.com>
         */
        public function index()
        {

                //list students
                $student_obj = $this->Student_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();


                $table_data = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {

                                array_push($table_data, array(
                                    my_htmlspecialchars($student->student_school_id),
                                    my_htmlspecialchars($student->student_firstname),
                                    my_htmlspecialchars($student->student_middlename),
                                    my_htmlspecialchars($student->student_lastname),
                                    my_htmlspecialchars($student->student_gender),
                                    my_htmlspecialchars($student->student_permanent_address),
                                    my_htmlspecialchars($this->Course_model->get($student->course_id)->course_name),
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
                    lang('index_student_course_th'),
                    lang('index_student_year_level_th')
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('admin/students/index', $this->Student_model->count_rows() / $this->limit);

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

                $this->template['bootstrap'] = $this->bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render_admin_page('admin/students', $this->template);
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
