<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject_offer extends CI_Capstone_Controller
{


        private $data;

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->load->model('Subject_model');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
                $this->breadcrumbs->unshift(3, lang('index_subject_offer_heading'), 'subject-offers');
                $this->breadcrumbs->unshift(4, lang('create_subject_offer_heading'), 'create-subject-offer');
                /**
                 * for check box, in days
                 */
                $this->load->library('table');
                $this->load->helper('time');
        }

        /**
         * @Contributor: Jinkee Po <pojinkee1@gmail.com>
         *         
         */
        public function index()
        {
                $is_error = FALSE;
                if ($this->input->post('submit'))
                {
                        $validate_two_forms = TRUE;
                        $this->load->model(array('Subject_offer_model', 'Subject_offer_line_model'));

                        /**
                         * for getting current year and semester
                         */
                        $this->load->helper('school');



                        /**
                         * storing all validations
                         */
                        $all_validations = array_merge($this->Subject_offer_model->insert_validations(), $this->Subject_offer_line_model->insert_validations());


                        /**
                         * check if second schedule if excluded
                         */
                        $sched_id2 = TRUE;
                        $exclude   = $this->input->post('exclude'); //see view for this code
                        if ( ! ($exclude && ! empty($exclude)))
                        {
                                /**
                                 * will check if two form conflict, if included the second form
                                 */
                                $validate_two_forms = $this->_validate_two_shedules();
                                /**
                                 * merge validation rules
                                 */
                                $all_validations    = array_merge($all_validations, $this->Subject_offer_line_model->insert_validations2());
                        }

                        /**
                         * set validation rules
                         */
                        $this->form_validation->set_rules($all_validations);



                        if ($this->form_validation->run())
                        {
                                /**
                                 * start the DB transaction
                                 */
                                $this->db->trans_begin();

                                $subject_offer_insert = array(
                                    'user_id'                   => $this->input->post('faculty', TRUE),
                                    'subject_id'                => $this->input->post('subject', TRUE),
                                    'subject_offer_semester'    => current_school_semester(TRUE),
                                    'subject_offer_school_year' => current_school_year()
                                );
                                $sub_offer_id         = $this->Subject_offer_model->insert($subject_offer_insert);

//                                $lec = FALSE;
//                                $lab = FALSE;
//                                foreach ($this->input->post('leclab', TRUE) as $v)
//                                {
//                                        if ($v == 'lec')
//                                        {
//                                                $lec = TRUE;
//                                        }
//                                        if ($v == 'lab')
//                                        {
//                                                $lab = TRUE;
//                                        }
//                                }

                                $sched_1_insert = array(
                                    'subject_offer_line_start'  => $this->input->post('start', TRUE),
                                    'subject_offer_line_end'    => $this->input->post('end', TRUE),
                                    'room_id'                   => $this->input->post('room', TRUE),
                                    'subject_id'                => $this->input->post('subject', TRUE),
                                    'user_id'                   => $this->input->post('faculty', TRUE),
                                    'subject_offer_id'          => $sub_offer_id,
                                    'subject_offer_semester'    => current_school_semester(TRUE),
                                    'subject_offer_school_year' => current_school_year(),
//                                    'subject_offer_line_lec'    => $lec,
//                                    'subject_offer_line_lab'    => $lab
                                );
                                foreach (days_for_db() as $d)
                                {
                                        $sched_1_insert['subject_offer_line_' . $d] = $this->input->post($d, TRUE);
                                }

                                $sched_id  = $this->Subject_offer_line_model->insert($sched_1_insert);
                                $sched_id2 = TRUE;

                                $include_validate_unit_sched2 = FALSE;
                                if ( ! ($exclude && ! empty($exclude)))
                                {
                                        $include_validate_unit_sched2 = TRUE;
//                                        $lec                          = FALSE;
//                                        $lab                          = FALSE;
//                                        foreach ($this->input->post('leclab2', TRUE) as $v)
//                                        {
//                                                if ($v == 'lec')
//                                                {
//                                                        $lec = TRUE;
//                                                }
//                                                if ($v == 'lab')
//                                                {
//                                                        $lab = TRUE;
//                                                }
//                                        }

                                        $sched_2_insert = array(
                                            'subject_offer_line_start'  => $this->input->post('start2', TRUE),
                                            'subject_offer_line_end'    => $this->input->post('end2', TRUE),
                                            'room_id'                   => $this->input->post('room2', TRUE),
                                            'subject_id'                => $this->input->post('faculty', TRUE),
                                            'user_id'                   => $this->input->post('subject', TRUE),
                                            'subject_offer_id'          => $sub_offer_id,
                                            'subject_offer_semester'    => current_school_semester(TRUE),
                                            'subject_offer_school_year' => current_school_year(),
//                                            'subject_offer_line_lec'    => $lec,
//                                            'subject_offer_line_lab'    => $lab
                                        );
                                        foreach (days_for_db() as $d)
                                        {
                                                $sched_2_insert['subject_offer_line_' . $d] = $this->input->post($d . '2', TRUE);
                                        }
                                        $sched_id2 = $this->Subject_offer_line_model->insert($sched_2_insert);
                                }
                                $unit_validated = $this->_is_time_hrs_equal_in_unit($include_validate_unit_sched2);
                                /**
                                 * checking if one of the insert is failed, either in [form validation] or in [syntax error] or [upload]
                                 */
                                if ( ! $unit_validated OR ! $sub_offer_id OR ! $sched_id OR ! $sched_id2 OR ! $validate_two_forms)
                                {
                                        /**
                                         * rollback database
                                         */
                                        $this->db->trans_rollback();
                                        $is_error = TRUE;
                                        if ( ! $validate_two_forms)
                                        {
                                                $this->session->set_flashdata('message', bootstrap_error('Conflict two forms.'));
                                        }
                                }
                                else
                                {
                                        if ($this->db->trans_commit())
                                        {
                                                $this->session->set_flashdata('message', bootstrap_success('create_subject_offer_succesfully_added_message'));
                                                redirect(site_url('create-subject-offer'), 'refresh');
                                        }
                                }
                        }
                        else
                        {
                                $is_error = TRUE;
                        }
                }
                $this->_form_view($is_error);
        }

        private function _is_time_hrs_equal_in_unit($sche2)
        {
                $this->load->helper('time');
                $subject_id = $this->input->post('subject', TRUE);
                //$unit_obj   = $this->Subject_model->get_leclab_hrs($subject_id);
                $unit_value = $this->Subject_model->get_unit($subject_id);

                $total_hrs_input = 0;
                if ($sche2)
                {
                        $total_hrs_input += $this->_get_hrs('2');
                }
                $total_hrs_input += $this->_get_hrs();

                $return = (bool) ($total_hrs_input === $unit_value);

                if ( ! $return)
                {
                        $this->session->set_flashdata('message', bootstrap_error('Schedule not meet require ' . strong($unit_value . ' hour(s)') . ', from your input ' . strong($total_hrs_input . ' hour(s)') . ', see curriculum for information.'));
                }
                return $return;
        }

        private function _get_hrs($arg = '')
        {

                $start = $this->input->post('start' . $arg, TRUE);
                $end   = $this->input->post('end' . $arg, TRUE);

                $sec = convert_24hrs_to_seconds($end) - convert_24hrs_to_seconds($start);
                return (int) gmdate("H", $sec);
        }

        #just in case
