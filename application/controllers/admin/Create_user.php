<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_user extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters(
                        $this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth')
                );
        }

        public function index()
        {

                $this->data['title'] = $this->lang->line('create_user_heading');

                $tables                        = $this->config->item('tables', 'ion_auth');
                $identity_column               = $this->config->item('identity', 'ion_auth');
                $this->data['identity_column'] = $identity_column;

                // validate form input 
                $this->form_validation->set_rules(array(
                    array(
                        'label' => $this->lang->line('create_user_validation_fname_label'),
                        'field' => 'first_name',
                        'rules' => 'trim|required|human_name',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_lname_label'),
                        'field' => 'last_name',
                        'rules' => 'trim|required|human_name',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_identity_label'),
                        'field' => 'identity',
                        'rules' => 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_email_label'),
                        'field' => 'email',
                        'rules' => 'trim|valid_email',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_phone_label'),
                        'field' => 'phone',
                        'rules' => 'trim',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_company_label'),
                        'field' => 'company',
                        'rules' => 'trim',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_password_label'),
                        'field' => 'password',
                        'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|no_space|password_level[3]',
                    ),
                    array(
                        'label' => $this->lang->line('create_user_validation_password_confirm_label'),
                        'field' => 'password_confirm',
                        'rules' => 'trim|required',
                    ),
                ));
                $run__ = $this->form_validation->run();
                if ($run__)
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
                }
                if ($run__ && $this->ion_auth->register($identity, $password, $email, $additional_data))
                {
                        // check to see if we are creating the user
                        // redirect them back to the admin page
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(current_url(), 'refresh');
                }
                else
                {
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
                        $this->_render_admin_page('admin/create_user', $this->data);
                }
        }

}
