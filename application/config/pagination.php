<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 
 * before use this you just need to specify index below to dynamically generate link
 * 
 * you can see in extended CI_Pagination
 * 
 * application/libraries/MY_Pagination.php 
 * 
 * 
 * $config['base_url']     = base_url($controller);
 * $config['total_rows']   = $this->total_rows / $this->limit; 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com> 
 * @reference http://stackoverflow.com/questions/36951678/how-to-load-external-config-file-for-pagination-in-codeigniter
 */
$config['per_page']         = 1;
$config['use_page_numbers'] = TRUE;
$config['num_links']        = 3; // lesft&right - link number
$config['full_tag_open']    = '<ul>';
$config['full_tag_close']   = '</ul>';
$config['cur_tag_open']     = '<li class="active"><a>';
$config['cur_tag_close']    = '</a></li>';
$config['next_link']        = 'Next';
$config['prev_link']        = 'Previous';
$config['first_link']       = 'First';
$config['last_link']        = 'Last';
$config['uri_segment']      = 4;
$config['first_tag_open']   = '<li>';
$config['first_tag_close']  = '</li>';
$config['last_tag_open']    = '<li>';
$config['last_tag_close']   = '</li>';
$config['next_tag_open']    = '<li>';
$config['next_tag_close']   = '</li>';
$config['prev_tag_open']    = '<li>';
$config['prev_tag_close']   = '</li>';
$config['first_tag_open']   = '<li>';
$config['first_tag_close']  = '</li>';
$config['num_tag_open']     = '<li>';
$config['num_tag_close']    = '</li>';

