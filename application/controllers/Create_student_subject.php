<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_student_subject extends CI_Capstone_Controller
{


        private $_session_name_;

        function __construct()
        {
                parent::__construct();
                // $this->load->model('Room_model');
                $this->load->library(array('form_validation', 'student'));
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
                $this->breadcrumbs->unshift(2, lang('index_student_heading'), 'students');
                /**
                 * session name for curriculum_subjects
                 */
                $this->_session_name_ = 'curriculum_subjects__subject_ids';
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
                $this->student->get($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, lang('add_student_subject_label'), 'create-student-subject?student-id=' . $this->student->id);


                $inputs['xx'] = array(
                    'name'  => 'xx',
                    'value' => $this->form_validation->set_value('xx'),
                    'type'  => 'text',
                    'lang'  => 'xx'
                );

                /**
                 * view the available subject from curriculum
                 */
                $this->data['student_subject_curriculum_table'] = $this->_subjects_from_curriculum_table_view($this->student->get_all_subject_available_to_enroll());

                $this->data['student_subject_form'] = $this->form_boostrap('create-student-subject', $inputs, 'add_student_subject_label', 'add_student_subject_label', 'info-sign', NULL, TRUE);
                $this->data['bootstrap']            = $this->_bootstrap();
                $this->_render('admin/create_student_subject', $this->data);
        }

        private function _subjects_from_curriculum_table_view($cur_subj)
        {
                /**
                 * check/add to session the subject_id from curriculum
                 */
                $this->_session_subjects();

                $table_data = array();

                if ($cur_subj)
                {
                        $this->load->model('Subject_offer_model');
                        $this->load->helper('time');
                        // echo print_r($cur_subj);
                        foreach ($cur_subj as $cur_subj_row)
                        {
                                if ($cur_subj_row->subject_offers)
                                {
                                        $temp_subject_id = NULL;
                                        foreach ($cur_subj_row->subject_offers as $subject_offer)
                                        {
                                                $sub_off         = $this->Subject_offer_model->
                                                        with_subject('order_inside:subject_code asc')->
                                                        with_room()->
                                                        with_faculty()->
                                                        get($subject_offer->subject_offer_id);
                                                array_push($table_data, array(
                                                    my_htmlspecialchars($sub_off->subject->subject_code),
                                                    my_htmlspecialchars(convert_24_to_12hrs($sub_off->subject_offer_start)),
                                                    my_htmlspecialchars(convert_24_to_12hrs($sub_off->subject_offer_end)),
                                                    my_htmlspecialchars(subject_offers_days($sub_off)),
                                                    my_htmlspecialchars($sub_off->room->room_number),
                                                    my_htmlspecialchars($sub_off->faculty->last_name . ', ' . $sub_off->faculty->first_name),
                                                    ($temp_subject_id != $sub_off->subject->subject_id) ?
                                                            //--
                                                            anchor(site_url('create-student-subject?student-id=' . $this->student->id . '&subject-id=' . $sub_off->subject->subject_id), lang('add_student_subject_label'))
                                                    //--
                                                            : '^^^'
                                                ));
                                                $temp_subject_id = $sub_off->subject->subject_id;
                                        }
                                }
                        }
                }

                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_subject_id_th'),
                    lang('index_subject_offer_start_th'),
                    lang('index_subject_offer_end_th'),
                    lang('index_subject_offer_days_th'),
                    lang('index_room_id_th'),
                    lang('index_user_id_th'),
                    lang('add_student_subject_label')
                );

                return $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_subject_heading_th', FALSE, TRUE);
        }

        private function _session_subjects()
        {
                /**
                 * check the id
                 */
                if ($subject_id = $this->input->get('subject-id'))
                {
                        /**
                         * load the helper
                         */
                        $this->load->helper('session');
                        /**
                         * validate the subject if conflict with one value in session
                         */
                        if ($this->_validate_subject($subject_id))
                        {
                                set_userdata_array($this->_session_name_, (string) $subject_id);
                        }
                }

                //echo print_r($this->session->userdata($this->_session_name_));
        }

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
