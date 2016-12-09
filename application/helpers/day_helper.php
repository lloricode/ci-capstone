<?php

defined('BASEPATH') or exit('no direct script allowed');


/**
 * 
 * @return String Sun,Mon
 */
function my_day() {
    $time = time();
    return mdate('%D', $time);
}



function days($row) {
    $d = array(
        'm' => 'M',
        't' => 'T',
        'w' => 'W',
        'th' => 'TH',
        'f' => 'F',
        's' => 'Sat',
        'su' => 'Sun',
    );
    $days = '';
    foreach ($d AS $k => $v) {
        $tmp = 'schedule_' . $k;
        if ($row->$tmp) {
            $days .= $v;
        }
    }
    if ($days == '') {
        $days = '--';
    }
    return $days;
}
