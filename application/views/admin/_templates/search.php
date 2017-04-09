<?php

defined('BASEPATH') OR exit('No direct script access allowed');

echo form_open('students', array('method' => 'get'));

echo form_input('search', $this->input->get('search'), array('placeholder' => 'Search Student...'));

echo '<button type="submit" class="tip-bottom" title="Search Student"><i class="icon-search icon-white"></i></button>';

echo form_close();
