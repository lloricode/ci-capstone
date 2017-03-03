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
                $this->breadcrumbs->unshift(3, lang('curriculum_subject_label'), 'curriculum-subjects');
                $this->breadcrumbs->unshift(4, lang('create_curriculum_subject_label'), 'create-curriculum-subject');
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
                                redirect(site_url('curriculum-subjects'), 'refresh');
                        }
                }
                $this->_form_view();
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
                $return[NULL]     = 'no subject';
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
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


                $this->data['curriculum_subject_semester'] = array(
                    'name'  => 'semester',
                    'value' => semesters(),
                );


                $this->data['curriculum_subject_units'] = array(
                    'name'  => 'units',
                    'value' => _numbers_for_drop_down(1, 8),
                );


                $this->data['curriculum_subject_lecture_hours'] = array(
                    'name'  => 'lecture',
                    'value' => _numbers_for_drop_down(1, 8),
                );


                $this->data['curriculum_subject_laboratory_hours'] = array(
                    'name'  => 'laboratory',
                    'value' => _numbers_for_drop_down(1, 8),
                );


                $this->data['curriculum_id'] = array(
                    'name'  => 'curriculum',
                    'value' => $this->_dropdown_for_curriculumn()
                );




                $this->data['subject_id'] = array(
                    'name'  => 'subject',
                    'value' => $this->_dropdown_for_subjects()
                );


                $this->data['subject_id_pre'] = array(
                    'name'  => 'pre_requisite',
                    'value' => $this->_dropdown_for_subjects()
                );


                $this->data['subject_id_co'] = array(
                    'name'  => 'co_requisite',
                    'value' => $this->_dropdown_for_subjects()
                );



                $this->data['bootstrap'] = $this->bootstrap();
                $this->_render('admin/create_curriculum_subject', $this->data);
        }

        private function bootstrap()
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
