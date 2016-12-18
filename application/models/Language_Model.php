<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Language_model extends MY_Model {

    public function __construct() {
        $this->table = 'language';
        $this->primary_key = 'language_id';
        //   $this->soft_deletes = true;
        //$this->has_one['details'] = 'User_details_model';
        // $this->has_one['details'] = array('User_details_model','user_id','id');
        //  $this->has_one['details'] = array('local_key' => 'id', 'foreign_key' => 'user_id', 'foreign_model' => 'User_details_model');
        // $this->has_many['posts'] = 'Post_model';

        parent::__construct();
    }

    public function set_user_language($lang) {
        $insert_data = array(
            array(
                'user_id' => $this->session->userdata('user_id'),
                'language_value' => $lang,
            ),
        );
        $this->db->insert_batch($this->table, $insert_data);
    }

}
