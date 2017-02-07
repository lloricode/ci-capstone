<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_group extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
        }

        public function index()
        {
                // validate form input
                $this->form_validation->set_rules(array(
                    array(
                        'label' => $this->lang->line('create_group_name_label'),
                        'field' => 'name',
                        'rules' => 'trim|required|alpha_dash',
                    ),
                    array(
                        'label' => $this->lang->line('create_group_desc_label'),
                        'field' => 'desc',
                        'rules' => 'trim|required',
                    )
                ));

                if ($this->form_validation->run())
                {
                        if ($this->ion_auth->create_group(
                                        $this->input->post('name', TRUE), $this->input->post('desc', TRUE)
                                ))
                        {
                                // redirect them back to the admin page
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect(current_url(), 'refresh');
                        }
                }

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->data['name']      = array(
                    'name'  => 'name',
                    'id'    => 'name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('name'),
                );
                $this->data['desc']      = array(
                    'name'  => 'desc',
                    'id'    => 'desc',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('desc'),
                );
                $this->data['bootstrap'] = $this->bootstrap();
                $this->_render_admin_page('admin/create_group', $this->data);
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
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
