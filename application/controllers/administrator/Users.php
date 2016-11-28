<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function index() {

        $this->my_header_view();

        $this->load->library('table');
        $this->table->set_template(array(
            'table_open' => '<table class="table table-bordered data-table">',
        ));
        $this->table->set_heading(array(
            'inc' => '#',
            'fullname' => 'Fullname',
            'username' => 'Username',
            'status' => 'Status',
            'option' => 'Option',
        ));
        $this->load->model('Admin_Model');

        $this->my_table_view('Admin Data', $this->table->generate($this->Admin_Model->all_admins()));

        $this->load->view('admin/footer', array(
            'controller' => 'table'
        ));
    }

}
