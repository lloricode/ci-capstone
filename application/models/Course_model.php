<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'courses';
                $this->primary_key = 'course_id';

                $this->has_many['enrollment'] = array(
                    'foreign_model' => 'Enrollment_model',
                    'foreign_table' => 'enrollments',
                    'foreign_key'   => 'enrollment_id',
                    'local_key'     => 'enrollment_id'
                );
                $this->has_one['education']   = array(
                    'foreign_model' => 'Education_model',
                    'foreign_table' => 'educations',
                    'foreign_key'   => 'education_id',
                    'local_key'     => 'education_id'
                );
                $this->timestamps             = TRUE;
                $this->return_as              = 'object';
                $this->timestamps_format      = 'timestamp';
                parent::__construct();
        }

}
