<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'courses';
                $this->primary_key = 'course_id';


                $this->timestamps = TRUE;
                $this->return_as  = 'object';
                parent::__construct();
        }

}
