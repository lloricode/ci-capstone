<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_students');
                $this->load->model(array('Student_model'));
                $this->load->library('pagination');
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

                //list students
                $student_obj = $this->Student_model->
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
                                $view_ = anchor(site_url('students/view?student-id=' . $student->student_id), '<span class="btn btn-warning btn-mini">View</span>');
                                $edit_ = anchor(site_url('edit-student?student-id=' . $student->student_id), '<span class="btn btn-primary btn-mini">Edit</span>');

                                array_push($table_data, array(
                                    $this->_image($student),
                                    my_htmlspecialchars($student->student_school_id),
                                    my_htmlspecialchars($student->student_lastname),
                                    my_htmlspecialchars($student->student_firstname),
                                    my_htmlspecialchars($student->student_middlename),
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
                    'Options'
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

        private function _image($student)
        {
                list($filename, $extension) = explode('.', $student->student_image);

                return '<div class="user-thumb">' . img(array(
                            'src'   => $this->config->item('student_image_dir') . $this->config->item('student_image_size_table') . $filename . '_thumb.' . $extension,
                            'alt'   => 'no image',
                            'title' => $student->student_school_id . ' - ' . $student->student_lastname
                        )) . '</div>';
        }

        /**
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function view()
        {

                $this->load->library('student');
                $this->load->helper('time');
                /*
                 * check url with id,tehn get studewnt row
                 */
                $this->student->get($this->input->get('student-id'));
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


                /**
                 * here we go!
                 * rendering page for view
                 */
                $this->template['view']      = MY_Controller::_render('admin/_templates/students/view', $this->data, TRUE);
                $this->template['bootstrap'] = $this->_bootstrap_for_view();
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
