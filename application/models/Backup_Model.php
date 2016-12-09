<?php

defined('BASEPATH') or exit('no direct script allowed');

class Backup_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function backup() {
        $this->load->dbutil();
        $prefs = array(
            'format' => 'zip',
            'filename' => 'evaluation.sql',
        );
        $backup = $this->dbutil->backup($prefs);

        $this->load->helper(array('download', 'date'));
        $date = str_replace(' ', '_', my_current_datetime_information());
        $date = str_replace(',', '', $date);
        force_download('ci_capstone_db_backup_' . $date . '.zip', $backup);
    }

}
