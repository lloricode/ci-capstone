<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * COMMON
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */


$config['max_year_level']      = 4;
$config['bootstarp_dir']       = 'assets/framework/bootstrap/admin/matrix-admin-package/';
$config['student_image_dir']   = 'assets/images/students/';
$config['project_title']       = 'CI Capstone';
$config['project_title_link']  = 'https://github.com/lloricode/ci-capstone';
$config['project_title_1']     = 'CI';
$config['project_title_2']     = 'Capstone';
$config['project_web']         = 'lloricmayugagarcia.com';
$config['project_web_link']    = 'http://lloricmayugagarcia.com';
$config['current_year_footer'] = '2017';


/**
 * this is for school id generator
 */
$config['school_year_start'] = 6; //JUNE
$config['school_year_end']   = 5; //MAY

/**
 * automatically first semester is start of class
 */
$config['first_semester_start']  = $config['school_year_start']; //6
$config['second_semester_start'] = 10; //oct
$config['summer_semester_start'] = 4;

/**
 * id generator version
 * 
 * version 1 | YYYY-1234 - sample 2017-0312
 * version 2 | course-1234 - sample: 06-3456
 */
$config['version_id_generator']      = 2;
$config['start_id_number_generator'] = 0;


/*
 * SEGMENT FOR GET CONTROLLER
 */

$config['segment_controller'] = 2;
/*
 * SEGMENT FOR PAGINATION
 */

$config['segment_pagination'] = 4;


/**
 * image resize folders
 */
$config['student_image_size_profile'] = '200x200/';
$config['student_image_size_table']   = '40x40/';

/**
 * 
 */
$config['default_student_image_in_table'] = 'assets/images/favicon.ico';
