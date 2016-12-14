<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        // $this->validate_session();
    }

    private function validate_session() {
        $this->load->model('Session_Model');
        $this->Session_Model->check_session();
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
            '' =>
            array(
                'label' => 'Home',
                'desc' => 'Home Description',
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
