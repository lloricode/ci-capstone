<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 
 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
 *         
 */

class Create_curriculum extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Curriculum_model', 'Course_model'));
                $this->load->library('form_validation');
                $this->load->helper('school');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
                $this->breadcrumbs->unshift(3, lang('create_curriculum_label'), 'create-curriculum');
        }

        public function index()
        {
                if ($this->input->post('submit'))
                {
                        $id = $this->Curriculum_model->from_form(NULL, array(
                                    'created_user_id' => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                $this->session->set_flashdata('message', 'Curriculum Added!');
                                redirect(site_url('curriculums'), 'refresh');
                        }
                }
                $this->_form_view();
        }

        private function _form_view()
        {

                $inputs['curriculum_description'] = array(
                    'name'  => 'desc',
                    'value' => $this->form_validation->set_value('desc'),
                    'type'  => 'textarea',
                    'lang'  => 'curriculumn_description'
                );

                $inputs['curriculum_effective_school_year'] = array(
                    'name'  => 'year',
                    'value' => school_years(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculumn_effective_year'
                );

                $inputs['course_id'] = array(
                    'name'  => 'course',
                    'value' => $this->Course_model->
                            as_dropdown('course_code')->
                            set_cache('as_dropdown_course_code')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculumn_course'
                );

//                $inputs['curriculum_status'] = array(
//                    'name'   => 'status',
//                    'fields' => array(//we used checkbox here 
//                        'enable' => array(
//                            'label' => lang('curriculumn_status_enable'),
//                            'value' => TRUE
//                        ),
//                    ),
//                    'value'  => $this->form_validation->set_value('status'),
//                    'type'   => 'checkbox',
//                    'lang'   => 'curriculumn_status'
//                );


                $this->data['curriculum_form'] = $this->form_boostrap('create-curriculum', $inputs, 'create_curriculum_label', 'curriculumn_create_button', 'info-sign', NULL, TRUE);
                $this->data['bootstrap']       = $this->_bootstrap();
                $this->render('admin/create_curriculum', $this->data);
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
