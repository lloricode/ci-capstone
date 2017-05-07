<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_offers extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->load->model(array(
                    'Subject_offer_model',
                    'Students_subjects_model'
                ));
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
                $this->breadcrumbs->unshift(3, lang('index_subject_offer_heading'), 'subject-offers');
                $this->load->helper(array('day', 'time', 'school'));
        }

        /**
         * @contributor Jinkee Po <pojinkee1@gmail.com>
         */
        public function index()
        {

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();

                //note: only current SEMESTER && SCHOOL_YEAR showed/result
                $subl = $this->Subject_offer_model->all(TRUE/* current sem n yr */, FALSE/* curr_id */, FALSE/* enrol_id */, $this->limit/* limit */, $this->limit * $this->page_ - $this->limit/* offset */, $this->_for_faculty_group()/* faculty_id */); //1st parameter is set to current semester and year

                $table_data = array();
                if ($subl)
                {
                        foreach ($subl as $s)
                        {
                                if ( ! isset($s->subject_line))
                                {
                                        // continue;
                                }

                                /**
                                 * get first the schedules times, to know if there a second schedule
                                 */
                                $sched1    = NULL;
                                $sched2    = NULL;
                                $row_count = 0;
                                foreach ($s->subject_line as $su_l)
                                {
                                        ++ $row_count;
                                        ${'sched' . $row_count} = array(
                                            subject_offers_days($su_l),
//                                            $this->_type($su_l->subject_offer_line_lec, $su_l->subject_offer_line_lab),
                                            convert_24_to_12hrs($su_l->subject_offer_line_start),
                                            convert_24_to_12hrs($su_l->subject_offer_line_end),
                                            $su_l->room->room_number,
                                            $this->_room_capacity($s->subject_offer_id, $su_l->room->room_capacity)
                                        );
                                }

                                $row_output   = array();
                                $row_output[] = $this->_row($s->subject->subject_code, $row_count);

                                if ( ! $this->_for_faculty_group())
                                {
                                        /**
                                         *  if current user_group is faculty, no need to view who faculty of schedule
                                         */
                                        $row_output[] = $this->_row($this->User_model->button_link($s->faculty->id, $s->faculty->last_name, $s->faculty->first_name), $row_count);
                                }

                                foreach ($sched1 as $v)
                                {
                                        $row_output[] = $v;
                                }

                                $row_output[] = $this->_row($this->_option_button_view($s->subject_offer_id), $row_count);
                                if ($this->ion_auth->is_admin())
                                {

                                        $row_output[] = $this->_row($this->User_model->modidy($s, 'created'), $row_count);
                                        $row_output[] = $this->_row($this->User_model->modidy($s, 'updated'), $row_count);
                                }
                                $table_data[] = $row_output;

                                if ($row_count === 2)// if there a second sched
                                {
                                        $tmp = array();
                                        foreach ($sched2 as $v)
                                        {
                                                $tmp[] = $v;
                                        }
                                        $table_data[] = $tmp;
                                }
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_subject_id_th'),
                    lang('index_user_id_th'),
                    lang('index_subject_offer_days_th'),
//                    lang('create_type_label'),
                    lang('index_subject_offer_start_th'),
                    lang('index_subject_offer_end_th'),
                    lang('index_room_id_th'),
                    lang('index_room_capacity_th'),
                    'Option'
                );
                if ($this->_for_faculty_group())
                {
                        /**
                         * unset header faculty|instructor if current user_group is faculty
                         */
                        unset($header[1]);
                }
                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }

                $obj_pagination = $this->Subject_offer_model->where($this->Subject_offer_model->where_current_sem_year(TRUE));
                if ($user_id        = $this->_for_faculty_group())
                {
                        $obj_pagination->where(array(
                            'user_id' => $user_id
                        ));
                }

                $count = $obj_pagination->count_rows();

                $pagination = $this->pagination->generate_bootstrap_link('subject-offers/index', $count / $this->limit);

                $template['table_subject_offers'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_subject_offer_heading', $pagination, TRUE);
                $template['message']              = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']            = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/subject_offers', $template);
        }

        private function _row($data, $row_span)
        {
                if ($row_span > 1)
                {
                        return array('data' => $data, 'rowspan' => "$row_span");
                }
                return $data;
        }

        private function _option_button_view($subj_offr_id)
        {
                return table_row_button_link('subject-offers/view?subject-offer-id=' . $subj_offr_id, 'Details');
        }

        /**
         * if user has 'faculty',then return the user_id, else NULL
         * 
         * @return int
         */
        private function _for_faculty_group()
        {
                if ($this->ion_auth->in_group($this->config->item('user_group_faculty')))
                {
                        return $this->ion_auth->get_user_id();
                }
                return NULL;
        }

        private function _room_capacity($subj_off_id, $capacity)
        {
                return $this->Students_subjects_model->where(array(
                            'subject_offer_id' => $subj_off_id
                        ))->count_rows() . '/' . $capacity;
        }

        private function _type($lec, $lab)
        {
                $return = '';
                if ($lec)
                {
                        $return .= 'LEC';
                }
                if ($lab)
                {
                        $return .= 'LAB';
                }
                if ( ! $lec && ! $lab)
                {
                        $return = '--';
                }
                return $return;
        }

        /**
         * for viewing detail of specific schedule.
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function view()
        {
                $data = $this->_data();

                $template['facullty_schedule_students'] = MY_Controller::render('admin/_templates/button_view', array(
                            'href'         => 'subject-offers/report?subject-offer-id=' . $data->obj->subject_offer_id . '&report=excel',
                            'button_label' => 'Excel Report for ',
                            'extra'        => array('class' => 'btn btn-success icon-print'),
                                ), TRUE);

                $template['view'] = $this->table_bootstrap($data->header, $data->data, 'table_open_bordered', 'index_student_heading', FALSE, TRUE);

                $template['bootstrap'] = $this->_bootstrap();
                $this->render('admin/subject_offers', $template);
        }

        private function _data()
        {
                $subj_orr_obj = check_id_from_url('subject_offer_id', 'Subject_offer_model', 'subject-offer-id');
                $this->breadcrumbs->unshift(4, 'View', 'subject-offers/view?subject-offer-id=' . $subj_orr_obj->subject_offer_id);

                if ($this->_for_faculty_group())//if faculty
                {
                        /**
                         * check if user access none schedule with own
                         */
                        if ($subj_orr_obj->user_id != $this->ion_auth->get_user_id())
                        {
                                show_error('Class Schedule is not in your permission.');
                        }
                }

                $this->load->model(array('Students_subjects_model', 'Course_model'));
                $this->load->helper('number');
                $obj        = $this->Students_subjects_model->
                        with_enrollments(array(
                            'fields' => 'student_id,course_id,enrollment_year_level,enrollment_status',
                            'with'   => array(
                                'relation' => 'student'
                            )
                        ))->
                        where(array(
                            'subject_offer_id' => $subj_orr_obj->subject_offer_id
                        ))->
                        //set_cache()->
                        get_all();
                $table_data = array();
                if ($obj)
                {
                        foreach ($obj as $s)
                        {
                                array_push($table_data, array(
                                    ( $s->enrollments->student->student_school_id) ? $s->enrollments->student->student_school_id : '--',
                                    $s->enrollments->student->student_lastname,
                                    $s->enrollments->student->student_firstname,
                                    $s->enrollments->student->student_middlename,
                                    $this->Course_model->get($s->enrollments->course_id)->course_code,
                                    number_roman($s->enrollments->enrollment_year_level),
                                    ($s->enrollments->enrollment_status) ? 'Enrolled' : 'Not',
                                ));
                        }
                }

                $header = array(
                    lang('index_student_school_id_th'),
                    lang('index_student_lastname_th'),
                    lang('index_student_firstname_th'),
                    lang('index_student_middlename_th'),
                    'course',
                    'level',
                    'subject enrolled'
                );

                return (object) array(
                            'header' => $header,
                            'data'   => $table_data,
                            'obj'    => $subj_orr_obj
                );
        }

        public function report()
        {
                if ('excel' === ((string) $this->input->get('report')))
                {
                        $data                  = $this->_data();
                        $this->load->library('excel');
                        $this->excel->filename = 'Report Schedule.';
                        $this->excel->make_from_array($data->header, $data->data);
                }
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
                    'js'  => array(),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(),
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