//        private function _unit_validator($unit, $arg = '')
//        {
//
//                $start = $this->input->post('start' . $arg, TRUE);
//                $end   = $this->input->post('end' . $arg, TRUE);
//
//                $sec = convert_24hrs_to_seconds($end) - convert_24hrs_to_seconds($start);
//                $hr  = (int) gmdate("H", $sec);
//
//                $lec          = $unit->lec;
//                $lab          = $unit->lab;
//                $lec_selected = FALSE;
//                $lab_selected = FALSE;
//                foreach ($this->input->post('leclab' . $arg, TRUE) as $v)
//                {
//                        if ($v == 'lec')
//                        {
//                                $lec_selected = TRUE;
//                        }
//                        if ($v == 'lab')
//                        {
//                                $lab_selected = TRUE;
//                        }
//                }
//
//
//                $lec_ok = TRUE;
//                $lab_ok = TRUE;
//                $msg    = '';
//                if ($lec_selected)
//                {
//                        $lec_ok = (bool) ($lec === $hr);
//                        if ( ! $lec_ok)
//                        {
//                                $msg .= ' LEC';
//                        }
//                }
//                if ($lab_selected)
//                {
//                        $lab_ok = (bool) ($lab === $hr);
//                        if ( ! $lab_ok)
//                        {
//                                $msg .= ' LAB';
//                        }
//                }
//                $return = (bool) ($lec_ok && $lab_ok);
//                if ( ! $return)
//                {
//                        $this->session->set_flashdata('message', bootstrap_error("Schedule$arg $msg reach maximum hour(s) limit, see curriculum for information."));
//                }
//                return $return;
//        }

        /**
         * check conflict in two forms
         * 
         * @return boolean
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _validate_two_shedules()
        {
                for ($i = 1; $i <= 2; $i ++)
                {
                        $tmp            = ($i === 1) ? '' : '2';
                        ${'sched' . $i} = array(
                            'start' => $this->input->post('start' . $tmp, TRUE),
                            'end'   => $this->input->post('end' . $tmp, TRUE),
                            'room'  => $this->input->post('room' . $tmp, TRUE)
                        );
                        foreach (days_for_db() as $d)
                        {
                                ${'sched' . $i}[$d] = (is_null($this->input->post($d . $tmp, TRUE)) ? 0 : 1);
                        }
                }
                $this->load->helper('validator');
                return is_not_conflict_subject_offer($sched1, $sched2);
        }

        /**
         * check conlict before add to database
         * 
         * will use this as callback
         * 
         * @param type $val
         * @param type $form_
         * @return type
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        public function subject_offer_check_check_conflict($val, $form_ = '')
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }//echo ' >' . $form_ . '< ';
                $this->load->helper('day');
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->library('subject_offer_validation');
                $this->subject_offer_validation->form_($form_);
                $this->subject_offer_validation->init('post');

                $conflic             = $this->subject_offer_validation->subject_offer_check_check_conflict();
                $this->data_conflict = $this->subject_offer_validation->conflict();

                if ($this->data_conflict)
                {
                        $inc        = 1;
                        $header     = array(
                            '#',
                            lang('index_subject_offer_start_th'),
                            lang('index_subject_offer_end_th'),
                            lang('index_subject_offer_days_th'),
                            lang('index_user_id_th'),
                            lang('index_subject_id_th'),
                            lang('index_room_id_th'),
                        );
                        $table_data = array();
                        foreach ($this->data_conflict as $subject_offer)
                        {
                                $user = $this->User_model->get($subject_offer->user_id);
                                array_push($table_data, array(
                                    $inc ++,
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_line_start)),
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_line_end)),
                                    my_htmlspecialchars(subject_offers_days($subject_offer)),
                                    my_htmlspecialchars($user->last_name . ', ' . $user->first_name),
                                    my_htmlspecialchars($this->Subject_model->get($subject_offer->subject_id)->subject_code),
                                    my_htmlspecialchars($this->Room_model->get($subject_offer->room_id)->room_number),
                                ));
                        }
                        $this->data['conflict_data' . $form_] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', $form_ . 'subject_offer_conflict_data', FALSE, TRUE);
                }
                $this->subject_offer_validation->reset__();
                return $conflic;
        }

        private function _form_view($is_error)
        {
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->helper(array('combobox', 'day'));

                /**
                 * 1st
                 */
                $this->data['subject_offer_start'] = array(
                    'name'  => 'start',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_start_label'
                );

                $this->data['subject_offer_end'] = array(
                    'name'  => 'end',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_end_label'
                );

                $this->data['days1'] = array(
                    'name'                       => 'days1',
                    'fields'                     => array(
                        'cal_sunday',
                        'cal_monday',
                        'cal_tuesday',
                        'cal_wednesday',
                        'cal_thursday',
                        'cal_friday',
                        'cal_saturday'
                    ),
                    'type'                       => 'checkbox',
                    'lang'                       => 'index_subject_offer_days_th',
                    //===
                    'value_is_one_name_is_label' => TRUE,
                    'append_name'                => ''
                );

                $this->data['room_id'] = array(
                    'name'  => 'room',
                    'value' => $this->Room_model->
                            as_dropdown('room_number')->
                            set_cache('as_dropdown_room_number')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_room_id_label'
                );

