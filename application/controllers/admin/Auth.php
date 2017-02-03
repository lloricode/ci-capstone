<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{


        private $data;

        public function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters(
                        $this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth')
                );
        }

        public function index()
        {
                if ($this->ion_auth->logged_in() and ! $this->ion_auth->is_admin())
                {
                        // redirect them to the login page
                        redirect(base_url(), 'refresh');
                }
                elseif ($this->ion_auth->is_admin())
                { // remove this elseif if you want to enable this for non-admins
                        // redirect them to the home page because they must be an administrator to view this
                        // return show_error('You must be an administrator to view this page.');
                        redirect(base_url('dashboard'), 'refresh');
                }
                else
                {
                        redirect(base_url('admin/auth/login'), 'refresh');
                }
        }

        private function check_log()
        {
                if ($this->ion_auth->is_admin())
                {
                        redirect('admin/home', 'refresh');
                }
                else if ($this->ion_auth->logged_in())
                {
                        redirect('/', 'refresh');
                }
        }

        private function set_data()
        {
                // the user is not logging in so display the login page
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['identity'] = array('name'        => 'identity',
                    'id'          => 'identity',
                    'type'        => 'text',
                    'value'       => $this->form_validation->set_value('identity'),
                    'placeholder' => 'Username'
                );
                $this->data['password'] = array('name'        => 'password',
                    'id'          => 'password',
                    'type'        => 'password',
                    'placeholder' => 'Password'
                );
                $this->data['email']    = array('name'        => 'email',
                    'id'          => 'email',
                    'type'        => 'email',
                    'placeholder' => 'Email'
                );



                //forgot password
                //  $this->data['type'] = $this->config->item('identity', 'ion_auth');
        }

        // log the user in
        public function login()
        {
                $this->check_log();
                $this->data['title'] = $this->lang->line('login_heading');

                //validate form input
                $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
                $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

                if ($this->form_validation->run())
                {
                        // check to see if the user is logging in
                        // check for "remember me"
                        $remember = (bool) $this->input->post('remember');

                        if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
                        {
                                //if the login is successful
                                //      $this->session->set_flashdata('message', $this->ion_auth->messages());
                                //set the user name/last name in session
                                $user_obj = $this->ion_auth->user()->row();
                                $this->session->set_userdata(array(
                                    'user_first_name' => $user_obj->first_name,
                                    'user_last_name'  => $user_obj->last_name
                                ));

                                //redirect them back to the home page
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect('admin/home', 'refresh');
                        }
                        else
                        {
                                // if the login was un-successful
                                // redirect them back to the login page
                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                redirect('admin/auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                        }
                }
                else
                {
                        $this->set_data();
                        $this->_render_page('admin/login', $this->data);
                }
        }

        public function forgot_password()
        {

                $this->form_validation->set_rules(
                        'email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');



                if (!$this->form_validation->run())
                {

                        $this->set_data();
                        $this->_render_page('admin/login', $this->data);
                }
                else
                {
                        $user_obj = $this->ion_auth->where('email', $this->input->post('email'))->users()->row();

                        if (!$user_obj)
                        {
                                $this->ion_auth->set_error('forgot_password_email_not_found');
                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                redirect("admin/auth/login", 'refresh');
                        }

                        // run the forgotten password method to email an activation code to the user
                        $forgotten = $this->ion_auth->forgotten_password($user_obj->{'email'});

                        if ($forgotten)
                        {
                                // if there were no errors
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect("admin/auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
                        }
                        else
                        {
                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                redirect("admin/auth/login", 'refresh');
                        }
                }
        }

// reset password - final step for forgotten password
        public function reset_password($code = NULL)
        {
                if (!$code)
                {
                        show_404();
                }

                $user = $this->ion_auth->forgotten_password_check($code);

                if ($user)
                {
                        // if the code is valid then display the password reset form

                        $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
                        $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

                        if ($this->form_validation->run() == false)
                        {
                                // display the form
                                // set the flash data error message if there is one
                                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                                $this->data['min_password_length']  = $this->config->item('min_password_length', 'ion_auth');
                                $this->data['new_password']         = array(
                                    'name'        => 'new',
                                    'id'          => 'new',
                                    'type'        => 'password',
                                    'placeholder' => 'Password',
                                    'pattern'     => '^.{' . $this->data['min_password_length'] . '}.*$',
                                );
                                $this->data['new_password_confirm'] = array(
                                    'name'        => 'new_confirm',
                                    'id'          => 'new_confirm',
                                    'type'        => 'password',
                                    'placeholder' => 'Retype-Password',
                                    'pattern'     => '^.{' . $this->data['min_password_length'] . '}.*$',
                                );
                                $this->data['user_id']              = array(
                                    'name'  => 'user_id',
                                    'id'    => 'user_id',
                                    'type'  => 'hidden',
                                    'value' => $user->id,
                                );
                                $this->data['csrf']                 = $this->_get_csrf_nonce();
                                $this->data['code']                 = $code;

                                // render
                                $this->_render_page('admin/reset_password', $this->data);
                        }
                        else
                        {
                                // do we have a valid request?
                                if ($user->id != $this->input->post('user_id'))
                                {

                                        // something fishy might be up
                                        $this->ion_auth->clear_forgotten_password_code($code);

                                        show_error($this->lang->line('error_csrf'));
                                }
                                else
                                {
                                        // finally change the password
                                        $identity = $user->{$this->config->item('identity', 'ion_auth')};

                                        $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                                        if ($change)
                                        {
                                                // if the password was successfully changed
                                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                                redirect("admin/auth/login", 'refresh');
                                        }
                                        else
                                        {
                                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                                redirect('auth/reset_password/' . $code, 'refresh');
                                        }
                                }
                        }
                }
                else
                {
                        // if the code is invalid then send them back to the forgot password page
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect("auth/forgot_password", 'refresh');
                }
        }

        // log the user out
        public function logout()
        {
                $this->data['title'] = "Logout";

                // log the user out
                $logout = $this->ion_auth->logout();
                // redirect them to the login page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('admin/auth/login', 'refresh');
        }

}
