<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_student_subject extends CI_Capstone_Controller
{


        private $_session_name_;
        private $_sub_off__added_obj;

        function __construct()
        {
                parent::__construct();
                // $this->load->model('Room_model');
                $this->load->library('form_validation');
                $this->load->model('Student_model');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
                $this->breadcrumbs->unshift(2, lang('index_student_heading'), 'students');
                /**
                 * session name for curriculum_subjects

                 * to modify the session name, make sure also modify in MY_controller
                 * 
                 *   in constructor
                 */
                $this->_session_name_      = 'curriculum_subjects__subject_offer_ids';
                $this->_sub_off__added_obj = array();
        }

        public function index()
        {

                if ($this->input->post('submit'))
                {
//                        $id = $this->Room_model->from_form(NULL, array(
//                                    'created_user_id' => $this->session->userdata('user_id')
//                                ))->insert();
//                        if ($id)
//                        {
//                                redirect(site_url('rooms'), 'refresh');
//                        }
                }

                $this->_form_view();
        }

        private function _form_view()
        {
                $this->Student_model->set_informations($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, lang('add_student_subject_label'), 'create-student-subject?student-id=' . $this->student->id);


                $inputs['xx']                                   = array(
                    'name'  => 'xx',
                    'value' => $this->form_validation->set_value('xx'),
                    'type'  => 'text',
                    'lang'  => 'xx'
                );
                /**
                 * view the available subject from curriculum
                 */
                $this->data['student_subject_curriculum_table'] = $this->_subjects_from_curriculum_table_view();
                $this->data['added_subject_table']              = $this->_added_subject_table_view();

                if ($this->session->has_userdata($this->_session_name_))
                {
                        $this->data['reset_subject_offer_session'] = MY_Controller::_render('admin/_templates/button_view', array(
                                    'href'         => 'create-student-subject/reset-subject-offer-session?student-id=' . $this->student->id,
                                    'button_label' => 'reset subject offer session',
                                    'extra'        => array('class' => 'btn btn-success icon-edit'),
                                        ), TRUE);
                }
                $this->data['student_subject_form'] = $this->form_boostrap('create-student-subject', $inputs, 'add_student_subject_label', 'add_student_subject_label', 'info-sign', NULL, TRUE);
                $this->data['bootstrap']            = $this->_bootstrap();
                $this->_render('admin/create_student_subject', $this->data);
        }

        /**
         * unset session for subject offer 
         */
        public function reset_subject_offer_session()
        {
                if ($this->session->has_userdata($this->_session_name_))
                {
                        $this->session->unset_userdata($this->_session_name_);
                        $this->session->set_flashdata('message', 'reset done!');
                }
                redirect('create-student-subject?student-id=' . $this->input->get('student-id'), 'refresh');
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
                        $this->session->set_flashdata('message', 'removed done!');
                }
                redirect('create-student-subject?student-id=' . $this->input->get('student-id'), 'refresh');
        }

        private function _added_subject_table_view()
        {
                $cur_subj_obj = $this->_sub_off__added_obj;


                $table_data = array();

                $this->load->model(array('Curriculum_subject_model', 'Subject_model', 'Requisites_model'));
                if ($cur_subj_obj)
                {
                        $this->load->helper(array('day', 'time'));
                        //    print_r($cur_subj_obj);
                        foreach ($cur_subj_obj as $s)
                        {
                                if ( ! isset($s->subject_line))
                                {
                                        continue;
                                }

                                $output = array(
                                    $s->subject->subject_code,
                                    $s->faculty->first_name
                                );

                                $line = array();
                                $inc  = 0;
                                foreach ($s->subject_line as $su_l)
                                {
                                        $inc ++;
                                        $schd = array(
                                            subject_offers_days($su_l),
                                            convert_24_to_12hrs($su_l->subject_offer_line_start),
                                            convert_24_to_12hrs($su_l->subject_offer_line_end),
                                            $su_l->room->room_number
                                        );
                                        $line = array_merge($line, $schd);
                                }
                                if ($inc === 1)
                                {
                                        $line = array_merge($line, array('--', '--', '--', '--'));
                                }
                                $btn_link     = anchor(
                                        site_url('create-student-subject/unset-value-subject-offer-session?student-id=' . $this->student->id . '&subject-offer-id=' . $s->subject_offer_id), lang('remove_subjects_to_enroll')
                                );
                                $line         = array_merge($line, array($btn_link));
                                $table_data[] = array_merge($output, $line);
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
//                    'semester',
//                    lang('index_subject_id_th'),
//                    lang('index_subject_offer_start_th'),
//                    lang('index_subject_offer_end_th'),
//                    lang('index_subject_offer_days_th'),
//                    lang('index_room_id_th'),
//                    lang('index_user_id_th'),

                    'Subject',
                    'Faculty',
                    'Days1',
                    'Start1',
                    'End1',
                    'Room1',
                    'Days2',
                    'Start2',
                    'End2',
                    'Room2',
                    lang('remove_subjects_to_enroll')
                );

                return $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'added_subjects_to_enroll'/* lang in in students_lang */, FALSE, TRUE);
        }

        private function _subjects_from_curriculum_table_view()
        {
                $cur_subj_obj = $this->student->get_all_subject_available_to_enroll();
                /**
                 * check/add to session the subject_id from curriculum
                 */
                $this->_add_session_subjects();

                $table_data = array();

                $this->load->model(array('Curriculum_subject_model', 'Subject_model', 'Requisites_model'));
                if ($cur_subj_obj)
                {
                        $this->load->helper(array('day', 'time'));
                        //    print_r($cur_subj_obj);
                        foreach ($cur_subj_obj as $s)
                        {
                                if ( ! isset($s->subject_line))
                                {
                                        continue;
                                }
                                if ($this->_is_in_session($s->subject_offer_id))
                                {
                                        $this->_sub_off__added_obj[] = $s; //add to added object
                                        continue; //skip, already in session
                                }

                                $output = array(
                                    $s->subject->subject_code,
                                    $s->faculty->first_name
                                );

                                $line = array();
                                $inc  = 0;
                                foreach ($s->subject_line as $su_l)
                                {
                                        $inc ++;
                                        $schd = array(
                                            subject_offers_days($su_l),
                                            convert_24_to_12hrs($su_l->subject_offer_line_start),
                                            convert_24_to_12hrs($su_l->subject_offer_line_end),
                                            $su_l->room->room_number
                                        );
                                        $line = array_merge($line, $schd);
                                }
                                if ($inc === 1)
                                {
                                        $line = array_merge($line, array('--', '--', '--', '--'));
                                }
                                $btn_link     = anchor(
                                        site_url('create-student-subject?student-id=' . $this->student->id .
                                                '&subject-offer-id=' . $s->subject_offer_id), lang('add_student_subject_label')
                                );
                                $line         = array_merge($line, array($btn_link));
                                $table_data[] = array_merge($output, $line);
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
//                    'semester',
//                    lang('index_subject_id_th'),
//                    lang('index_subject_offer_start_th'),
//                    lang('index_subject_offer_end_th'),
//                    lang('index_subject_offer_days_th'),
//                    lang('index_room_id_th'),
//                    lang('index_user_id_th'),

                    'Subject',
                    'Faculty',
                    'Days1',
                    'Start1',
                    'End1',
                    'Room1',
                    'Days2',
                    'Start2',
                    'End2',
                    'Room2',
                    lang('add_student_subject_label')
                );

                return $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'available_subjects_to_enroll'/* lang in in students_lang */, FALSE, TRUE);
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
                 * skip is required id not found
                 */
                if ( ! $this->input->get('subject-offer-id'))
                {
                        return;
                }
                /**
                 * check the id
                 */
                $subject_offer_obj = check_id_from_url('subject_offer_id', 'Subject_offer_model', 'subject-offer-id');
                $subject_offer_id  = $subject_offer_obj->subject_offer_id;

                /**
                 * validate the subject if conflict with one value in session
                 */
                if ($this->_validate_subject($subject_offer_id))
                {
                        /**
                         * load the helper
                         */
                        $this->load->helper('session');
                        set_userdata_array($this->_session_name_, (string) $subject_offer_id, TRUE); //parameter TRUE to check unique valus on session array
                }


                // echo print_r($this->session->userdata($this->_session_name_));
        }

        /**
         * this will check the comflict in adding schedule,
         * 
         * @param type $subject_id
         * @return boolean
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _validate_subject($subject_id)
        {

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
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 */
                $footer = array(
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
