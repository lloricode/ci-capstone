<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Students_subjects_model extends MY_Model
{

        public function __construct()
        {
                $this->table            = 'students_subjects';
                $this->primary_key      = 'student_subject_id';
                $this->has_one['users'] = array(
                    'foreign_model' => 'Users_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'user_id'
                );



                $this->has_one['enrollments'] = array(
                    'foreign_model' => 'Enrollment_model',
                    'foreign_table' => 'enrollments',
                    'foreign_key'   => 'enrollment_id',
                    'local_key'     => 'enrollment_id'
                );


                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
