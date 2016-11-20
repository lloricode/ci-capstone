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
        $this->validate_session();
    }

    private function validate_session() {
        $this->load->model('Session_Model');
        $this->Session_Model->check_session();
    }

    public function my_json_view($array) {
        $this->load->view('admin/api', array(
            'msg' => json_encode($array),
        ));
    }

    public function my_header_view() {
        $this->load->view('admin/header', array(
            'navigations' => $this->my_navigations()
        ));
    }

    /**
     * to load view page
     * @param string $caption caption of table
     * @param string $controller where to get data
     * @param array $columns key-tdata key, value = title header of table columns
     */
    public function my_table_view($caption, $controller, $columns) {
        $this->load->view('admin/table', array(
            'caption' => $caption,
            'columns' => $columns,
            'controller' => $controller,
        ));
    }

    public function my_navigations() {
        return array(
            'home' =>
            array(
                'label' => 'Home',
                'desc' => 'Home Description',
                'icon' => 'dashboard-dial',
            ),
            //sub menu
            'menus' =>
            array(
                'label' => 'Users',
                'icon' => 'chevron-down',
                'sub' =>
                array(
                    'users' =>
                    array(
                        'label' => 'Users',
                        'desc' => 'Users Description',
                        'icon' => 'male-user',
                    ),
                    'addadmin' =>
                    array(
                        'label' => 'Add Admin',
                        'desc' => 'Add Admin Description',
                        'icon' => 'pencil',
                    ),
                ),
            ),
            //sub menu
            'config' =>
            array(
                'label' => 'Configuration',
                'icon' => 'chevron-down',
                'sub' =>
                array(
                    'log' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Log Description',
                        'icon' => 'eye',
                    ),
                ),
            ),
        );
    }

}