//                $this->data['leclab'] = array(
//                    'name'   => 'leclab[]',
//                    'fields' => array(//we used radio here 
//                        'lec' => 'create_type_lec_label',
//                        'lab' => 'create_type_lab_label'
//                    ),
//                    'value'  => $this->form_validation->set_value('leclab[]'),
//                    'type'   => 'checkbox',
//                    'lang'   => 'create_type_label'
//                );

                /**
                 * 2nd
                 */
                $this->data['subject_offer_start2'] = array(
                    'name'  => 'start2',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_start_label'
                );

                $this->data['subject_offer_end2'] = array(
                    'name'  => 'end2',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_end_label'
                );


                $this->data['room_id2'] = array(
                    'name'  => 'room2',
                    'value' => $this->Room_model->
                            as_dropdown('room_number')->
                            set_cache('as_dropdown_room_number')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_room_id_label'
                );

                $this->data['days2'] = array(
                    'name'                       => 'days2',
                    'fields'                     => array(
                        'cal_sunday',
                        'cal_monday',
                        'cal_tuesday',
                        'cal_wednesday',
                        'cal_thursday',
                        'cal_friday',
                        'cal_saturday'
                    ),
                    'type'                       => 'checkbox',
                    'lang'                       => 'index_subject_offer_days_th',
                    //===
                    'value_is_one_name_is_label' => TRUE,
                    'append_name'                => '2'
                );

