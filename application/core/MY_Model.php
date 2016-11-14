<?php

defined('BASEPATH') or exit('no direct script allowed');

class MY_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return string value: %Y:%m:%d sample : 2016:12:31
     */
    public function my_datetime_format() {
        $datestring = '%Y:%m:%d';
        $time = time();
        return mdate($datestring, $time);
    }

    /**
     * 
     * @param string $timestamp
     * @param string time or date
     * @return string December 30, 20016
     */
    public function my_converter_datetime_format($timestamp, $dt) {
        if ($dt == 'date') {
            $format = '%Y:%m:%d';
            list($YY, $mm, $dd) = explode(':', mdate($format, $timestamp));
            return $this->my_month_array($mm) . ' ' . $dd . ', ' . $YY;
        } elseif ($dt == 'time') {
            $format = '%h:%i %a';
            return mdate($format, $timestamp);
        }
    }

    /**
     * 
     * @return string December 30, 20016
     */
    public function my_current_datetime_information() {
        $datetimeformated = $this->my_datetime_format();
        list($YY, $mm, $dd) = explode(':', $datetimeformated);
        return $this->my_month_array($mm) . ' ' . $dd . ', ' . $YY;
    }

    /**
     * 
     * @return String Sun,Mon
     */
    public function my_day() {
        $time = time();
        return mdate('%D', $time);
    }

    /**
     * 
     * @param type $month_number
     * @return string 1=January 2=February, etc..
     */
    public function my_month_array($month_number) {
        $month = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'Augost',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );
        return $month[$month_number];
    }

    /**
     * 
     * @return array 1-1st Semester,2-2nd Semester,3-Summer Semester
     */
    public function my_semester_for_combo() {
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
    public function my_schoolyear_for_combo() {
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
    public function my_time_for_combo() {
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

}
