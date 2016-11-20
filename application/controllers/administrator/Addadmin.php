<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('Direct script in not allowed');

class Addadmin extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->my_header_view();

        $this->load->model('Admin_Model');
        $this->Admin_Model->add();

        $this->load->view('admin/footer');
    }

}
