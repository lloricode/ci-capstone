<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_student_subject extends CI_Capstone_Controller
{


        private $_session_name_;
        private $_sub_off__added_obj_from_session;
        private $_total_unit;
        private $_all_unit_plus_pending;

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->load->helper(array('day', 'time', 'number', 'inflector'));
                $this->load->model(array(
                    'Student_model',
                    'Curriculum_subject_model',
                    'Subject_model',
                    'Requisites_model',
                    'Curriculum_model',
                    'Room_model'
                ));
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
                $this->breadcrumbs->unshift(2, lang('index_student_heading'), 'students');

                /**
                 *   this will always check in hook `Check_access`
                 * 
                 * if another controller request it will reset
                 */
                $this->_session_name_                   = $this->config->item('create_student_subject__session_name');
                $this->_sub_off__added_obj_from_session = array();
        }

        public function index()
        {
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, 'View Student [ ' . $this->student->school_id(TRUE) . ' ]', 'students/view?student-id=' . $this->student->id);
                $this->breadcrumbs->unshift(4, lang('add_student_subject_label'), 'create-student-subject?student-id=' . $this->student->id);

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

                $this->_all_unit_plus_pending = $this->student->enrolled_units(TRUE, FALSE);

                $error_message = '';

                if ($this->input->post('submit'))
                {
                        if ($this->session->has_userdata($this->_session_name_))
                        {
                                $from_session = $this->session->userdata($this->_session_name_);
                                $this->load->model('Students_subjects_model');

                                /**
                                 * start the DB transaction
                                 */
                                $this->db->trans_begin();

                                $update_year_ok = $this->student->update_level((int) $this->input->post('level'));

                                $all_inserted = TRUE;
                                foreach ($from_session as $subj_offr_id)
                                {
                                        $subject_id = $this->Subject_offer_model->get($subj_offr_id)->subject_id;
                                        $gen_id     = $this->Students_subjects_model->insert(array(
                                            'enrollment_id'               => $this->student->enrollment_id,
                                            'curriculum_id'               => $this->student->curriculum_id,
                                            'student_subject_semester'    => current_school_semester(TRUE),
                                            'student_subject_school_year' => current_school_year(),
                                            'subject_offer_id'            => $subj_offr_id,
                                            'curriculum_subject_id'       => $this->_get_curriculum_subject_id($this->student->curriculum_id, $subject_id)
                                        ));
                                        if ( ! $gen_id)
                                        {
                                                $all_inserted = FALSE;
                                                break;
                                        }
                                }
                                $is_curriculum_yr_lvl_not_exceed = $this->_is_curriculum_yr_lvl_not_exceed();
                                $is_unit_not_exceed              = $this->_is_unit_not_exceed();
                                if ( ! $is_curriculum_yr_lvl_not_exceed OR ! $is_unit_not_exceed OR ! $all_inserted OR ! $update_year_ok)
                                {
                                        /**
                                         * rollback database
                                         */
                                        $this->db->trans_rollback();
                                        $msg = '';
                                        if ( ! $all_inserted)
                                        {
                                                $msg .= ' Failed add subjects';
                                        }
                                        if ( ! $update_year_ok)
                                        {
                                                $msg .= ' Failed update year level';
                                        }
                                        if ( ! $all_inserted OR ! $update_year_ok)
                                        {
                                                $this->session->set_flashdata('message', bootstrap_error($msg)); //dont mention :D temporary and means bugs
                                        }
                                }
                                else
                                {
                                        if ($this->db->trans_commit())
                                        {
                                                $this->_reset_session();
                                                $this->session->set_flashdata('message', bootstrap_success('All subjects added!'));
                                                redirect(site_url('students/view?student-id=' . $this->student->id), 'refresh');
                                        }
                                }
                        }
                        else
                        {
                                $error_message = 'please select subject.';
                                $this->session->set_flashdata('message', bootstrap_error($error_message));
                        }
                }

                $this->_form_view($error_message);
        }

        private function _get_curriculum_subject_id($cur_id, $subject_id)
        {
                return $this->
                                Curriculum_subject_model->
                                fields($this->Curriculum_subject_model->primary_key)->
                                //set_cache()->
                                where(array(
                                    'curriculum_id' => $cur_id,
                                    'subject_id'    => $subject_id
                                ))->
                                get()->
                        {$this->Curriculum_subject_model->primary_key};
        }

        private function _is_curriculum_yr_lvl_not_exceed()
        {
                return TRUE;
        }

        private function _is_unit_not_exceed()
        {
                $maximum_units = (int) $this->Curriculum_subject_model->total_units_per_term($this->student->curriculum_id, current_school_semester(TRUE), $this->input->post('level'));

                if ($this->session->has_userdata('total_unit'))
                {
                        $unit_session = (int) $this->session->userdata('total_unit');
                        $unit_session += $this->_all_unit_plus_pending;
                        if ($maximum_units === 0)
                        {
                                $this->session->set_flashdata('message', bootstrap_error(lang('no_unit') . ' [ ' . current_school_semester() . ' ]'));
                                return FALSE;
                        }
                        elseif ($unit_session > $maximum_units)
                        {
                                $this->session->set_flashdata('message', bootstrap_error('unit_exceed'));
                                return FALSE;
                        }

                        return TRUE;
                }
                $this->session->set_flashdata('message', bootstrap_error('_is_unit_not_exceed'));
                return FALSE;
        }

        /**
         * this info will now include in submit form
         * 
         * 
         * 
         * @return array
         */
        private function _student_information()
        {
                $unit = 'unit';
                $unit = ($this->_total_unit > 1) ? plural($unit) : $unit;

                $this->session->set_userdata('total_unit', $this->_total_unit);
                $inputs['totalunit'] = array(
                    'name'     => 'xx',
                    'value'    => $this->_total_unit . ' ' . $unit,
                    'type'     => 'text',
                    'lang'     => 'added_subjects_total_units',
                    'disabled' => ''
                );

                $all_unit                      = ($this->_total_unit + $this->_all_unit_plus_pending);
                $inputs['enrooler_units_plus'] = array(
                    'name'     => 'xx',
                    'value'    => $all_unit . ' ' . (($all_unit > 1) ? plural($unit) : $unit),
                    'type'     => 'text',
                    'lang'     => 'stundent_enrolled_unit_plus_added_subjects_label', //student_lang
                    'disabled' => '',
                    'note'     => 'Included pending subjects to enroll.'
                );

                $inputs['enrooler_units'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->enrolled_units(),
                    'type'     => 'text',
                    'lang'     => 'stundent_enrolled_unit_label', //student_lang
                    'disabled' => ''
                );

                $inputs['school_id'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->school_id(),
                    'type'     => 'text',
                    'lang'     => 'index_student_school_id_th',
                    'disabled' => ''
                );

                $inputs['firstname'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->firstname,
                    'type'     => 'text',
                    'lang'     => 'create_student_firstname_label',
                    'disabled' => ''
                );

                $inputs['middlename'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->middlename,
                    'type'     => 'text',
                    'lang'     => 'create_student_middlename_label',
                    'disabled' => ''
                );

                $inputs['lastname'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->lastname,
                    'type'     => 'text',
                    'lang'     => 'create_student_lastname_label',
                    'disabled' => ''
                );

                $inputs['course'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->course_code,
                    'type'     => 'text',
                    'lang'     => 'student_course_code', //in student lang
                    'disabled' => ''
                );

                $this->load->helper('combobox');
                $inputs['level'] = array(
                    'name'     => 'level',
                    // 'default'    => $this->student->level,
                    'value'    => _numbers_for_drop_down($this->student->level, $this->config->item('max_year_level')),
                    'type'     => 'dropdown',
                    'lang'     => 'index_student_year_level_th',
                    'disabled' => ''
                );

                $inputs['enrollstatus'] = array(
                    'name'     => 'xx',
                    'value'    => $this->student->is_enrolled(TRUE),
                    'type'     => 'text',
                    'lang'     => 'student_enroll_statuse',
                    'disabled' => ''
                );

                return $inputs;
        }

        private function _form_view($error_message)
        {

                /**
                 * add session
                 */
                $this->_add_session_subjects();

                /**
                 * view all subject available to add
                 */
                $data['student_subject_curriculum_table'] = $this->_table_view('db');

                /**
                 * subject added to session
                 */
                $data['added_subject_table'] = $this->_table_view('session');

                if ($this->session->has_userdata($this->_session_name_))
                {
                        /**
                         * button for reset session
                         * will view this if has session on added subject
                         */
                        $data['reset_subject_offer_session'] = MY_Controller::render('admin/_templates/button_view', array(
                                    'href'         => 'create-student-subject/reset-subject-offer-session?student-id=' . $this->student->id,
                                    'button_label' => 'reset subject offer session',
                                    'extra'        => array('class' => 'btn btn-success icon-edit'),
                                        ), TRUE);
                }

                /**
                 * generate information for current student
                 */
                $frm_bosstrap                 = array(
                    //required
                    'inputs'      => $this->_student_information(),
                    'action'      => 'create-student-subject?student-id=' . $this->student->id,
                    'lang_header' => 'student_information',
                    'lang_button' => 'add_student_subject_label',
                    'icon'        => 'user',
                    //non required
                    'error'       => $error_message,
                        // 'form_size'     => $_form_size,
                        // 'hidden_inputs' => $_hidden_inputs
                );
                $data['student_subject_form'] = $this->form_boostrap($frm_bosstrap, TRUE, TRUE); //second parant if return html,tirdth param is remove bootstrap_divs

                $data['bootstrap']  = $this->_bootstrap();
                $data['term_units'] = $this->_term_units();
                $this->render('admin/create_student_subject', $data);
        }

        private function _term_units()
        {
                $current_sem = current_school_semester(TRUE);
                $t_unit      = array();
                foreach ($this->student->get_all_term_units() as $v)
                {
                        $temp  = '';
                        if ($level = $this->input->post('level'))
                        {
                                if ($level === $v->level && $current_sem === $v->sem)
                                {
                                        $temp = '<span style="color:red">===></span>  ';
                                }
                        }
                        $t_unit[] = array(
                            'name'         => 'xx',
                            'value'        => $v->unit,
                            'type'         => 'text',
                            'lang'         => $temp . number_roman($v->level) . ' - ' . lang('semester_' . $v->sem . '_short_label'),
                            'ingnore_lang' => TRUE,
                            'disabled'     => ''
                        );
                }
                return $t_unit;
        }

        /**
         * unset session for subject offer 
         */
        public function reset_subject_offer_session()
        {
                $this->_reset_session();
                redirect('create-student-subject?student-id=' . $this->input->get('student-id'), 'refresh');
        }

        private function _reset_session()
        {
                if ($this->session->has_userdata($this->_session_name_))
                {
                        $this->session->unset_userdata($this->_session_name_);
                        $this->session->set_flashdata('message', bootstrap_success('Reset done!'));
                }
        }

        /**
         * unset one index/value in session for subject offer 
         */
        public function unset_value_subject_offer_session()
        {
                if ($this->session->has_userdata($this->_session_name_))
                {
                        $this->load->helper('session');
                        unset_value_userdata_array($this->_session_name_, $this->input->get('subject-offer-id'));
                        $this->session->set_flashdata('message', bootstrap_success('Removed done!'));
                }
                redirect('create-student-subject?student-id=' . $this->input->get('student-id'), 'refresh');
        }

        private function _table_view($type)
        {
                $cur_subj_obj      = NULL;
                $table_data        = array();
                $this->_total_unit = 0;

                switch ($type)
                {
                        case 'db':
                                $cur_subj_obj = $this->student->get_all_subject_available_to_enroll();
                                $lang_caption = 'available_subjects_to_enroll'; /* lang in in students_lang */
                                $header_col   = lang('add_student_subject_label');
                                break;
                        case 'session':
                                $cur_subj_obj = $this->_sub_off__added_obj_from_session;
                                $lang_caption = 'added_subjects_to_enroll'; /* lang in in students_lang */
                                $header_col   = lang('remove_subjects_to_enroll');
                                break;
                }

                if ($cur_subj_obj)
                {
                        $tmp_compare = '';
                        foreach ($cur_subj_obj as $s)
                        {
                                if ($type == 'db')
                                {
                                        if ($this->_is_in_session($s->subject_offer_id))
                                        {
                                                $this->_sub_off__added_obj_from_session[] = $s; //add to added object
                                                continue; //skip, already in session
                                        }
                                }
                                $curr_subj_obj___ = $this->Curriculum_subject_model->where(array(
                                            'curriculum_id' => $this->student->curriculum_id,
                                            'subject_id'    => $s->subject->subject_id
                                        ))->get();
                                $tmp_sem_year     = $curr_subj_obj___->curriculum_subject_year_level . $curr_subj_obj___->curriculum_subject_semester;

                                if ($tmp_compare != $tmp_sem_year)
                                {
                                        $tmp_compare  = $tmp_sem_year;
                                        // $total_units  = $this->Curriculum_subject_model->total_units_per_term($curr_subj_obj___->curriculum_id, $curr_subj_obj___->curriculum_subject_semester, $curr_subj_obj___->curriculum_subject_year_level);
                                        $table_data[] = array(
                                            array(
                                                'data'    => heading(number_place($curr_subj_obj___->curriculum_subject_year_level) . ' Year - ' .
                                                        semesters($curr_subj_obj___->curriculum_subject_semester)
                                                        , 4), //. ' Total units: ' . bold($total_units),
                                                'colspan' => '16'
                                            )
                                        );
                                }

                                //for db
                                $full_room = FALSE;

                                $sched1    = NULL;
                                $sched2    = NULL;
                                $row_count = 0;
                                foreach ($s->subject_line as $su_l)
                                {
                                        ++ $row_count;
                                        ${'sched' . $row_count} = array(
                                            subject_offers_days($su_l),
                                            convert_24_to_12hrs($su_l->subject_offer_line_start),
                                            convert_24_to_12hrs($su_l->subject_offer_line_end),
                                            $su_l->room->room_number,
                                            $this->_room_capacity($s->subject_offer_id, $su_l->room->room_capacity)
                                        );
                                        if ($type == 'db' && ! $full_room)
                                        {
                                                list($ocupy, $max) = explode('/', $this->_room_capacity($s->subject_offer_id, $su_l->room->room_capacity));
                                                $full_room = (bool) ( ! ($ocupy < $max));
                                        }
                                }
                                $row_output   = array();
                                $row_output[] = $this->_row($this->Curriculum_model->button_link($curr_subj_obj___->curriculum_id, $s->subject->subject_code, $s->subject->subject_description), $row_count);

                                $row_output[] = $this->_row($this->User_model->button_link($s->faculty->id, $s->faculty->last_name, $s->faculty->first_name), $row_count);


                                foreach ($sched1 as $v)
                                {
                                        $row_output[] = $v;
                                }

                                $btn_link = '';
                                switch ($type)
                                {
                                        case 'db':
                                                if ($full_room)
                                                {
                                                        $btn_link    = '<span class="pending">' . 'Full Capacity' . '</span>';
                                                        $link_create = 'create-subject-offer?subject-id=' . $s->subject->subject_id;
                                                        $btn_link    .= br() . table_row_button_link(
                                                                        $link_create, lang('create_subject_offer_heading')
                                                        );
                                                }
                                                else
                                                {
                                                        $btn_link = table_row_button_link(
                                                                'create-student-subject?student-id=' . $this->student->id .
                                                                '&subject-offer-id=' . $s->subject_offer_id, lang('add_student_subject_label')
                                                        );
                                                }
                                                break;
                                        case 'session':
                                                $btn_link = table_row_button_link(
                                                        'create-student-subject/unset-value-subject-offer-session?student-id=' . $this->student->id .
                                                        '&subject-offer-id=' . $s->subject_offer_id, lang('remove_subjects_to_enroll')
                                                );
                                                break;
                                }
                                $row_output[] = $this->_row($curr_subj_obj___->curriculum_subject_units, $row_count);
                                $row_output[] = $this->_row($btn_link, $row_count, array('class' => 'taskStatus'));
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
                                /**
                                 * sumation of unit
                                 */
                                $this->_total_unit += $curr_subj_obj___->curriculum_subject_units;
                        }
                }
                /*
                 * Table headers
                 */
                $header   = array(
                    lang('student_subject_th'), /* lang in students_lang */
                    lang('student_instructor_th'),
                    lang('student_day1_th'),
                    lang('student_start_th'),
                    lang('student_end_th'),
                    lang('student_room_th'),
                    lang('index_room_capacity_th'),
                    lang('student_unit_th')
                );
                $header[] = $header_col;

                return $this->table_bootstrap($header, $table_data, 'table_open_bordered', $lang_caption/* lang in in students_lang */, FALSE, TRUE);
        }

        private function _row($data, $row_span, $attrib = FALSE)
        {
                if ($attrib)
                {
                        if ($row_span > 1)
                        {
                                return array_merge(array('data' => $data, 'rowspan' => "$row_span"), $attrib);
                        }
                        return array_merge(array('data' => $data), $attrib);
                }
                if ($row_span > 1)
                {
                        return array('data' => $data, 'rowspan' => "$row_span");
                }
                return $data;
        }

        private function _room_capacity($subj_off_id, $capacity)
        {
                return $this->Students_subjects_model->where(array(
                            'subject_offer_id' => $subj_off_id
                        ))->count_rows() . '/' . $capacity;
        }

        /**
         * check if schedule already in session
         * 
         * @param type $subject_offer_id
         * @return boolean
         */
        private function _is_in_session($subject_offer_id)
        {
                if ( ! $this->session->has_userdata($this->_session_name_))
                {
                        return FALSE;
                }
                return (bool) in_array($subject_offer_id, $this->session->userdata($this->_session_name_));
        }

        private function _add_session_subjects()
        {
                /**
                 * skip if required id not found
                 */
                if ( ! $this->input->get('subject-offer-id'))
                {
                        return;
                }
                /**
                 * check the id from url
                 */
                $subject_offer_obj = check_id_from_url('subject_offer_id', 'Subject_offer_model', 'subject-offer-id', array('subject_line', 'subject'));

                /**
                 * validate the subject if conflict with one value in session
                 */
                if ($this->_validate_subject($subject_offer_obj))
                {
                        /**
                         * load the helper
                         */
                        $this->load->helper('session');
                        set_userdata_array($this->_session_name_, (string) $subject_offer_obj->subject_offer_id, TRUE); //parameter TRUE to check unique valus on session array
                }
        }

        /**
         * this will check the comflict in adding schedule,
         * 
         * @param type $subject_offer_id
         * @return boolean
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _validate_subject($subject_offer_obj)
        {
                /**
                 * check room capacity
                 * 
                 * just incase if user know how to use inspect element
                 */
                foreach ($subject_offer_obj->subject_line as $s)
                {
                        $capacity_max = $this->Room_model->get($s->room_id)->room_capacity;

                        $ocupy = $this->Students_subjects_model->where(array(
                                    'subject_offer_id' => $subject_offer_obj->subject_offer_id
                                ))->count_rows();
                        if ( ! ($ocupy < $capacity_max))
                        {
                                $this->session->set_flashdata('message', bootstrap_error($subject_offer_obj->subject->subject_code));
                                return FALSE;
                        }
                }
                /**
                 * check selected subject to all session
                 */
                if ($this->session->has_userdata($this->_session_name_))
                {
                        $this->load->helper('validator');
                        $count = 0;
                        foreach ($subject_offer_obj->subject_line as $line)
                        {
                                $count ++;
                                ${'selected' . $count} = array(
                                    'start'   => $line->subject_offer_line_start,
                                    'end'     => $line->subject_offer_line_end,
                                    'room'    => $line->room_id,
                                    'faculty' => $subject_offer_obj->user_id,
                                    'subject' => $subject_offer_obj->subject_id
                                );
                                foreach (days_for_db() as $d)
                                {
                                        ${'selected' . $count} [$d] = $line->{'subject_offer_line_' . $d};
                                }
                        }
                        foreach ($this->session->userdata($this->_session_name_) as $subj_offr_id)
                        {
                                $row_   = $this->Subject_offer_model->with_subject_line()->get($subj_offr_id);
                                $count2 = 0;
                                foreach ($row_->subject_line as $_line)
                                {
                                        $count2 ++;
                                        ${'session' . $count2} = array(
                                            'start'   => $_line->subject_offer_line_start,
                                            'end'     => $_line->subject_offer_line_end,
                                            'room'    => $_line->room_id,
                                            'faculty' => $row_->user_id,
                                            'subject' => $row_->subject_id
                                        );
                                        foreach (days_for_db() as $d)
                                        {
                                                ${'session' . $count2} [$d] = $_line->{'subject_offer_line_' . $d};
                                        }
                                }
                                for ($i = 1; $i <= $count; $i ++ )
                                {
                                        for ($ii = 1; $ii <= $count2; $ii ++ )
                                        {
                                                $tmp = is_not_conflict_subject_offer(${'selected' . $i}, ${'session' . $ii});
                                                if ( ! $tmp)
                                                {
                                                        $subject_code = $this->subject_model->get(${'session' . $ii}['subject'])->subject_code;
                                                        $this->session->set_flashdata('message', bootstrap_error('Conflict: ' . $subject_code));
                                                        return FALSE;
                                                }
                                        }
                                }
                        }
                }

                /**
                 * get all subject_offer_ids by SUBJECT_ID && current_semester && current_school_year
                 */
                return TRUE;
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap()
        {
                /**
                 * for header
                 */
                $header = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/colorpicker.css',
                        'css/datepicker.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'css/bootstrap-wysihtml5.css',
                        'font-awesome/css/font-awesome.css" rel="stylesheet',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    /**
                     * wizard
                     */
//                        'css/bootstrap.min.css',
//                        'css/bootstrap-responsive.min.css',
//                        'css/matrix-style.css',
//                        'css/matrix-media.css',
//                        'font-awesome/css/font-awesome.css',
//                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    /**
                     * addition for form
                     */
//                        'css/colorpicker.css',
//                        'css/datepicker.css',
//                        'css/uniform.css',
//                        'css/select2.css',
//                        'css/bootstrap-wysihtml5.css',
                    ),
                    'js'  => array(),
                );
                /**
                 * for footer
                 */
                $footer = array(
                    'css' => array(),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/bootstrap-colorpicker.js',
                        'js/bootstrap-datepicker.js',
                        'js/jquery.toggle.buttons.js',
                        'js/masked.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/matrix.js',
                        'js/matrix.form_common.js',
                        'js/wysihtml5-0.3.0.js',
                        'js/jquery.peity.min.js',
                        'js/bootstrap-wysihtml5.js',
                        /**
                         * wizard
                         * 
                         */
//                        'js/jquery.min.js',
//                        'js/jquery.ui.custom.js',
//                        'js/bootstrap.min.js',
//                        'js/jquery.validate.js',
//                        'js/jquery.wizard.js',
//                        'js/matrix.js',
                        /*
                         * for frontend validation
                         */
                        site_url('assets/framework/bootstrap/admin/matrixwizard.js'),
                    /**
                     * addition for form
                     */
//                        'js/bootstrap-colorpicker.js',
//                        'js/bootstrap-datepicker.js',
//                        'js/jquery.toggle.buttons.js',
//                        'js/masked.js',
//                        'js/jquery.uniform.js',
//                        'js/select2.min.js',
//                        'js/matrix.form_common.js',
//                        'js/wysihtml5-0.3.0.js',
//                        'js/jquery.peity.min.js',
//                        'js/bootstrap-wysihtml5.js',
                    ),
                );
                /**
                 * footer extra
                 */
                /**
                 * addition for form
                 */
//                $footer_extra = "<script>
//                        $('.textarea_editor').wysihtml5();
//                </script>";

                $footer_extra = "<script>
	$('.textarea_editor').wysihtml5();
</script>";
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
