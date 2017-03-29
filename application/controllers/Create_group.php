<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_group extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                /**
                 * just to make sure
                 */
                if ( ! $this->ion_auth->is_admin())
                {
                        show_error(lang('access_denied_of_current_user_group'));
                }
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('administrators_label'), '#');
                $this->breadcrumbs->unshift(3, lang('index_groups_th'), 'groups');
                $this->breadcrumbs->unshift(4, lang('create_group_heading'), 'create-group');
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
                $this->_form_view();
        }

        private function _form_view()
        {
                $inputs['name'] = array(
                    'name'  => 'name',
                    'value' => $this->form_validation->set_value('name'),
                    'type'  => 'text',
                    'lang'  => 'create_group_name_label'
                );
                $inputs['desc'] = array(
                    'name'  => 'desc',
                    'value' => $this->form_validation->set_value('desc'),
                    'type'  => 'text',
                    'lang'  => 'create_group_desc_label'
                );

                $this->data['group_form'] = $this->form_boostrap('create-group/index', $inputs, 'create_group_heading', 'create_group_submit_btn', 'info-sign', NULL, TRUE);
                $this->data['bootstrap']  = $this->_bootstrap();
                $this->render('admin/create_group', $this->data);
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
