<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$current_controller = str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller')));

if ('subjects' === $current_controller)
{
        $search_n_session_key = 'search-subject';
        $action               = 'subjects';
        $placeholder          = 'Search Subject...';
        $title                = 'Search Subject';
}
elseif ('curriculums' === $current_controller)
{
        $search_n_session_key = 'search-curriculum';
        $action               = 'curriculums';
        $placeholder          = 'Search Curriculum...';
        $title                = 'Search Curriculum';
}
else
{
        $search_n_session_key = 'search-student';
        $action               = 'students';
        $placeholder          = 'Search Student...';
        $title                = 'Search Student';
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
unset($current_controller);
