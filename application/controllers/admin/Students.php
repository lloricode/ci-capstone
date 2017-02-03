<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
        }

        public function index()
        {
                $data['test'] = 'test Students';
                $this->_render_admin_page('admin/students', $data);
        }

}
