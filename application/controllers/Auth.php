<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->check_log();
    }

    private function check_log() {
        if ($this->ion_auth->is_admin()) {
            redirect('dashboard', 'refresh');
        } else if ($this->ion_auth->logged_in()) {
            redirect('/', 'refresh');
        }
    }

// log the user in
    public function login() {
        $this->check_log();
        $this->data['title'] = $this->lang->line('login_heading');

//validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true) {
// check to see if the user is logging in
// check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
//if the login is successful
//redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('dashboard', 'refresh');
            } else {
// if the login was un-successful
// redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
// the user is not logging in so display the login page
// set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'placeholder' => 'Email'
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'placeholder' => 'Password'
            );

            $this->_render_page('admin/login', $this->data);
        }
    }

}
