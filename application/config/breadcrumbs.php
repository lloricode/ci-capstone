<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');


/* Breadcrumbs */
$config['breadcrumb_open']  = '<div id="breadcrumb">';
$config['breadcrumb_close'] = '</div>';

$config['breadcrumb_el_open']       = '';
$config['breadcrumb_el_open_extra'] = array('class' => 'tip-bottom');
$config['breadcrumb_el_close']      = '';

$config['breadcrumb_el_first']       = '<i class="icon-home"></i> ';
$config['breadcrumb_el_first_extra'] = array('title' => 'Go To Home', 'class' => 'tip-bottom');

$config['breadcrumb_el_last_open']       = '';
$config['breadcrumb_el_last_open_extra'] = array('class' => 'current tip-bottom');
$config['breadcrumb_el_last_close']      = '';
