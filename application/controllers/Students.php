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
                $this->load->helper(array('number', 'text'));
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

                $student_result = $this->Student_model->all($this->limit, $this->limit * $this->page_ - $this->limit, $this->input->get('course-id'), $this->input->get('search'));

                $student_obj                 = $student_result->result;
                $result_count_for_pagination = $student_result->count;

                $table_data = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {
                                $view_ = table_row_button_link('students/view?student-id=' . $student->student_id, 'View');
                                $edit_ = '';
                                if (in_array('edit-student', permission_controllers()))
                                {
                                        $edit_ = table_row_button_link('edit-student?student-id=' . $student->student_id, 'Edit');
                                }
                                $tmp = array(
                                    $this->_images_for_table($student),
                                    $this->_highlight_phrase_if_search(($student->student_school_id == '') ? '--' : $student->student_school_id),
                                    $this->_highlight_phrase_if_search($student->student_lastname),
                                    $this->_highlight_phrase_if_search($student->student_firstname),
                                    $this->_highlight_phrase_if_search($student->student_middlename),
                                    my_htmlspecialchars($student->course_code),
                                    my_htmlspecialchars(number_place($student->enrollment_year_level) . ' Year'),
                                    my_htmlspecialchars(($student->enrollment_status) ? 'yes' : 'no'),
                                    $view_ . $edit_
                                );
                                if ($this->ion_auth->is_admin())
                                {
                                        $tmp[] = $this->User_model->modidy(NULL, 'created', $student->created_user_id, $student->created_at);
                                        $tmp[] = $this->User_model->modidy(NULL, 'updated', $student->updated_user_id, $student->updated_at);
                                }
                                $table_data[] = $tmp;
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
                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }
                $pagination_index = 'students';
                if ($this->input->get('course-id'))
                {
                        $pagination_index                .= '?course-id=' . $this->input->get('course-id');
                        $course_code                     = check_id_from_url('course_id', 'Course_model', 'course-id')->course_code;
                        $template['search_result_label'] = paragraph(sprintf(lang('search_result_course_label'/* ci_students_lang */), strong($result_count_for_pagination), strong($course_code)));
                }
                if ($key = $this->input->get('search'))
                {
                        if ( ! preg_match('![?]!', $pagination_index))
                        {
                                $pagination_index .= '?';
                        }
                        $pagination_index .= 'search=' . $key;

                        $template['search_result_label'] = paragraph(sprintf(lang('search_result_label'/* ci_students_lang */), strong($result_count_for_pagination), strong($key)));
                }
                $pagination = $this->pagination->generate_bootstrap_link($pagination_index, $result_count_for_pagination / $this->limit, TRUE);

                $template['table_students'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_student_heading', $pagination, TRUE);
                $template['message']        = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']      = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/students', $template);
        }

        private function _highlight_phrase_if_search($data)
        {
                if ($key = $this->input->get('search'))
                {
                        return highlight_phrase($data, $key);
                }
                return $data;
        }

        private function _images_for_table($student)
        {
                $image_file = NULL;
                if ($student->student_image)
                {
                        list($filename, $extension) = explode('.', $student->student_image);
                        $image_file = $this->Student_model->image_resize($student->student_image)->table;
                }
                else
                {
                        $image_file = $this->config->item('default_student_image_in_table');
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

        public function set_enroll()
        {
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->student->set_enroll();
                redirect('students/view?student-id=' . $this->student->id, 'refresh');
        }

        public function print_data()
        {
                $this->load->model('Report_info_model');
                $report_obj = $this->Report_info_model->get();
                if ($action     = (string) $this->input->get('action'))
                {
                        $id                  = check_id_from_url('student_id', 'Student_model', 'student-id')->student_id;
                        $this->Student_model->set_informations($id);
                        $data['subjecs']     = $this->view(TRUE);
                        $data['report_info'] = $report_obj;

                        if ($action === 'prev')
                        {
                                $data['print_link'] = anchor('students/print_data?action=print&student-id=' . $this->student->id, lang('print_label'));
                                MY_Controller::render('admin/_templates/students/print', $data);
                        }
                        elseif ($action === 'print')
                        {
                                $this->load->library('pdf');
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
                $this->breadcrumbs->unshift(3, 'View Student [' . $this->student->school_id(TRUE) . ']', 'students/view?student-id=' . $this->student->id);
                /**
                 * setting up page for pagination
                 */
//                $page = 1;
//                if ($this->input->get('per_page'))
//                {
//                        $page = $this->input->get('per_page');
//                }


                /**
                 * config for table, getting bootstrap header table
                 */
                $this->config->load('admin/table');
                /**
                 * loading table library
                 * then setting up html table configuration
                 */
                $this->load->library('table');
                $table_open         = NULL;
                $heading_cell_start = NULL; //do nothinng
                $caption            = NULL;
                if ($return_html)
                {
                        $table_open         = '<table border="1">';
                        $heading_cell_start = '<td>'; //replace <th> to <td>
                        $caption            = 'Subjects';
                }
                else
                {
                        $caption    = 'Subjects';
                        $table_open = $this->config->item('table_open_invoice');
                }
                $this->table->set_caption($caption);
                $this->table->set_template(array(
                    'table_open'         => $table_open,
                    'heading_cell_start' => $heading_cell_start
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


                //parameter is for remove button link in faculty
                $student_subjects_obj = $this->student->subject_offers($return_html/* $this->limit, $this->limit * $page - $this->limit */);
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
                         * no data so, i colspan the row in 14 with data "no data"
                         */
                        $this->table->add_row(array('data' => 'no data', 'colspan' => '14', 'class' => 'taskStatus'));
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
                $data['table_subjects'] = $this->table->generate();

                /**
                 * generating html pagination
                 */
//                $data['table_subjects_pagination'] = $this->pagination->generate_bootstrap_link('students/view?student-id = ' . $this->student->id, $this->student->subject_total() / $this->limit, TRUE);
                $data['image_src']     = $this->_image_for_view_single_data();
                /**
                 * here we go!
                 * rendering page for view
                 */
                $template['view']      = MY_Controller::render('admin/_templates/students/view', $data, TRUE);
                $template['bootstrap'] = $this->_bootstrap_for_view();
                $this->render('admin/students', $template);
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