//                $this->data['leclab2'] = array(
//                    'name'   => 'leclab2[]',
//                    'fields' => array(//we used radio here 
//                        'lec' => 'create_type_lec_label',
//                        'lab' => 'create_type_lab_label'
//                    ),
//                    'value'  => $this->form_validation->set_value('leclab2[]'),
//                    'type'   => 'checkbox',
//                    'lang'   => 'create_type_label'
//                );

                /**
                 * foreign
                 */
                $this->data['user_id'] = array(
                    'name'  => 'faculty',
                    'value' => $this->_faculties(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_user_id_label'
                );

                $this->data['subject_id'] = array(
                    'name'    => 'subject',
                    'value'   => $this->Subject_model->all_with_curriculum_for_dropdown('subject_code'),
                    'type'    => 'dropdown',
                    'lang'    => 'create_subject_id_label',
                    'default' => $this->input->get('subject-id')
                );


                $this->data['bootstrap'] = $this->_bootstrap();
                $this->data['err']       = $is_error;
                $this->render('admin/create_subject_offer', $this->data);
        }

        /**
         * 
         * @return array
         */
        private function _faculties()
        {
                /**
                 * create drop_down for <select></select>'s <option>
                 */
                $faculty_drop_down = array();

                /**
                 * get all user that has faculty group
                 */
                $faculties_obj = $this->ion_auth->users($this->config->item('user_group_faculty'))->result();

                /**
                 * convert to array with specific value id|full_name
                 */
                foreach ($faculties_obj as $f)
                {
                        $faculty_drop_down[$f->id] = $f->last_name . ', ' . $f->first_name;
                }
                return $faculty_drop_down;
        }

        private function _bootstrap()
        {
                /**
                 * for header
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/fullcalendar.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'css/jquery.gritter.css',
                        'css/jquery.gritter.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 */
                $footer       = array(
                    'css' => array(
                    ),
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
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '<script type="text/javascript">
        // This function is called from the pop-up menus to transfer to
        // a different page. Ignore if the value returned is a null string:
        function goPage(newURL) {

            // if url is empty, skip the menu dividers and reset the menu selection to default
            if (newURL != "") {

                // if url is "-", it is this page -- reset the menu:
                if (newURL == "-") {
                    resetMenu();
                }
                // else, send page to designated URL            
                else {
                    document.location.href = newURL;
                }
            }
        }

        // resets the menu selection upon entry to this page:
        function resetMenu() {
            document.gomenu.selector.selectedIndex = 2;
        }
</script>';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
