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
                $this->page_ = 1;
                if ($this->input->get('per_page'))
                {
                        $this->page_ = $this->input->get('per_page');
                }

                $student_result = $this->Student_model->all($this->limit, $this->limit * $this->page_ - $this->limit, $this->input->get('course-id'));

                $student_obj                 = $student_result->result;
                $result_count_for_pagination = $student_result->count;

                $table_data = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {
                                $view_ = anchor(site_url('students/view?student-id=' . $student->student_id), '<span class="btn btn-warning btn-mini">View</span>');
                                $edit_ = anchor(site_url('edit-student?student-id=' . $student->student_id), '<span class="btn btn-primary btn-mini">Edit</span>');

                                array_push($table_data, array(
                                    $this->_images_for_table($student),
                                    my_htmlspecialchars($student->student_school_id),
                                    my_htmlspecialchars($student->student_lastname),
                                    my_htmlspecialchars($student->student_firstname),
                                    my_htmlspecialchars($student->student_middlename),
                                    my_htmlspecialchars($student->course_code),
                                    my_htmlspecialchars(number_place($student->enrollment_year_level) . ' Year'),
                                    my_htmlspecialchars(($student->enrollment_status) ? 'yes' : 'no'),
                                    $view_ . ' | ' . $edit_
                                ));
                        }
                }

                /*
                 * Table headers
                 */
                $header           = array(
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
                $pagination_index = 'students';
                if ($this->input->get('course-id'))
                {
                        $pagination_index = 'students/?course-id=' . $this->input->get('course-id');
                }
                $pagination = $this->pagination->generate_bootstrap_link($pagination_index, $result_count_for_pagination / $this->limit, TRUE);

                $this->template['table_students'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_student_heading', $pagination, TRUE);
                $this->template['message']        = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']      = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/students', $this->template);
        }

        private function _images_for_table($student)
        {
                $image_file = NULL;
                if ($student->student_image)
                {
                        list($filename, $extension) = explode('.', $student->student_image);
                        $image_file = $this->Student_model->image_resize($student->student_image)->table;
                }
                return '<div class = "user-thumb">' . img(array(
                            'src'   => $image_file,
                            'alt'   => 'no image',
                            'title' => $student->student_school_id . ' - ' . $student->student_lastname
                        )) . '</div>';
        }

        private function _image_for_view_single_data()
        {
                return base_url($this->Student_model->image_resize()->profile);
        }

        public function set_enroll()
        {
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->student->set_enroll();
                redirect('students/view?student-id=' . $this->student->id, 'refresh');
        }

        public function print_data()
        {
                if ($action = (string) $this->input->get('action'))
                {
                        $id = check_id_from_url('student_id', 'Student_model', 'student-id')->student_id;
                        $this->Student_model->set_informations($id);

                        if ($action === 'prev')
                        {
                                $this->load->helper('form_helper');
                                $data['print_link'] = anchor(site_url('students/print_data?action=print&student-id=' . $this->student->id), lang('print_label'));
                                $data['subjecs']      = $this->view(TRUE);
                                MY_Controller::render('admin/_templates/students/print', $data);
                        }
                        elseif ($action === 'print')
                        {
                                $this->load->library('pdf');
                                $data['subjecs'] = $this->view(TRUE);
                                $this->pdf->print_now(MY_Controller::render('admin/_templates/students/print', $data, TRUE));
                        }
                }
        }

        /**
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function view($return_html = FALSE)//parameter use for printing
        {
                $this->load->helper('time');
                /*
                 * check url with id,tehn get studewnt row
                 */
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, 'View Student [' . $this->student->school_id . ']', 'students/view?student-id=' . $this->student->id);
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
                $this->table->set_heading(array(
                    // 'id',
                    lang('student_year_th'),
                    lang('student_semester_th'),
                    lang('student_instructor_th'),
                    lang('student_subject_th'), /* lang in students_lang */
                    lang('student_unit_th'),
                    lang('student_day1_th'),
                    lang('student_start_th'),
                    lang('student_end_th'),
                    lang('student_room_th'),
                    lang('student_day2_th'),
                    lang('student_start_th'),
                    lang('student_end_th'),
                    lang('student_room_th'),
                    lang('student_status_th')
                ));



                $student_subjects_obj = $this->student->subject_offers($this->limit, $this->limit * $page - $this->limit);
                if ($student_subjects_obj)
                {
                        /**
                         * distribute data to html table rows
                         */
                        foreach ($student_subjects_obj as $subject)
                        {
                                $this->table->add_row(
                                        //'id',
                                        $subject->year, $subject->semester, $subject->faculty, $subject->subject, $subject->unit, $subject->day1, $subject->start1, $subject->end1, $subject->room1, $subject->day2, $subject->start2, $subject->end2, $subject->room2, $subject->status);
                        }
                }
                else
                {
                        /**
                         * no data so, i colspan the row in 4 with data "no data"
                         */
                        $this->table->add_row(array('data' => 'no data', 'colspan' => '7'));
                }
                if ($return_html)
                {
                        /**
                         * use for printing
                         */
                        return $this->table->generate();
                }
                /**
                 * generating html table result
                 */
                $this->data['table_subjects'] = $this->table->generate();

                /**
                 * generating html pagination
                 */
//                $this->data['table_subjects_pagination'] = $this->pagination->generate_bootstrap_link('students/view?student-id = ' . $this->student->id, $this->student->subject_total() / $this->limit, TRUE);
                $this->data['image_src']     = $this->_image_for_view_single_data();
                /**
                 * here we go!
                 * rendering page for view
                 */
                $this->template['view']      = MY_Controller::render('admin/_templates/students/view', $this->data, TRUE);
                $this->template['bootstrap'] = $this->_bootstrap_for_view();
                $this->render('admin/students', $this->template);
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
                    'js'  => array(),
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
