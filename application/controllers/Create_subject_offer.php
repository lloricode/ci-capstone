<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject_offer extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
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
                                $this->db->trans_start();

                                $subject_offer_insert = array(
                                    'user_id'                   => $this->input->post('faculty', TRUE),
                                    'subject_id'                => $this->input->post('subject', TRUE),
                                    'subject_offer_semester'    => current_school_semester(TRUE),
                                    'subject_offer_school_year' => current_school_year()
                                );
                                $sub_offer_id         = $this->Subject_offer_model->insert($subject_offer_insert);


                                $sched_1_insert = array(
                                    'subject_offer_line_start'  => $this->input->post('start', TRUE),
                                    'subject_offer_line_end'    => $this->input->post('end', TRUE),
                                    'room_id'                   => $this->input->post('room', TRUE),
                                    'subject_id'                => $this->input->post('subject', TRUE),
                                    'user_id'                   => $this->input->post('faculty', TRUE),
                                    'subject_offer_id'          => $sub_offer_id,
                                    'subject_offer_semester'    => current_school_semester(TRUE),
                                    'subject_offer_school_year' => current_school_year()
                                );
                                foreach (days_for_db() as $d)
                                {
                                        $sched_1_insert['subject_offer_line_' . $d] = $this->input->post($d, TRUE);
                                }

                                $sched_id  = $this->Subject_offer_line_model->insert($sched_1_insert);
                                $sched_id2 = TRUE;
                                if ( ! ($exclude && ! empty($exclude)))
                                {
                                        $sched_2_insert = array(
                                            'subject_offer_line_start'  => $this->input->post('start2', TRUE),
                                            'subject_offer_line_end'    => $this->input->post('end2', TRUE),
                                            'room_id'                   => $this->input->post('room2', TRUE),
                                            'subject_id'                => $this->input->post('faculty', TRUE),
                                            'user_id'                   => $this->input->post('subject', TRUE),
                                            'subject_offer_id'          => $sub_offer_id,
                                            'subject_offer_semester'    => current_school_semester(TRUE),
                                            'subject_offer_school_year' => current_school_year()
                                        );
                                        foreach (days_for_db() as $d)
                                        {
                                                $sched_2_insert['subject_offer_line_' . $d] = $this->input->post($d . '2', TRUE);
                                        }
                                        $sched_id2 = $this->Subject_offer_line_model->insert($sched_2_insert);
                                }
                                //   echo print_r($sched_12_insert);
                                /**
                                 * checking if one of the insert is failed, either in [form validation] or in [syntax error] or [upload]
                                 */
                                if ( ! $sub_offer_id OR ! $sched_id OR ! $sched_id2 OR ! $validate_two_forms)
                                {
                                        echo 'roolback__';
                                        /**
                                         * rollback database
                                         */
                                        $this->db->trans_rollback();
                                        if ( ! $validate_two_forms)
                                        {
                                                $data['two_forms_conflict_message'] = '<h5 style="color:red">Conflict two forms.</h5>';
                                        }
                                }
                                else
                                {
                                        if ($this->db->trans_commit())
                                        {
                                                //echo 'done';
                                                $this->session->set_flashdata('message', lang('create_subject_offer_succesfully_added_message'));
                                                redirect(site_url('create-subject-offer'), 'refresh');
                                        }
                                }
                        }
                }
                $this->_form_view();
        }

        /**
         * check conflict in two forms
         * 
         * @return boolean
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _validate_two_shedules()
        {
                $sched1 = array(
                    'start' => $this->input->post('start', TRUE),
                    'end'   => $this->input->post('end', TRUE),
                    'room'  => $this->input->post('room', TRUE)
                );
                foreach (days_for_db() as $d)
                {
                        $sched1[$d] = (is_null($this->input->post($d, TRUE)) ? 0 : 1);
                }
                //------------------------
                $sched2 = array(
                    'start' => $this->input->post('start2', TRUE),
                    'end'   => $this->input->post('end2', TRUE),
                    'room'  => $this->input->post('room2', TRUE)
                );
                foreach (days_for_db() as $d)
                {
                        $sched2[$d] = (is_null($this->input->post($d . '2', TRUE)) ? 0 : 1);
                }
//                if (
//                        ($sched1['monday'] == $sched2['monday'] && 1 == $sched2['monday'] ) OR
//                        ($sched1['tuesday'] == $sched2['tuesday'] && 1 == $sched2['tuesday']) OR
//                        ($sched1['wednesday'] == $sched2['wednesday'] && 1 == $sched2['wednesday']) OR
//                        ($sched1['thursday'] == $sched2['thursday'] && 1 == $sched2['thursday']) OR
//                        ($sched1['friday'] == $sched2['friday'] && 1 == $sched2['friday']) OR
//                        ($sched1['saturday'] == $sched2['saturday'] && 1 == $sched2['saturday']) OR
//                        ($sched1['sunday'] == $sched2['sunday'] && 1 == $sched2['sunday'])
//                )
//                {
//                        echo 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
//                }
                if (
                //--
                        (//big start
                        //1
                        ($sched1['start'] <= $sched2['start'] &&
                        $sched1['start'] <= $sched2['end'] &&
                        $sched1['end'] > $sched2['start'] &&
                        $sched1['end'] <= $sched2['end'])
                        //--
                        OR
                        //2
                        ( $sched1['start'] >= $sched2['start'] &&
                        $sched1['start'] < $sched2['end'] &&
                        $sched1['end'] >= $sched2['start'] &&
                        $sched1['end'] >= $sched2['end'])
                        //--
                        OR
                        //3
                        ( $sched1['start'] <= $sched2['start'] &&
                        $sched1['start'] < $sched2['end'] &&
                        $sched1['end'] > $sched2['start'] &&
                        $sched1['end'] >= $sched2['end'])
                        //--
                        OR
                        //4
                        ( $sched1['start'] >= $sched2['start'] &&
                        $sched1['start'] < $sched2['end'] &&
                        $sched1['end'] > $sched2['start'] &&
                        $sched1['end'] <= $sched2['end'])
                        //--
                        )//big end
                        //--
                        &&
                        //days
                        (
                        ($sched1['monday'] == $sched2['monday'] && 1 == $sched2['monday'] ) OR ( $sched1['tuesday'] == $sched2['tuesday'] && 1 == $sched2['tuesday']) OR ( $sched1['wednesday'] == $sched2['wednesday'] && 1 == $sched2['wednesday']) OR ( $sched1['thursday'] == $sched2['thursday'] && 1 == $sched2['thursday']) OR ( $sched1['friday'] == $sched2['friday'] && 1 == $sched2['friday']) OR ( $sched1['saturday'] == $sched2['saturday'] && 1 == $sched2['saturday']) OR ( $sched1['sunday'] == $sched2['sunday'] && 1 == $sched2['sunday'])
                        )
                )
                {
                        return FALSE;
                }
                return TRUE;
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
                $conflic = $this->subject_offer_validation->subject_offer_check_check_conflict();
//                if ($conflic)
//                {
//                        echo 'tReu';
//                }
//                else
//                {
//                        echo 'flase';
//                }
                $data    = $this->subject_offer_validation->conflict();
                if ($data)
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
                        foreach ($data as $subject_offer)
                        {//echo print_r($subject_offer);
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
                        $data['conflict_data' . $form_] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', $form_ . 'subject_offer_conflict_data', FALSE, TRUE);
                }
                $this->subject_offer_validation->reset__();
                return $conflic;
        }

        private function _form_view()
        {
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->helper(array('combobox', 'day'));

                /**
                 * 1st
                 */
                $data['subject_offer_start'] = array(
                    'name'  => 'start',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_start_label'
                );

                $data['subject_offer_end'] = array(
                    'name'  => 'end',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_end_label'
                );


                $data['room_id']              = array(
                    'name'  => 'room',
                    'value' => $this->Room_model->
                            as_dropdown('room_number')->
                            set_cache('as_dropdown_room_number')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_room_id_label'
                );
                /**
                 * 2nd
                 */
                $data['subject_offer_start2'] = array(
                    'name'  => 'start2',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_start_label2'
                );

                $data['subject_offer_end2'] = array(
                    'name'  => 'end2',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_end_label2'
                );


                $data['room_id2'] = array(
                    'name'  => 'room2',
                    'value' => $this->Room_model->
                            as_dropdown('room_number')->
                            set_cache('as_dropdown_room_number')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_room_id_label2'
                );


                /**
                 * foreign
                 */
                $data['user_id'] = array(
                    'name'  => 'faculty',
                    'value' => $this->_faculties(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_user_id_label'
                );

                $data['subject_id'] = array(
                    'name'  => 'subject',
                    'value' => $this->Subject_model->
                            as_dropdown('subject_code')->
                            set_cache('as_dropdown_subject_code')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_id_label'
                );

                /**
                 * for check box
                 */
                $data['days'] = days_for_db();

                $data['bootstrap'] = $this->_bootstrap();
                $this->render('admin/create_subject_offer', $data);
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
                $faculties_obj = $this->ion_auth->users('faculty')->result();

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
