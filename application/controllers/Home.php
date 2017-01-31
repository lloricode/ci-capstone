<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
        }

        public function index()
        {
                $this->load->view('home');
        }

}
