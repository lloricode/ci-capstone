<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
 *         
 */
class Create_curriculum_subject extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Curriculum_subject_model', 'Curriculum_model', 'Subject_model', 'Course_model'));
                $this->load->library('form_validation');
                $this->load->helper(array('school', 'combobox'));
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
        }

        public function index()
        {
                $curriculum_obj = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id', 'course');

                if ($curriculum_obj->curriculum_status)
                {
                        show_error('Already Enabled');
                }
                if ($curriculum_obj->curriculum_already_used)
                {
                        show_error('Edit is not allowed, Already been used by other data.');
                }

                $this->breadcrumbs->unshift(3, lang('curriculum_subject_label'), 'curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id);
                $this->breadcrumbs->unshift(4, lang('create_curriculum_subject_label') . ' [ ' . $curriculum_obj->course->course_code . ' ]', 'create-curriculum-subject?curriculum-id=' . $curriculum_obj->curriculum_id);


                if ($this->input->post('submit', TRUE))
                {
                        /**
                         * start the DB transaction
                         */
                        $this->db->trans_begin();

                        $id = $this->Curriculum_subject_model->from_form(NULL, array(
                                    'curriculum_id' => $curriculum_obj->curriculum_id
                                ))->insert();

                        if ( ! $this->_is_subject_course($curriculum_obj->curriculum_id) OR ! $id)
                        {
                                /**
                                 * rollback database
                                 */
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', bootstrap_error('curriculum_subject_add_unsuccessfull'));
                        }
                        else
                        {
                                if ($this->db->trans_commit())
                                {

                                        $this->session->set_flashdata('message', bootstrap_success('curriculum_subject_add_successfull'));
                                        redirect(site_url('curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id), 'refresh');
                                }
                        }
                }
                $this->_form_view($curriculum_obj);
        }

        /**
         * 
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _is_subject_course($curriculum_id)
        {

                $subject_id = $this->input->post('subject', TRUE);

                //select what course_id from subject ELSE GEN-ED
                $subj_obj = $this->Subject_model->get($subject_id);

                // if (is_null($subj_obj->course_id))
                if ($subj_obj->course_id == 0)
                {
//                        $this->session->set_flashdata('message', bootstrap_success(' well done! GEN ED '));
//                        return FALSE; //test return

                        return TRUE;
                }
                $course_id_1 = $subj_obj->course_id;

                //selest what course_id from curriculum
                $course_id_2 = $this->Curriculum_model->get($curriculum_id)->course_id;

                if ($course_id_1 != $course_id_2)
                {
                        $this->session->set_flashdata('message', bootstrap_error('Not the same course.'));
                        return FALSE;
                }
                return TRUE;
//                $this->session->set_flashdata('message', bootstrap_success(' well done! COURSE'));
//                return FALSE; //test return
        }

        /**
         * check if LEC plus LAB is equal to UNIT
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         * @param type $value
         */
        public function unit_relate_types($value)
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }
                $value = (int) $value;
                $lec   = (int) $this->input->post('lecture', TRUE);
                $lab   = (int) $this->input->post('laboratory', TRUE);
                $this->form_validation->set_message('unit_relate_types', lang('validation_unit_relate_types_failed'));
                return (bool) (($lec + $lab) === $value);
        }

        /**
         * check if subject is exist in curriculum
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function check_subject_in_curiculum()
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }
                $this->form_validation->set_message('check_subject_in_curiculum', 'Subject Already Added in this Curriculum.');
                return (bool) $this->Curriculum_subject_model->where(array(
                            'subject_id'    => $this->input->post('subject'),
                            'curriculum_id' => $this->input->post('curriculum')
                        ))->count_rows() == 0;
        }

        private function _dropdown_for_subjects()
        {

                $where_course = NULL;
                $string_query = FALSE;
                if ($curr_id      = $this->input->get('curriculum-id'))
                {
                        $course_id    = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id')->course_id;
                        $where_course = "`course_id` = '$course_id' OR `course_id` = '0' ";
                        $string_query = TRUE;
                }


                $return       = array();
                $return[NULL] = 'no subject';
                $subjects_obj = $this->Subject_model->
                        where($where_course, NULL, NULL, FALSE, FALSE, $string_query)->
                        as_dropdown('subject_code')->
                        order_by('course_id', 'DESC')->
                        set_cache('as_dropdown_subject_code')->
                        get_all();

                if ($subjects_obj)
                {
                        foreach ($subjects_obj as $k => $v)
                        {
                                $return[$k] = $v;
                        }
                }

                return $return; // array_merge(array('' => 'no subject'), (array) $subjects_obj);
        }

        private function _form_view($curriculum_obj)
        {

                $inputs['subject_id'] = array(
                    'name'  => 'subject',
                    'value' => $this->_dropdown_for_subjects(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_subject_label',
                        // 'note'  => 'Requisites is on the next form after submit this current form.'
                );

                $inputs['curriculum_subject_year_level'] = array(
                    'name'  => 'level',
                    'value' => _numbers_for_drop_down(1, 4),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_year_level_label',
                );

                $inputs['curriculum_subject_semester'] = array(
                    'name'  => 'semester',
                    'value' => semesters(FALSE),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_semester_label'
                );

                $inputs['curriculum_subject_lecture_hours'] = array(
                    'name'  => 'lecture',
                    'value' => _numbers_for_drop_down(0, 5),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_lecture_hours_label'
                );

                $inputs['curriculum_subject_laboratory_hours'] = array(
                    'name'  => 'laboratory',
                    'value' => _numbers_for_drop_down(0, 9),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_laboratory_hours_label'
                );

                $inputs['curriculum_subject_units'] = array(
                    'name'  => 'units',
                    'value' => _numbers_for_drop_down(1, 6),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_units_label'
                );

                $template['curriculum_information']  = MY_Controller::render('admin/_templates/curriculums/curriculum_information', array('curriculum_obj' => $curriculum_obj), TRUE);
                $template['curriculum_subject_form'] = $this->form_boostrap('create-curriculum-subject?curriculum-id=' . $curriculum_obj->curriculum_id, $inputs, 'create_curriculum_subject_label', 'create_curriculum_subject_label', 'info-sign', NULL, TRUE);
                $template['bootstrap']               = $this->_bootstrap();
                $this->render('admin/create_curriculum_subject', $template);
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
