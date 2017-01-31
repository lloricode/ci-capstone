<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
        }

        public function index()
        {
                $data['test'] = 'test dashboard';
                $this->_render_admin_page('admin/dashboard', $data);
        }

}
