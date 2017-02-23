<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'courses';
                $this->primary_key = 'course_id';

                $this->_relations();
                $this->_form();

                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

        private function _relations()
        {
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
        }

        private function _form()
        {
                $this->lang->load('ci_capstone/ci_courses');

                $this->rules = array(
                    'insert' => array(
                        'course_code' => array(
                            'label' => lang('index_course_code_th'),
                            'field' => 'code',
                            'rules' => 'trim|required|human_name|min_length[2]|max_length[50]',
                        ),
                        'course_description' => array(
                            'label' => lang('index_course_desc_th'),
                            'field' => 'desc',
                            'rules' => 'trim|required|human_name|min_length[2]|max_length[50]',
                        ),
                        'course_code_id'   => array(
                            'label' => lang('index_course_code_id_th'),
                            'field' => 'id',
                            'rules' => 'trim|required|min_length[2]|max_length[5]|is_natural_no_zero',
                        ),
                        'education_id' => array(
                            'label' => lang('index_course_education_th'),
                            'field' => 'educ',
                            'rules' => 'trim|required|is_natural_no_zero',
                        ),
                    ),
                    'update' => array(
                        'code'     => array(
                            'label' => lang('index_course_code_th'),
                            'field' => 'code',
                            'rules' => 'trim|required|human_name|min_length[2]|max_length[50]',
                        ),
                        'desc'     => array(
                            'label' => lang('index_course_desc_th'),
                            'field' => 'desc',
                            'rules' => 'trim|required|human_name|min_length[2]|max_length[50]',
                        ),
                        'id'       => array(
                            'label' => lang('index_course_code_id_th'),
                            'field' => 'id',
                            'rules' => 'trim|required|min_length[2]|max_length[5]|is_natural_no_zero',
                        ),
                        'educ'     => array(
                            'label' => lang('index_course_education_th'),
                            'field' => 'educ',
                            'rules' => 'trim|required|is_natural_no_zero',
                        ),
                        'courseid' => array(
                            'field' => 'courseid',
                            'label' => 'ID',
                            'rules' => 'trim|is_natural_no_zero|required'
                        ),
                    )
                );
        }

}
