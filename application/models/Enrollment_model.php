<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Enrollment_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'enrollments';
                $this->primary_key = 'enrollment_id';


                $this->has_one['course'] = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'courses',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );


                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'id',
                    'local_key'     => 'id'
                );
                $this->timestamps                    = TRUE;
                $this->return_as                     = 'object';
                $this->timestamps_format             = 'timestamp';
                parent::__construct();
        }

}
