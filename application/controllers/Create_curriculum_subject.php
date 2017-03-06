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
                $this->breadcrumbs->unshift(3, lang('create_curriculum_subject_label'), 'create-curriculum-subject');
        }

        public function index()
        {
                if ($this->input->post('submit'))
                {
                        $id = $this->Curriculum_subject_model->from_form(NULL, array(
                                    'created_user_id' => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                $this->session->set_flashdata('message', lang('curriculum_subject_add_successfull'));
                                redirect(site_url('curriculums/view?curriculum-id=' . $this->input->post('curriculum')), 'refresh');
                        }
                }
                $this->_form_view();
        }

        /**
         * check if subject is exist in curriculum
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function check_subject_in_curiculum()
        {
                if (!$this->input->post('submit'))
                {
                        show_404();
                }
                $this->form_validation->set_message('check_subject_in_curiculum', 'Subject Already Added in this Curriculum.');
                return (bool) $this->Curriculum_subject_model->where(array(
                            'subject_id'    => $this->input->post('subject'),
                            'curriculum_id' => $this->input->post('curriculum')
                        ))->count_rows() == 0;
        }

        /**
         * check if adding Requisite is the same year level
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function is_co_requisite_same_level()
        {
                if (!$this->input->post('submit'))
                {
                        show_404();
                }


                $input_year_level = $this->input->post('level', TRUE);
                $co_requisite     = $this->input->post('co_requisite', TRUE);
                $curriculum_id    = $this->input->post('curriculum', TRUE);
                $semester         = $this->input->post('semester', TRUE);

                /**
                 * required first all the other field to be filled, it will validate first
                 */
                if ($input_year_level && $co_requisite && $semester)
                {
                        /**
                         * get row in $co_requisite in current curriculum
                         */
                        $cur_sub_obj = $this->Curriculum_subject_model->where(array(
                                    //main subject search by co-requisite , to get the year level of input co requsite using the exist subject in curiculum
                                    'subject_id'    => $co_requisite,
                                    'curriculum_id' => $curriculum_id // search in curiculum input
                                ))->set_cache("curriculum_subject_validation_{$co_requisite}_{$curriculum_id}")->get();

                        /**
                         * if has, check the year level of $pre_requisite
                         */
                        if ($cur_sub_obj)
                        {
                                /**
                                 * check if same year level, with input and the result OBJ->year level in model
                                 */
                                if ($cur_sub_obj->curriculum_subject_year_level == $input_year_level)
                                {
                                        /**
                                         * validation pass, so lets also check semester
                                         */
                                        if ($cur_sub_obj->curriculum_subject_semester == $semester)
                                        {
                                                /**
                                                 * accepted
                                                 */
                                                return TRUE;
                                        }
                                        /**
                                         * return FALSE, because, because is not at same semester
                                         */
                                        $this->form_validation->set_message('is_co_requisite_same_level', 'Adding "{field}" must also in same semester.');
                                        return FALSE;
                                }
                                /**
                                 * return FALSE, because, it detect that has a subject BUT not same level
                                 */
                                $this->form_validation->set_message('is_co_requisite_same_level', 'Adding "{field}" must same in current year level.');
                                return FALSE;
                        }
                        /**
                         * no result so no conflict
                         */
                        return TRUE;
                }
                /**
                 * not required, just pass the validation
                 */
                return TRUE;
        }

        /**
         * check if adding Requisite is in low year level
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function is_pre_requisite_low_level()
        {
                if (!$this->input->post('submit'))
                {
                        show_404();
                }


                $input_year_level = $this->input->post('level', TRUE);
                $pre_requisite    = $this->input->post('pre_requisite', TRUE);
                $curriculum_id    = $this->input->post('curriculum', TRUE);
                $semester         = $this->input->post('semester', TRUE);

                /**
                 * required first all the other field to be filled, it will validate first
                 */
                if ($input_year_level && $pre_requisite && $semester)
                {
                        /**
                         * check if  $pre_requisite exist in current curriculum
                         */
                        $cur_sub_obj = $this->Curriculum_subject_model->where(array(
                                    //main subject search by $pre_requisite , to get the year level of input co requsite using the exist subject in curiculum
                                    'subject_id'    => $pre_requisite,
                                    'curriculum_id' => $curriculum_id
                                ))->get();

                        /**
                         * if has, check the yeal level of $pre_requisite
                         */
                        if ($cur_sub_obj)
                        {
                                /**
                                 * check lower year, i use == to include semester, 
                                 */
                                if ($cur_sub_obj->curriculum_subject_year_level <= $input_year_level)
                                {

                                        $int_semester_db    = $this->_numeric_semester($cur_sub_obj->curriculum_subject_semester);
                                        $int_semester_input = $this->_numeric_semester($semester);

                                        if ($int_semester_db < $int_semester_input || $int_semester_input == 1)//no lower year than 1
                                        {
                                                /**
                                                 * accepted
                                                 */
                                                return TRUE;
                                        }
                                        /**
                                         * return FALSE, because,not lower in semester
                                         */
                                        $this->form_validation->set_message('is_pre_requisite_low_level', 'Adding "{field}"\'s year must in lower in semester.');
                                        return FALSE;
                                }
                                /**
                                 * return FALSE, because, it detect that has a subject BUT not lower/equal level
                                 */
                                $this->form_validation->set_message('is_pre_requisite_low_level', 'Adding "{field}"\'s year must in lower/equal in current year level.');
                                return FALSE;
                        }
                        /**
                         * no result so no conflict
                         */
                        return TRUE;
                }
                /**
                 * not required
                 */
                return TRUE;
        }

        private function _numeric_semester($tmp)
        {
                $int_semester = NULL;
                switch ($tmp)
                {
                        case 'first':
                                $int_semester = 1;
                                break;
                        case 'second':
                                $int_semester = 2;
                                break;
                        case 'summer':
                                $int_semester = 3;
                                break;
                        default: break;
                }
                return $int_semester;
        }

        private function _dropdown_for_curriculumn()
        {
                $return = array();

                $cur_obj = $this->Curriculum_model->
                        set_cache('as_dropdown_subject_code')->
                        get_all();

                if ($cur_obj)
                {
                        foreach ($cur_obj as $v)
                        {
                                $semester                  = semesters($v->curriculum_effective_semester);
                                $course_code               = $this->Course_model->
                                                set_cache('course_' . $v->course_id)->
                                                get($v->course_id)->
                                        course_code;
                                $return[$v->curriculum_id] = $v->curriculum_effective_school_year . ' | ' .
                                        $semester . ' | ' .
                                        $course_code . ' | ' .
                                        $v->curriculum_description;
                        }
                }
                return $return;
        }

        private function _dropdown_for_subjects()
        {
                $return       = array();
                $return[NULL] = 'no subject';
                $subjects_obj = $this->Subject_model->
                        as_dropdown('subject_code')->
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

        private function _form_view()
        {

                $inputs['curriculum_id'] = array(
                    'name'    => 'curriculum',
                    'value'   => $this->_dropdown_for_curriculumn(),
                    'type'    => 'dropdown',
                    'lang'    => 'curriculum_subject_curriculum_label',
                    'default' => $this->input->get('curriculum-id')//directly, if not found will return NULL
                );

                $inputs['subject_id'] = array(
                    'name'  => 'subject',
                    'value' => $this->_dropdown_for_subjects(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_subject_label'
                );

                $inputs['subject_id_pre'] = array(
                    'name'  => 'pre_requisite',
                    'value' => $this->_dropdown_for_subjects(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_pre_subject_label'
                );

                $inputs['subject_id_co'] = array(
                    'name'  => 'co_requisite',
                    'value' => $this->_dropdown_for_subjects(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_co_subject_label'
                );

                $inputs['curriculum_subject_semester']   = array(
                    'name'  => 'semester',
                    'value' => semesters(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_semester_label',
                );
                $inputs['curriculum_subject_year_level'] = array(
                    'name'  => 'level',
                    'value' => _numbers_for_drop_down(1, $this->config->item('max_year_level')),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_year_level_label'
                );

                $inputs['curriculum_subject_lecture_hours'] = array(
                    'name'  => 'lecture',
                    'value' => _numbers_for_drop_down(1, 8),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_lecture_hours_label'
                );

                $inputs['curriculum_subject_laboratory_hours'] = array(
                    'name'  => 'laboratory',
                    'value' => _numbers_for_drop_down(1, 8),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_laboratory_hours_label'
                );

                $inputs['curriculum_subject_units'] = array(
                    'name'  => 'units',
                    'value' => _numbers_for_drop_down(1, 8),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_units_label'
                );

                $this->data['curriculum_subject_form'] = $this->form_boostrap('create-curriculum-subject', $inputs, NULL, 'create_curriculum_subject_label', 'create_curriculum_subject_label', 'info-sign', NULL, TRUE);
                $this->data['bootstrap']               = $this->_bootstrap();
                $this->_render('admin/create_curriculum_subject', $this->data);
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
