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

                /**
                 * set hook for insert user last login data after success login,
                 */
                $this->ion_auth->set_hook(
                        'post_login_successful', 'insert_last_login', $this/* $this because the class already extended */, 'insert_last_login', array()
                );
                $this->ion_auth->set_hook(
                        'post_login_successful', 'add_another_session', $this/* $this because the class already extended */, 'set_session_data_session', array()
                );
        }

        public function index()
        {
                if ($this->ion_auth->logged_in())
                {
                        redirect('', 'refresh');
                }
                else
                {
                        redirect('auth/login', 'refresh');
                }
        }

        /**
         * Function to display the error/specifi error upon log in
         * 
         * @author Lloric Garcia
         * @version 2017-2-1
         */
        private function _set_data($message = NULL)
        {
                $label = '';
                if ($this->config->item('identity', 'ion_auth') != 'email')
                {
                        $label = $this->lang->line('forgot_password_identity_label');
                }
                else
                {
                        $label = $this->lang->line('forgot_password_email_identity_label');
                }
                // the user is not logging in so display the login page
                // set the flash data error message if there is one
                $this->data['message']  = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                $this->data['message']  = ( ! is_null($message)) ? $message : $this->data['message'];
                $this->data['identity'] = array('name'        => 'identity',
                    'id'          => 'identity',
                    'type'        => 'text',
                    'value'       => $this->form_validation->set_value('identity'),
                    'placeholder' => $label
                );
                $this->data['password'] = array('name'        => 'password',
                    'id'          => 'password',
                    'type'        => 'password',
                    'placeholder' => 'Password'
                );



                //  $this->data['type'] = $this->config->item('identity', 'ion_auth');
        }

        /**
         * Function that logs the user in
         * 
         * @author ion_auth
         * @version 2017-2-1
         */
        public function login($message = NULL)
        {
                if (is_null($message))
                {
                        if ($this->ion_auth->logged_in())
                        {
                                redirect('/', 'refresh');
                        }
                }
                //  $this->data['title'] = $this->lang->line('login_heading');
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
                                //redirect them back to the home page
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect(site_url('home'), 'refresh');
                        }
                        else
                        {
                                // if the login was un-successful
                                // redirect them back to the login page
                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                redirect(site_url('auth/login'), 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                        }
                }
                else
                {
                        $this->_set_data($message);
                        $this->render('admin/login', $this->data);
                }
        }

        /**
         * Function to reset password incase the password is forgotten.
         * 
         * @author ion_auth
         * @version 2017-2-1
         */
        public function forgot_password()
        {
                // setting validation rules by checking whether identity is username or email
                if ($this->config->item('identity', 'ion_auth') != 'email')
                {
                        $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
                }
                else
                {
                        $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
                }


                if ($this->form_validation->run() == false)
                {

                        $this->_set_data();
                        $this->render('admin/login', $this->data);
                }
                else
                {
                        $identity_column = $this->config->item('identity', 'ion_auth');
                        $identity        = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

                        if (empty($identity))
                        {

                                if ($this->config->item('identity', 'ion_auth') != 'email')
                                {
                                        $this->ion_auth->set_error('forgot_password_identity_not_found');
                                }
                                else
                                {
                                        $this->ion_auth->set_error('forgot_password_email_not_found');
                                }

                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                redirect("auth/login", 'refresh');
                        }

                        // run the forgotten password method to email an activation code to the user
                        $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

                        if ($forgotten)
                        {
                                // if there were no errors
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
                        }
                        else
                        {
                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                redirect("auth/login", 'refresh');
                        }
                }
        }

        /**
         * Function to reset password incase the password is forgotten.
         * 
         * @author ion_auth
         * @version 2017-2-1
         */
        public function reset_password($code = NULL)
        {
                if ( ! $code)
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
                                $this->data['user']                 = array(
                                    'user_id' => $user->id
                                );
                                $this->data['code']                 = $code;

                                // render
                                $this->render('reset_password', $this->data);
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
                                                redirect("auth/login", 'refresh');
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

        /**
         * Function that logs the user out.
         *
         * @param string $message | default is null, we use this for unexpected logout message when multiple user
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         * @version 2017-2-1
         */
        public function logout($message = NULL)
        {
                if ( ! $this->ion_auth->logged_in())
                {
                        redirect('auth/login', 'refresh');
                }
                // log the user out
                $this->ion_auth->logout();
                // redirect them to the login page
                //   $this->session->set_flashdata('message', $this->ion_auth->messages());
                // redirect('auth/login', 'refresh');

                /*
                 * i set this because all session destroyed also even done logout,
                 */
                $m = '';
                if (is_null($message))
                {
                        $m = $this->ion_auth->messages();
                }
                else
                {
                        $message = str_replace('_', ' ', $message);
                        /**
                         * set erro delimeter
                         * using ion_auth
                         */
                        $m       = $this->config->item('error_start_delimiter', 'ion_auth') . $message . $this->config->item('error_end_delimiter', 'ion_auth');
                }
                $this->login($m);
        }

}
