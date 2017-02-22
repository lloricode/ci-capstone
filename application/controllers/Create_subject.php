<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_subjects');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, 'Subjects', 'subjects');
                $this->breadcrumbs->unshift(3, 'Create Subjects', 'create-subject');
        }

        public function index()
        {
                /**
                 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                 *         
                 */
                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('create_subject_code_label'),
                        'field' => 'subject_code',
                        'rules' => 'trim|required|is_unique[subjects.subject_code]|min_length[3]|max_length[20]',
                    ),
                    array(
                        'label' => lang('create_subject_description_label'),
                        'field' => 'subject_description',
                        'rules' => 'trim|required|human_name|min_length[3]|max_length[50]',
                    ),
                    array(
                        'label' => lang('create_subject_unit_label'),
                        'field' => 'subject_unit',
                        'rules' => 'trim|required|is_natural_no_zero',
                    )
                ));

                if ($this->form_validation->run())
                {
                        $subject = array(
                            'subject_code'        => $this->input->post('subject_code', TRUE),
                            'subject_description' => $this->input->post('subject_description', TRUE),
                            'subject_unit'        => $this->input->post('subject_unit', TRUE),
                            'created_user_id'     => $this->ion_auth->user()->row()->id
                        );
                        $this->load->model('Subject_model');
                        if ($this->Subject_model->insert($subject))
                        {
                                $this->session->set_flashdata('message', $this->config->item('message_start_delimiter', 'ion_auth') . lang('create_subject_succesfully_added_message') . $this->config->item('message_end_delimiter', 'ion_auth'));
                                redirect(base_url('subjects'), 'refresh');
                                
                               
                        }
                }
                $this->load->model('Course_model');
                $this->load->helper('combobox');

                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


                $this->data['subject_code']        = array(
                    'name'  => 'subject_code',
                    'id'    => 'subject_code',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('subject_code'),
                );
                $this->data['subject_description'] = array(
                    'name'  => 'subject_description',
                    'id'    => 'subject_description',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('subject_description'),
                );
                $this->data['subject_unit']        = array(
                    'name'  => 'subject_unit',
                    'id'    => 'subject_unit',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('subject_unit'),
                );

                $this->data['bootstrap'] = $this->bootstrap();
                $this->_render_admin_page('admin/create_subject', $this->data);
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
