<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function index() {
        $this->my_header_view();
        $this->my_table_view('Admins Data','admins', array(
            'inc' => '#',
            'fullname' => 'Fullname',
            'username' => 'Username',
            'status' => 'Status',
            'option' => 'Option',
        ));
        $this->my_table_view('Client Users Data','clients', array(
            'inc' => '#',
            'fullname' => 'Fullname',
            'email' => 'Email',
            'status' => 'Status',
            'option' => 'Option',
        ));
        $this->load->view('admin/footer');
    }

}
