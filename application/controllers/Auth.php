<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{


        private $data;
        private $is_forgot_pass_enabled;

        public function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->lang->load('ci_ion_auth', TRUE); //some additional language value for library
                $this->form_validation->set_error_delimiters(
                        $this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth')
                );
                $this->is_forgot_pass_enabled = $this->config->item('ci_capstone_forgot_password');
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
         * Function to display the error/specific error upon log in
         * 
         * @author Lloric Garcia
         * @version 2017-2-1
         */
        private function _set_data($message = NULL)
        {
                $label = '';
                if ($this->config->item('identity', 'ion_auth') != 'email')
                {
                        $label = $this->lang->line('username_label', 'ci_ion_auth');
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
                    'type'        => 'text',
                    'value'       => $this->form_validation->set_value('identity'),
                    'placeholder' => $label
                );
                $this->data['password'] = array('name'        => 'password',
                    'type'        => 'password',
                    'placeholder' => 'Password'
                );
                $this->data['remember'] = array(
                    'name'    => 'remember',
                    'value'   => TRUE,
                    'checked' => FALSE
                );
        }

        private function _insert_session_id()
        {
                $this->User_model->update(array('gen_code' => $this->ion_auth->salt()), $this->ion_auth->get_user_id());
        }

        private function _insert_last_login()
        {
                $this->load->library('user_agent');
                if ($this->agent->is_browser())
                {
                        $agent = $this->agent->browser() . ' ' . $this->agent->version();
                }
                elseif ($this->agent->is_robot())
                {
                        $agent = $this->agent->robot();
                }
                elseif ($this->agent->is_mobile())
                {
                        $agent = $this->agent->mobile();
                }
                else
                {
                        $agent = 'Unidentified User Agent';
                }

                $this->load->model('Users_last_login_model');
                return (bool) $this->Users_last_login_model->insert(array(
                            'user_id'    => $this->ion_auth->get_user_id(),
                            'ip_address' => $this->input->ip_address(),
                            'agent'      => $agent,
                            'platform'   => $this->agent->platform()
                ));
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
                                redirect('home', 'refresh');
                        }
                }

                $this->form_validation->set_rules('identity', $this->lang->line('username_label', 'ci_ion_auth'), 'required');
                $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

                if ($this->form_validation->run())
                {
                        $remember = (bool) $this->input->post('remember', TRUE);

                        if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
                        {
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                $this->_insert_session_id();
                                $this->_insert_last_login();

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
                if ( ! $this->is_forgot_pass_enabled)
                {
                        show_404();
                }
                // setting validation rules by checking whether identity is username or email
                if ($this->config->item('identity', 'ion_auth') != 'email')
                {
                        $this->form_validation->set_rules('identity', $this->lang->line('username_label', 'ci_ion_auth'), 'required');
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
                if ( ! $this->is_forgot_pass_enabled)
                {
                        show_404();
                }
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

                $this->ion_auth->logout();

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
                        $m = bootstrap_error($message);
                }
                $this->login($m);
        }

}
