<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_one extends MY_Controller {

    public function index() {
        $this->my_header_view();
        $this->load->view('admin/footer');
    }

}
