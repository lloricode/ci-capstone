<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_model extends MY_Model {

        public function __construct() {
                $this->table       = 'subjects';
                $this->primary_key = 'subject_id';


                $this->timestamps = TRUE;
                $this->return_as  = 'object';
                parent::__construct();
        }

}
