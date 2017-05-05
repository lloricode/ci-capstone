<?php

defined('BASEPATH') OR exit('No direct script access allowed');


$serch_value = ( $this->input->get('search-student')) ? $this->input->get('search-student') : (($this->session->has_userdata('search-student')) ? $this->session->userdata('search-student') : NULL);


echo form_open('students', array('method' => 'get'));

echo form_input('search-student', $serch_value, array('placeholder' => 'Search Student...'));

echo '<button type="submit" class="tip-bottom" title="Search Student"><i class="icon-search icon-white"></i></button>';

echo form_close();
