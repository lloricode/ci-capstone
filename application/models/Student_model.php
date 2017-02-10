<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'students';
                $this->primary_key = 'student_id';

                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );

//                $this->has_many_pivot['subjects'] = array(
//                    'foreign_model'     => 'Students_subjects_model',
//                    'pivot_table'       => 'subjects', //wher ok
//                    'local_key'         => 'student_id',
//                    'pivot_local_key'   => 'student_id', //wwwwwre ok
//                    /* this is the related key in the pivot table to the local key
//                      this is an optional key, but if your column name inside the pivot table
//                      doesn't respect the format of "singularlocaltable_primarykey", then you must set it. In the next title
//                      you will see how a pivot table should be set, if you want to  skip these keys */
//                    'pivot_foreign_key' => 'student_id', /* this is also optional, the same as above, but for foreign table's keys */
//                    'foreign_key'       => 'student_id',
//                    'get_relate'        => FALSE /* another optional setting, which is explained below */
//                );

                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
