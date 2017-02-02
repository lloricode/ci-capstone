<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'users';
                $this->primary_key = 'id';
                //   $this->soft_deletes = true;
                //$this->has_one['details'] = 'User_details_model';
                // $this->has_one['details'] = array('User_details_model','user_id','id');
                //  $this->has_one['details'] = array('local_key' => 'id', 'foreign_key' => 'user_id', 'foreign_model' => 'User_details_model');
                // $this->has_many['posts'] = 'Post_model';

                parent::__construct();
        }

        public function total_rows()
        {
                return $this->db->count_all($this->table);
        }

}
