<?php

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    public function _render_page($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml)
            return $view_html; //This will return html on 3rd argument being true
    }

    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

class Admin_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }

    /**
     * main administrator header view 
     */
    public function my_header_view() {
        $this->load->view('admin/header', array(
            'navigations' => $this->my_navigations(),
            'setting_vavigations' => $this->setting_navs()
        ));
    }

    public function my_table_view($header, $data) {
        $this->load->library('table');
        $this->table->set_heading($header);
        $this->table->set_template(array(
            'table_open' => '<table class="table table-bordered data-table">',
        ));
        return $this->table->generate($data);
    }

    public function my_navigations() {
        return array(
            'dashboard' =>
            array(
                'label' => 'Dashboard',
                'desc' => 'Dashboard Description',
                'icon' => 'beaker',
            ),
            //sub menu
            'menus' =>
            array(
                'label' => 'Users',
                'icon' => 'user',
                'sub' =>
                array(
                    'users' =>
                    array(
                        'label' => 'Users',
                        'desc' => 'Users Description',
                        'seen' => TRUE,
                    ),
                    'create-user' =>
                    array(
                        'label' => 'Create Users',
                        'desc' => 'Create Users Description',
                        'seen' => TRUE,
                    ),
                    'edit-group' =>
                    array(
                        'label' => 'Edit Group',
                        'desc' => 'Edit Group Description',
                        'seen' => FALSE,
                    ),
                    'deactivate' =>
                    array(
                        'label' => 'Deactivate User',
                        'desc' => 'Deactivate User Description',
                        'seen' => FALSE,
                    ),
                    'edit-user' =>
                    array(
                        'label' => 'Edit User',
                        'desc' => 'Edit User Description',
                        'seen' => FALSE,
                    ),
                ),
            ),
            //sub menu
            'menus4' =>
            array(
                'label' => 'Settings',
                'icon' => 'cogs',
                'sub' =>
                array(
                    'backup' =>
                    array(
                        'label' => 'Backup Database',
                        'desc' => 'Backup Database Description',
                        'seen' => TRUE,
                    ),
                    'log' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Logsn Description',
                        'seen' => TRUE,
                    ),
                ),
            ),
        );
    }

    private function setting_navs() {
        return array(
            'backup' =>
            array(
                'label' => 'Backup Database',
                'desc' => 'Backup Database Description',
                'icon' => 'file',
            ),
            'log' =>
            array(
                'label' => 'Error Logs',
                'desc' => 'Error Logsn Description',
                'icon' => 'exclamation-sign',
            ),
        );
    }

}

class Public_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

}
