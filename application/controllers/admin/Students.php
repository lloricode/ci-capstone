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
                $this->load->model(array('Student_model'));
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
        }

        /**
         * @author Jinkee Po <pojinkee1@gmail.com>
         */
        public function index()
        {

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();

                //list students
                $student_obj = $this->Student_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();


                $table_data = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {
                                $view_ = anchor(base_url('admin/students/view?student-id=' . $student->student_id), 'View');
                                $edit_ = anchor(base_url('admin/students/edit?student-id=' . $student->student_id), 'Edit');

                                array_push($table_data, array(
                                    my_htmlspecialchars($student->student_school_id),
                                    my_htmlspecialchars($student->student_firstname),
                                    my_htmlspecialchars($student->student_middlename),
                                    my_htmlspecialchars($student->student_lastname),
                                   $view_ . ' | ' . $edit_
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
                    'Options'
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
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function view()
        {

                /*
                 * check url with id
                 */
                $this->data['student'] = check_id_from_url('student_id', 'Student_model', $this->input->get('student-id'));

                $this->load->model(array('Students_subjects_model', 'Course_model'));
                $this->data['course'] = $this->Course_model->get($this->data['student']->course_id);
                $page                 = 1;
                if ($this->input->get('per_page'))
                {
                        $page = $this->input->get('per_page');
                }

                /**
                 * get the subjects of current student
                 * 
                 */
                $subjects_obj = $this->Students_subjects_model->
                                limit($this->limit, $this->limit * $page - $this->limit)->
                                with_subjects()->as_object()->get_all(array('student_id' => $this->data['student']->student_id));

                $total_all = $this->Students_subjects_model->count_rows(array('student_id' => $this->data['student']->student_id));

                $this->config->load('admin/table');
                $this->load->library(array('table', 'age'));
                $this->age->initialize($this->data['student']->student_birthdate);
                $this->table->set_template(array(
                    'table_open' => $this->config->item('table_open_invoice'),
                ));


                $this->table->set_heading(array('Code', 'Desciption', 'Unit', 'Grade'));

                if ($subjects_obj)
                {
                        foreach ($subjects_obj as $v)
                        {
                                $subject = $v->subjects;

                                $this->table->add_row($subject->subject_code, $subject->subject_description, $subject->subject_unit, $subject->grade);
                        }
                }
                else
                {
                        $this->table->add_row(array('data' => 'no data', 'colspan' => '4'));
                }

                $this->data['table_subjects'] = $this->table->generate();

                $this->data['table_subjects_pagination'] = $this->pagination->generate_link('/admin/students/view?student-id=' . $this->data['student']->student_id, $total_all / $this->limit, TRUE);

                $this->template['view']      = $this->_render_page('admin/_templates/students/view', $this->data, TRUE);
                $this->template['bootstrap'] = $this->bootstrap_for_view();
                $this->_render_admin_page('admin/students', $this->template);
        }

        /**
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com> 
         */
        public function edit()
        {
                /*
                 * check url with id
                 */
                $student_obj = check_id_from_url('student_id', 'Student_model', $this->input->get('student-id'));
        }

        /**
         * 
         * @return array
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function bootstrap_for_view()
        {
                /**
                 * for header
                 *
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
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
                        'js/matrix.js'
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

        /**
         * 
         * @return array
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
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
