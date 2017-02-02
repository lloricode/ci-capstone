<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
        }

        public function index()
        {
                $data['test'] = 'test Home';
                $this->_render_admin_page('admin/home', $data);
        }

}
