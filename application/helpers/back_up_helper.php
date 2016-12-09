<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('backup_database')) {

    /**
     * 
     */
    function backup_database() {
        $CI = &get_instance();
        $CI->load->dbutil();
        $prefs = array(
            'format' => 'zip',
            'filename' => 'evaluation.sql',
        );
        $backup = $CI->dbutil->backup($prefs);

        $CI->load->helper(array('download', 'date'));
        $date = str_replace(' ', '_', my_current_datetime_information());
        $date = str_replace(',', '', $date);
        force_download('ci_capstone_db_backup_' . $date . '.zip', $backup);
    }

}