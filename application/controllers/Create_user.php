<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_user extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, 'Users', 'users');
                $this->breadcrumbs->unshift(3, 'Create User', 'create-user');
        }

        public function index()
        {

                $tables                        = $this->config->item('tables', 'ion_auth');
                $identity_column               = $this->config->item('identity', 'ion_auth');
                $this->data['identity_column'] = $identity_column;

                // validate form input 
                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('create_user_validation_fname_label'),
                        'field' => 'first_name',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_user_validation_lname_label'),
                        'field' => 'last_name',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_user_validation_identity_label'),
                        'field' => 'identity',
                        'rules' => 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']|min_length[3]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_user_validation_email_label'),
                        'field' => 'email',
                        'rules' => 'trim|required|valid_email|min_length[3]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_user_validation_phone_label'),
                        'field' => 'phone',
                        'rules' => 'trim|min_length[3]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_user_validation_company_label'),
                        'field' => 'company',
                        'rules' => 'trim|min_length[3]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_user_validation_password_label'),
                        'field' => 'password',
                        'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|no_space|password_level[3]',
                    ),
                    array(
                        'label' => lang('create_user_validation_password_confirm_label'),
                        'field' => 'password_confirm',
                        'rules' => 'trim|required',
                    ),
                ));

                if ($this->form_validation->run())
                {
                        $email    = strtolower($this->input->post('email', TRUE));
                        $identity = ($identity_column === 'email') ? $email : $this->input->post('identity', TRUE);
                        $password = $this->input->post('password', TRUE);

                        $additional_data = array(
                            'first_name' => $this->input->post('first_name', TRUE),
                            'last_name'  => $this->input->post('last_name', TRUE),
                            'company'    => $this->input->post('company', TRUE),
                            'phone'      => $this->input->post('phone', TRUE),
                        );
                        if ($this->ion_auth->register($identity, $password, $email, $additional_data))
                        {
                                // check to see if we are creating the user
                                // redirect them back to the admin page
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect(base_url('users'), 'refresh');
                        }
                }
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->data['first_name']       = array(
                    'name'  => 'first_name',
                    'id'    => 'first_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('first_name'),
                );
                $this->data['last_name']        = array(
                    'name'  => 'last_name',
                    'id'    => 'last_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('last_name'),
                );
                $this->data['identity']         = array(
                    'name'  => 'identity',
                    'id'    => 'identity',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('identity'),
                );
                $this->data['email']            = array(
                    'name'  => 'email',
                    'id'    => 'email',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('email'),
                );
                $this->data['company']          = array(
                    'name'  => 'company',
                    'id'    => 'company',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('company'),
                );
                $this->data['phone']            = array(
                    'name'  => 'phone',
                    'id'    => 'phone',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('phone'),
                );
                $this->data['password']         = array(
                    'name'  => 'password',
                    'id'    => 'password',
                    'type'  => 'password',
                    'value' => $this->form_validation->set_value('password'),
                );
                $this->data['password_confirm'] = array(
                    'name'  => 'password_confirm',
                    'id'    => 'password_confirm',
                    'type'  => 'password',
                    'value' => $this->form_validation->set_value('password_confirm'),
                );
                $this->data['bootstrap']        = $this->bootstrap();
                $this->_render('admin/create_user', $this->data);
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
