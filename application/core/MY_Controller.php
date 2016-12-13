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

    /**
     * main administrator header view 
     */
    public function my_header_view() {
        $this->load->view('admin/header', array(
            'navigations' => $this->my_navigations(),
            'setting_vavigations' => $this->setting_navs()
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
                'sub' =>
                array(
                    'users' =>
                    array(
                        'label' => 'Users',
                        'desc' => 'Users Description',
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
                    ),
                    'history' =>
                    array(
                        'label' => 'History',
                        'desc' => 'Error Logsn Description',
                    ),
                    'log' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Logsn Description',
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
