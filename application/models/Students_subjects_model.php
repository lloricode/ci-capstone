<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Students_subjects_model extends MY_Model
{

        public function __construct()
        {
                $this->table                   = 'students_subjects';
                $this->primary_key             = 'id';
                $this->has_one['users']        = array(
                    'foreign_model' => 'Users_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'user_id'
                );
                $this->has_one['subjects']        = array(
                    'foreign_model' => 'Subjects_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                $this->has_one['students']    = array(
                    'foreign_model' => 'Student_model',
                    'foreign_table' => 'students',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
               // $this->has_many_pivot['students'] = 'Student_model';
                $this->timestamps              = TRUE;
                $this->return_as               = 'object';
                parent::__construct();
        }

}
