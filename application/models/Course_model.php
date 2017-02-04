<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_model extends MY_Model {

        public function __construct() {
                $this->table       = 'course';
                $this->primary_key = 'course_id';


                parent::__construct();
        }

        public function total_rows() {
                return $this->db->count_all($this->table);
        }

}
