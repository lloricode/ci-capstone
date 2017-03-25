<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Student_model'));
                $this->load->library(array('pagination'));
                $this->load->helper('number');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
                $this->breadcrumbs->unshift(2, lang('index_student_heading'), 'students');
        }

        public function index()
        {

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();

                $where_enrolment = array(
                    'fields' => 'enrollment_status,enrollment_year_level',
                    'with'   => array(
                        'relation' => 'course',
                        'fields'   => 'course_code'
                    )
                );

                if ($this->input->get('course-id'))
                {
                        /**
                         * just to make sure course id is exist
                         */
                        $course_obj = check_id_from_url('course_id', 'Course_model', 'course-id');

                        $where_course          = array();
                        $where_course['where'] = array(
                            'course_id' => $course_obj->course_id
                        );
                        $where_enrolment       = array_merge($where_enrolment, $where_course);
                }

                //list students
                $student_obj = $this->Student_model->
                        fields(array(
                            'student_school_id',
                            'student_lastname',
                            'student_firstname',
                            'student_middlename',
                            'student_image'
                        ))->
                        with_enrollment($where_enrolment)->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('updated_at', 'DESC')->
                        order_by('created_at', 'DESC')->
                        set_cache('students_page_' . $this->page_)->
                        get_all();


                $table_data = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {
                                if ( ! isset($student->enrollment->course->course_code))
                                {
                                        // i mead an issue for this
                                        //https://github.com/avenirer/CodeIgniter-MY_Model/issues/231
                                        //this is temporary,(if fixed will refactor)
                                        continue;
                                }
                                $view_ = anchor(site_url('students/view?student-id=' . $student->student_id), '<span class="btn btn-warning btn-mini">View</span>');
                                $edit_ = anchor(site_url('edit-student?student-id=' . $student->student_id), '<span class="btn btn-primary btn-mini">Edit</span>');

                                array_push($table_data, array(
                                    $this->_images_for_table($student),
                                    my_htmlspecialchars($student->student_school_id),
                                    my_htmlspecialchars($student->student_lastname),
                                    my_htmlspecialchars($student->student_firstname),
                                    my_htmlspecialchars($student->student_middlename),
                                    my_htmlspecialchars($student->enrollment->course->course_code),
                                    my_htmlspecialchars(number_place($student->enrollment->enrollment_year_level) . ' Year'),
                                    my_htmlspecialchars(($student->enrollment->enrollment_status) ? 'yes' : 'no'),
                                    $view_ . ' | ' . $edit_
                                ));
                        }
                }

                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_student_image_th'),
                    lang('index_student_school_id_th'),
                    lang('index_student_lastname_th'),
                    lang('index_student_firstname_th'),
                    lang('index_student_middlename_th'),
                    'course',
                    'level',
                    'enrolled',
                    'options'
                );

                $pagination = $this->pagination->generate_bootstrap_link('students/index', $this->Student_model->count_rows() / $this->limit);

                $this->template['table_students'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_student_heading', $pagination, TRUE);
                $this->template['message']        = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']      = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/students', $this->template);
        }

        private function _images_for_table($student)
        {
                $image_file = NULL;
                if ($student->student_image)
                {
                        list($filename, $extension) = explode('.', $student->student_image);
                        $image_file = $this->Student_model->image_resize($student->student_image)->table;
                }
                return '<div class="user-thumb">' . img(array(
                            'src'   => $image_file,
                            'alt'   => 'no image',
                            'title' => $student->student_school_id . ' - ' . $student->student_lastname
                        )) . '</div>';
        }

        private function _image_for_view_single_data()
        {
                return base_url($this->Student_model->image_resize()->profile);
        }

        /**
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function view()
        {
                $this->load->helper('time');
                /*
                 * check url with id,tehn get studewnt row
                 */
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, 'View Student [ ' . $this->student->school_id . ' ]', 'students/view?student-id=' . $this->student->id);
                /**
                 * setting up page for pagination
                 */
                $page = 1;
                if ($this->input->get('per_page'))
                {
                        $page = $this->input->get('per_page');
                }


                /**
                 * config for table, getting bootstrap header table
                 */
                $this->config->load('admin/table');
                /**
                 * loading table library
                 * then setting up html table configuration
                 */
                $this->load->library('table');
                $this->table->set_template(array(
                    'table_open' => $this->config->item('table_open_invoice'),
                ));
                $this->table->set_heading(array('Code', 'Desciption', 'Start', 'End', 'Days', 'Room', 'Faculty'));



                $student_subjects_obj = $this->student->subject_offers($this->limit, $this->limit * $page - $this->limit);
                if ($student_subjects_obj)
                {
                        /**
                         * distribute data to html table rows
                         */
                        foreach ($student_subjects_obj as $subject)
                        {
                                $this->table->add_row(
                                        $subject->subject_code, $subject->subject_description, convert_24_to_12hrs($subject->start), convert_24_to_12hrs($subject->end), $subject->days, $subject->room_number . ' - ' . $subject->room_description, $subject->faculty
                                );
                        }
                }
                else
                {
                        /**
                         * no data so, i colspan the row in 4 with data "no data"
                         */
                        $this->table->add_row(array('data' => 'no data', 'colspan' => '7'));
                }

                /**
                 * generating html table result
                 */
                $this->data['table_subjects'] = $this->table->generate();

                /**
                 * generating html pagination
                 */
                $this->data['table_subjects_pagination'] = $this->pagination->generate_bootstrap_link('students/view?student-id=' . $this->student->id, $this->student->subject_total() / $this->limit, TRUE);
                $this->data['image_src']                 = $this->_image_for_view_single_data();
                /**
                 * here we go!
                 * rendering page for view
                 */
                $this->template['view']                  = MY_Controller::_render('admin/_templates/students/view', $this->data, TRUE);
                $this->template['bootstrap']             = $this->_bootstrap_for_view();
                $this->_render('admin/students', $this->template);
        }

        /**
         * 
         * @return array
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap_for_view()
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
        private function _bootstrap()
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
