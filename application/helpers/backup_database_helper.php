<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('backup_database'))
{

        /**
         * 
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function backup_database()
        {
                $CI     = &get_instance();
                $CI->load->dbutil();
                $prefs  = array(
                    'format'   => 'zip',
                    'filename' => 'ci_capstone.sql',
                );
                $backup = $CI->dbutil->backup($prefs);

                $CI->load->helper(array('download', 'date'));
                $date = str_replace(' ', '_', my_current_datetime_information());
                $date = str_replace(',', '', $date);
                force_download('ci_capstone_db_backup_' . $date . '.zip', $backup);
        }

}