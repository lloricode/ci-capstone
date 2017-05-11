<?php

defined('BASEPATH') OR exit('No direct script access allowed');

switch (str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller'))))
{
        case 'subjects':
                $search_n_session_key = 'search-subject';
                $action               = 'subjects';
                $placeholder          = 'Search Subject...';
                $title                = 'Search Subject';
                break;
        case 'curriculums' :
                $search_n_session_key = 'search-curriculum';
                $action               = 'curriculums';
                $placeholder          = 'Search Curriculum...';
                $title                = 'Search Curriculum';
                break;
        default :
                $search_n_session_key = 'search-student';
                $action               = 'students';
                $placeholder          = 'Search Student...';
                $title                = 'Search Student';
                break;
}


$serch_value = ( $this->input->get($search_n_session_key)) ? $this->input->get($search_n_session_key) : $this->session->userdata($search_n_session_key);
echo form_open($action, array('method' => 'get'));
echo form_input($search_n_session_key, $serch_value, array('placeholder' => $placeholder));
echo '<button type="submit" class="tip-bottom" title="' . $title . '"><i class="icon-search icon-white"></i></button>';
echo form_close();



unset($placeholder);
unset($title);
unset($serch_value);
unset($search_n_session_key);
unset($action);
