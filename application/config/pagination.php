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
$config['per_page']           = 1;
$config['use_page_numbers']   = TRUE;
$config['num_links']          = 3; // lesft&right - link number
$config['full_tag_open']      = '<ul>' . PHP_EOL;
$config['full_tag_close']     = '</ul>' . PHP_EOL;
$config['cur_tag_open']       = '<li class="active">' . PHP_EOL . '<a>';
$config['cur_tag_close']      = '</a>' . PHP_EOL . '</li>' . PHP_EOL;
$config['next_link']          = lang('ci_pagination_next_link');
$config['prev_link']          = lang('ci_pagination_prev_link');
$config['first_link']         = lang('ci_pagination_first_link');
$config['last_link']          = lang('ci_pagination_last_link');
$config['uri_segment']        = 4;
$config['first_tag_open']     = '<li>' . PHP_EOL;
$config['first_tag_close']    = '</li>' . PHP_EOL;
$config['last_tag_open']      = '<li>' . PHP_EOL;
$config['last_tag_close']     = '</li>' . PHP_EOL;
$config['next_tag_open']      = '<li>' . PHP_EOL;
$config['next_tag_close']     = '</li>' . PHP_EOL;
$config['prev_tag_open']      = '<li>' . PHP_EOL;
$config['prev_tag_close']     = '</li>' . PHP_EOL;
$config['num_tag_open']       = '<li>' . PHP_EOL;
$config['num_tag_close']      = '</li>' . PHP_EOL;
$config['prev_link_diabled']  = '<li class="disabled"><a>' . $config['prev_link'] . '</a></li>' . PHP_EOL;
$config['next_link_diabled']  = '<li class="disabled"><a>' . $config['next_link'] . '</a></li>' . PHP_EOL;
$config['first_link_diabled'] = '<li class="disabled"><a>' . $config['first_link'] . '</a></li>' . PHP_EOL;
$config['last_link_diabled']  = '<li class="disabled"><a>' . $config['last_link'] . '</a></li>' . PHP_EOL;

