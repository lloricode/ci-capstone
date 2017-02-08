<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subjects_model extends MY_Model
{

        public function __construct()
        {
                $this->table                         = 'subjects';
                $this->primary_key                   = 'subject_id';
                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                //  $this->has_many_pivot['students'] = 'Student_model';

                $this->timestamps = TRUE;
                $this->return_as  = 'object';

                parent::__construct();
        }

}
