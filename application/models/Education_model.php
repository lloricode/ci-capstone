<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Education_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'educations';
                $this->primary_key = 'education_id';

                $this->has_many['course'] = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'courses',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );
                $this->timestamps             = TRUE;
                $this->return_as              = 'object';
                $this->timestamps_format      = 'timestamp';
                parent::__construct();
        }

}
