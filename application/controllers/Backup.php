<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->my_header_view();
        $this->load->view('admin/footer');
    }

}
