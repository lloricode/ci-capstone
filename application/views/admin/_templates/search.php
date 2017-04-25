<?php

defined('BASEPATH') OR exit('No direct script access allowed');


$serch_value = ( $this->input->get('search')) ? $this->input->get('search') : (($this->session->has_userdata('search-key')) ? $this->session->userdata('search-key') : NULL);


echo form_open('students', array('method' => 'get'));

echo form_input('search', $serch_value, array('placeholder' => 'Search Student...'));

echo '<button type="submit" class="tip-bottom" title="Search Student"><i class="icon-search icon-white"></i></button>';

echo form_close();
