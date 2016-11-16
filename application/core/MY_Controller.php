<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->check_session();
    }

    private function check_session() {
        if ($this->uri->segment(1) == str_replace('/', '', ADMIN_DIRFOLDER_NAME)) {
            if (!$this->session->userdata('validated_admin')) {
                redirect(ADMIN_DIRFOLDER_NAME . 'login');
            }
        } else {
            if (!$this->session->userdata('validated_client')) {
                redirect(base_url());
            }
        }
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
                'label' => 'Menus',
                'icon' => 'chevron-down',
                'sub' =>
                array(
                    'sub_one' =>
                    array(
                        'label' => 'Sub Menu 1',
                        'desc' => 'Sub Menu1 Description',
                        'icon' => 'star',
                    ),
                    'sub_two' =>
                    array(
                        'label' => 'Sub Menu 2',
                        'desc' => 'Sub Menu2 Description',
                        'icon' => 'sound-on',
                    ),
                ),
            ),
            'users' =>
            array(
                'label' => 'Users',
                'desc' => 'Users Description',
                'icon' => 'male-user',
            ),
        );
    }

}
