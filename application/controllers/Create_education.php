<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_education extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_educations');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
        }

        public function index()
        {

                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('create_education_code_label'),
                        'field' => 'education_code',
                        'rules' => 'trim|required|is_unique[educations.education_code]|min_length[3]|max_length[20]',
                    ),
                    array(
                        'label' => lang('create_education_description_label'),
                        'field' => 'education_description',
                        'rules' => 'trim|required|human_name|min_length[3]|max_length[50]',
                    )
                ));

                if ($this->form_validation->run())
                {
                        $education = array(
                            'education_code'        => $this->input->post('education_code', TRUE),
                            'education_description' => $this->input->post('education_description', TRUE),
                            'created_user_id'       => $this->ion_auth->user()->row()->id
                        );
                        $this->load->model('Education_model');
                        if ($this->Education_model->insert($education))
                        {
                                $this->session->set_flashdata('message', $this->config->item('message_start_delimiter', 'ion_auth') . lang('create_education_succesfully_added_message') . $this->config->item('message_end_delimiter', 'ion_auth'));
                                redirect(current_url(), 'refresh');
                        }
                }

                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


                $this->data['education_code']        = array(
                    'name'  => 'education_code',
                    'id'    => 'education_code',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('education_code'),
                );
                $this->data['education_description'] = array(
                    'name'  => 'education_description',
                    'id'    => 'education_description',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('education_description'),
                );

                $this->data['bootstrap'] = $this->bootstrap();
                $this->_render_admin_page('admin/create_education', $this->data);
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
