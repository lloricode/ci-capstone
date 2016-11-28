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
        $this->load->library('myjson');
        $this->load->view('admin/api', array(
            'msg' => $this->myjson->beautifier(json_encode($array)),
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
    public function my_table_view($caption, $data) {
        $this->load->view('admin/table', array(
            'caption' => $caption,
            'data' => $data,
        ));
    }

    public function my_navigations() {
        return array(
            'home' =>
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
                'count' => '2',
                'sub' =>
                array(
                    'users' =>
                    array(
                        'label' => 'Users',
                        'desc' => 'Users Description',
                    ),
                    'addadmin' =>
                    array(
                        'label' => 'Add Admin',
                        'desc' => 'Add Admin Description',
                    ),
                ),
            ),
            //sub menu
            'config' =>
            array(
                'label' => 'Configuration',
                'icon' => 'warning-sign',
                'count' => '1',
                'sub' =>
                array(
                    'log' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Log Description',
                    ),
                ),
            ),
        );
    }

}
