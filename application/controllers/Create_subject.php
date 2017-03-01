<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model('Subject_model');
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
                if ($this->input->post('submit'))
                {
                        $id = $this->Subject_model->from_form(NULL, array(
                                    'created_user_id' => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                redirect(site_url('subjects'), 'refresh');
                        }
                }

                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


                $this->data['subject_code']        = array(
                    'name'  => 'code',
                    'id'    => 'code',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('code'),
                );
                $this->data['subject_description'] = array(
                    'name'  => 'desc',
                    'id'    => 'desc',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('desc'),
                );
//                $this->data['subject_unit']        = array(
//                    'name'  => 'unit',
//                    'id'    => 'unit',
//                    'type'  => 'text',
//                    'value' => $this->form_validation->set_value('unit'),
//                );

                $this->data['bootstrap'] = $this->bootstrap();
                $this->_render('admin/create_subject', $this->data);
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
