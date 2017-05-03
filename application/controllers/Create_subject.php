<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Subject_model', 'Unit_model'));
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
                $this->breadcrumbs->unshift(3, lang('create_subject_heading'), 'create-subject');
        }

        public function index()
        {
                /**
                 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                 *         
                 */
                $this->form_validation->set_rules($this->Subject_model->insert_validation());

                if ($this->form_validation->run())
                {
                        $this->db->trans_begin();

                        $unit_ok   = TRUE;
                        $unit_id   = TRUE;
                        $course_id = NULL;

                        $subj_insert = array(
                            'subject_code'        => $this->input->post('code', TRUE),
                            'subject_description' => $this->input->post('description', TRUE),
                        );

                        //check if gen-ed,then add form set rule and validate it,else nothing
                        if (((string) $this->input->post('course', TRUE) ) === '0')
                        {
                              //  $this->form_validation->reset_validation();
                                $this->form_validation->set_rules($this->Unit_model->insert_validation());
                                $unit_ok = $this->form_validation->run();
                                if ($unit_ok)
                                {
                                        $unit_id = $this->Unit_model->insert(array(
                                            'unit_value' => $this->input->post('units', TRUE),
                                            'lec_value'  => $this->input->post('lecture', TRUE),
                                            'lab_value'  => $this->input->post('laboratory', TRUE)
                                        ));
                                }
                                if ($unit_id)
                                {
                                        $subj_insert['unit_id'] = $unit_id;
                                }
                        }
                        else
                        {
                                $subj_insert['course_id'] = $this->input->post('course', TRUE);
                        }

                        $ubject_id = $this->Subject_model->insert($subj_insert);



                        if ( ! $ubject_id OR ! $unit_id OR ! $unit_ok)
                        {
                                /**
                                 * rollback database
                                 */
                                $this->db->trans_rollback();
                        }
                        else
                        {
                                if ($this->db->trans_commit())
                                {
                                        $this->session->set_flashdata('message', bootstrap_success('create_subject_succesfully_added_message'));
                                        redirect(site_url('subjects'), 'refresh');
                                }
                        }
                }


                $this->_form_view();
        }

        private function _form_view()
        {
                $inputs['subject_code'] = array(
                    'name'  => 'code',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('code'),
                    'lang'  => 'create_subject_code_label',
                );

                $inputs['subject_description'] = array(
                    'name'  => 'description',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('description'),
                    'lang'  => 'create_subject_description_label'
                );

                $this->load->model('Course_model');
                $inputs['course_id'] = array(
                    'name'  => 'course',
                    'value' => $this->Course_model->drpdown_with_gen_ed(),
                    'type'  => 'dropdown',
                    'lang'  => 'index_course_heading'
                );

                $this->load->helper('combobox');
                $inputs['curriculum_subject_lecture_hours'] = array(
                    'name'  => 'lecture',
                    'value' => _numbers_for_drop_down(0, 5),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_lecture_hours_label',
                    'note'  => 'require when program in GEN-ED'
                );

                $inputs['curriculum_subject_laboratory_hours'] = array(
                    'name'  => 'laboratory',
                    'value' => _numbers_for_drop_down(0, 9),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_laboratory_hours_label',
                    'note'  => 'require when program in GEN-ED'
                );

                $inputs['curriculum_subject_units'] = array(
                    'name'  => 'units',
                    'value' => _numbers_for_drop_down(1, 6),
                    'type'  => 'dropdown',
                    'lang'  => 'curriculum_subject_units_label',
                    'note'  => 'require when program in GEN-ED'
                );

                $data['subject_form'] = $this->form_boostrap('create-subject', $inputs, 'create_subject_heading', 'create_subject_submit_button_label', 'info-sign', NULL, TRUE);
                $data['bootstrap']    = $this->_bootstrap();
                $this->render('admin/create_subject', $data);
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
