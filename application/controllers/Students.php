<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Capstone_Controller
{


        private $limit;
        private $student_search;

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
        }

        public function index()
        {

                $search_course_id     = $this->input->get('course-id');
                $this->student_search = $this->input->get('search-student');
                /**
                 * check if user has a "dean" user_group
                 */
                $is_dean              = FALSE;
                if ($this->session->userdata('user_is_dean'))
                {
                        if (is_null($this->session->userdata('user_dean_course_id')))
                        {
                                show_error('Current user_group is DEAN, but no course_id related.');
                        }
                        $search_course_id = $this->session->userdata('user_dean_course_id');
                        $is_dean          = TRUE;
                }

                if ($is_dean)
                {
                        if ($this->input->get('status'))
                        {
                                $template = $this->_table_view($search_course_id);
                        }
                        elseif ($this->student_search)
                        {
                                $template = $this->_table_view($search_course_id, $is_dean);
                        }
                        else
                        {
                                $this->breadcrumbs->unshift(3, lang('index_student_heading') . ' Search Form', 'students');
                                $template = $this->_search_form();
                        }
                }
                else
                {
                        $template = $this->_table_view($search_course_id);
                }

                $template['bootstrap'] = $this->_bootstrap();
                /**
                 * rendering students view
                 */
                $this->render('admin/students', $template);
        }

        private function _search_form()
        {

                $inputs['student_search'] = array(
                    'name'  => 'search-student',
                    'value' => $this->session->userdata('search-student'),
                    'type'  => 'text',
                    'lang'  => 'student_search_label'
                );

                $template['search_form_for_dean'] = $this->form_boostrap('students', $inputs, 'student_search_label', 'student_search_label', 'info-sign', NULL, TRUE, FALSE, 6, FALSE, array('method' => 'get'));
                return $template;
        }

        private function _table_view($search_course_id, $is_dean = FALSE)
        {
                $student_result = $this->Student_model->all($this->limit, $this->limit * get_page_in_url('page') - $this->limit, $search_course_id, $this->student_search, FALSE, $this->input->get('status'), $is_dean);

                $student_obj                 = $student_result->result;
                $result_count_for_pagination = $student_result->count;

                $table_data = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {
                                $view_ = table_row_button_link('students/view?student-id=' . $student->student_id, 'View', 'btn-info');
                                $edit_ = '';
                                if (in_array('edit-student', permission_controllers()))
                                {
                                        $edit_ = table_row_button_link('edit-student?student-id=' . $student->student_id, 'Edit', 'btn-warning');
                                }
                                $tmp = array(
                                    $this->_images_for_table($student),
                                    highlight_phrase(($student->student_school_id == '') ? '--' : $student->student_school_id, $this->student_search),
                                    highlight_phrase($student->student_lastname, $this->student_search),
                                    highlight_phrase($student->student_firstname, $this->student_search),
                                    highlight_phrase($student->student_middlename, $this->student_search),
                                    my_htmlspecialchars($student->course_code),
                                    my_htmlspecialchars(number_roman($student->enrollment_year_level)),
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
                $bred_crumbs      = '';
                if ($search_course_id)
                {
                        $pagination_index .= '?course-id=' . $search_course_id;
                        $course_code      = $this->Course_model->get($search_course_id);
                        if ( ! $course_code)
                        {
                                show_error('no result');
                        }
                        $course_code                     = $course_code->course_code;
                        $template['search_result_label'] = paragraph(sprintf(lang('search_result_course_label'/* ci_students_lang */), bold($result_count_for_pagination), bold($course_code)));
                        if (1)//permission
                        {
                                $template['student_per_course_report_btn'] = MY_Controller::render('admin/_templates/button_view', array(
                                            'href'         => 'students/report?course-id=' . $search_course_id,
                                            'button_label' => 'Excel Report for ' . $course_code,
                                            'extra'        => array('class' => 'btn btn-success icon-print'),
                                                ), TRUE);
                        }
                        $bred_crumbs = " [ Program: $course_code ]";
                }
                if ($this->student_search)
                {
                        $this->session->set_userdata('search-student', $this->student_search);
                        if ( ! preg_match('![?]!', $pagination_index))
                        {
                                $pagination_index .= '?';
                        }
                        else
                        {
                                $pagination_index .= '&';
                        }
                        $pagination_index .= 'search-student=' . $this->student_search;

                        $template['search_result_label'] = paragraph(sprintf(lang('search_result_label'/* ci_students_lang */), bold($result_count_for_pagination), bold($this->student_search)));
                        $bred_crumbs                     = " [ Search:  $this->student_search ]";
                }
                if ($tmp = $this->input->get('status'))
                {
                        if ($tmp == 'enrolled')
                        {
                                if ( ! preg_match('![?]!', $pagination_index))
                                {
                                        $pagination_index .= '?';
                                }
                                $pagination_index .= 'status=enrolled';
                        }
                        else
                        {
                                $pagination_index .= '&';
                        }
                        $template['search_result_label'] = paragraph(sprintf(lang('search_result_enrolled_label'/* ci_students_lang */), bold($result_count_for_pagination)));
                        $bred_crumbs                     = ' [ Enrolled ]';
                }
                $pagination = $this->pagination->generate_bootstrap_link($pagination_index, $result_count_for_pagination / $this->limit, TRUE);


                $this->breadcrumbs->unshift(2, lang('index_student_heading') . $bred_crumbs, $pagination_index);


                $template['table_students'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_student_heading', $pagination, TRUE);
                return $template;
        }

        public function report()
        {
                $course_obj = check_id_from_url('course_id', 'Course_model', 'course-id');
                $this->Student_model->export_excel($course_obj->course_id, $course_obj->course_code);
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
                if ( ! file_exists($image_file))
                {
                        /**
                         * if there's a data from db but none of server file
                         */
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

        public function set_enroll_added_subjects()
        {
                $this->Student_model->set_informations($this->input->get('student-id'));
                if ($this->student->set_enroll_all_subject_offers())
                {

                        $this->session->set_flashdata('message', bootstrap_success('Subject/s Enrolled Successfully!'));
                }
                else
                {
                        $this->session->set_flashdata('message', bootstrap_error('Failed to Enroll Subjects.'));
                }
                redirect('students/view?student-id=' . $this->student->id, 'refresh');
        }

        public function print_data()
        {
                $this->load->model('Report_info_model');
                $report_obj = $this->Report_info_model->get();
                if ($action     = (string) $this->input->get('action'))
                {
                        $id = check_id_from_url('student_id', 'Student_model', 'student-id')->student_id;
                        $this->Student_model->set_informations($id);
                        if ( ! $this->student->is_enrolled())
                        {
                                show_error('Stundent Copy is not available when not enrolled.');
                        }
                        $data['subjecs']     = $this->view(TRUE);
                        $data['report_info'] = $report_obj;

                        if ($action === 'prev')
                        {
                                //$data['print_link'] = anchor('students/print_data?action=print&student-id=' . $this->student->id, lang('print_label'));
                                MY_Controller::render('admin/_templates/students/print', $data);
                        }
//                        elseif ($action === 'print')
//                        {
//                                $this->load->library('pdf');
//                                $this->pdf->print_now(MY_Controller::render('admin/_templates/students/print', $data, TRUE));
//                        }
                }
        }

        /**
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function view($return_html = FALSE)//parameter TRUE use for printing
        {
                if ( ! $return_html)
                {
                        $this->breadcrumbs->unshift(2, lang('index_student_heading'), 'students');
                }
                /*
                 * check url with id,tehn get studewnt row
                 */
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, 'View Student [' . $this->student->school_id(TRUE) . ']', 'students/view?student-id=' . $this->student->id);
                /**
                 * check if user is "dean" then check the courseId of student
                 */
                if ($this->session->userdata('user_is_dean'))
                {
                        if (is_null($this->session->userdata('user_dean_course_id')))
                        {
                                show_error('Current user_group is DEAN, but no course_id related.');
                        }
                        if ($this->student->course_id != $this->session->userdata('user_dean_course_id'))
                        {
                                show_error('Current DEAN is not same course of current student.');
                        }
                }
                $caption__       = '';
                $current_subject = TRUE;
                if ($key             = $this->input->get('subject'))
                {
                        if ($key == 'all')
                        {
                                $current_subject = FALSE;
                                $caption__       = ' [ALL]';
                        }
                        unset($key);
                }
                /**
                 * get subject from db
                 */
                //parameter is for remove button link in faculty
                $student_subjects_result = $this->student->subject_offers($return_html, 'array', $current_subject);

                $tbale_template = NULL;

                if ($return_html)
                {
                        /**
                         * design for printing preview
                         */
                        $caption = 'Subjects';

                        $tbale_template = array(
                            'table_open'         => '<table border="1">', //modified
                            'thead_open'         => '<thead>',
                            'thead_close'        => '</thead>',
                            'heading_row_start'  => '<tr>',
                            'heading_row_end'    => '</tr>',
                            'heading_cell_start' => '<td>', //modified   //replace <th> to <td>
                            'heading_cell_end'   => '</th>',
                            'tbody_open'         => '<tbody>',
                            'tbody_close'        => '</tbody>',
                            'row_start'          => '<tr>',
                            'row_end'            => '</tr>',
                            'cell_start'         => '<td>',
                            'cell_end'           => '</td>',
                            'row_alt_start'      => '<tr>',
                            'row_alt_end'        => '</tr>',
                            'cell_alt_start'     => '<td>',
                            'cell_alt_end'       => '</td>',
                            'table_close'        => '</table>'
                        );
                }
                else
                {
                        /*
                         * for web view design template table bootstrap
                         */
                        $this->config->load('admin/table');
                        $caption        = heading(lang('subjects_currently_enrolled') . $caption__, 4);
                        $tbale_template = array(
                            'table_open'         => $this->config->item('table_open_invoice'), //modified
                            'thead_open'         => '<thead>',
                            'thead_close'        => '</thead>',
                            'heading_row_start'  => '<tr>',
                            'heading_row_end'    => '</tr>',
                            'heading_cell_start' => '<th>',
                            'heading_cell_end'   => '</th>',
                            'tbody_open'         => '<tbody>',
                            'tbody_close'        => '</tbody>',
                            'row_start'          => '<tr>',
                            'row_end'            => '</tr>',
                            'cell_start'         => '<td>',
                            'cell_end'           => '</td>',
                            'row_alt_start'      => '<tr>',
                            'row_alt_end'        => '</tr>',
                            'cell_alt_start'     => '<td>',
                            'cell_alt_end'       => '</td>',
                            'table_close'        => '</table>'
                        );
                }

                /**
                 * table header
                 */
                $header = array(
                    //  lang('student_year_th'),
                    // lang('student_semester_th'),
                    lang('student_subject_th'), /* lang in students_lang */
                    lang('student_subject_desc_th'), /* lang in students_lang */
                    lang('student_unit_th'),
                    lang('student_day1_th'),
                    lang('student_start_th'),
                    lang('student_end_th'),
                    lang('student_room_th'),
                    lang('student_instructor_th'),
//                    lang('student_day2_th'),
//                    lang('student_start_th'),
//                    lang('student_end_th'),
//                    lang('student_room_th'),
//                    'Rate / Price',
                );
                if (!$return_html)
                {
                        $header[] = lang('student_status_th');
                }


                /**
                 * start generating htnml table with data rows
                 */
                $result_html_with_subjects = $this->table_bootstrap($header, $student_subjects_result, $tbale_template, 'index_room_heading', FALSE, TRUE, $caption, FALSE/* FALSE to ignore bootsrap */);

                if ($return_html)
                {
                        /**
                         * use for printing
                         */
                        return $result_html_with_subjects;
                }


                /*
                 * for web view vars
                 */
                $data['table_subjects'] = $result_html_with_subjects;
                $data['image_src']      = $this->_image_for_view_single_data();
                ;
                /**
                 * here we go!
                 * rendering page for view
                 */
                $template['view']       = MY_Controller::render('admin/_templates/students/view', $data, TRUE);
                $template['bootstrap']  = $this->_bootstrap_for_view();
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
