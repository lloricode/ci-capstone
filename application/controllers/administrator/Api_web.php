<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_web extends MY_Controller {

    public function admins() {
        $this->load->model('Admin_Model');
        $this->my_json_view($this->Admin_Model->all_admins());
    }

}
