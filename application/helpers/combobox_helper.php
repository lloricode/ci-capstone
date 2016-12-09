<?php

defined('BASEPATH') or exit('no direct script allowed');

/**
 * 
 * @return array 1-1st Semester,2-2nd Semester,3-Summer Semester
 */
function my_semester_for_combo() {
    return array(
        '1' => '1st Semester',
        '2' => '2nd Semester',
        '3' => 'Summer Semester',
    );
}

/**
 * 
 * @return array 
 */
function my_schoolyear_for_combo() {
    return array(
        '2016-2017' => '2016-2017',
        '2017-2018' => '2017-2018',
        '2018-2019' => '2018-2019',
    );
}

/**
 * 
 * @return array key = 24hrs, value = 12hrs
 */
function my_time_for_combo() {
    return array(
        '6:00' => '6:00 am',
        '7:00' => '7:00 am',
        '8:00' => '8:00 am',
        '9:00' => '9:00 am',
        '10:00' => '10:00 am',
        '11:00' => '11:00 am',
        '12:00' => '12:00 pm',
        '13:00' => '1:00 pm',
        '14:00' => '2:00 pm',
        '15:00' => '3:00 pm',
        '16:00' => '4:00 pm',
        '17:00' => '5:00 pm',
        '18:00' => '6:00 pm',
        '19:00' => '7:00 pm'
    );
}

function my_course_combo() {
    return array(
        'college' => 'College',
        'highshool' => 'High School',
        'elememtary' => 'Elementary',
    );
}
