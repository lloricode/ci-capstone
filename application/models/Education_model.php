<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Education_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'educations';
                $this->primary_key = 'education_id';

                $this->_relations();
                $this->_form();

                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

        private function _relations()
        {
                $this->has_many['course'] = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'courses',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );
        }

        private function _form()
        {
                $this->lang->load('ci_capstone/ci_educations');

                $this->rules = array(
                    'insert' => array(
                        'education_code'        => array(
                            'label'  => lang('create_education_code_label'),
                            'field'  => 'code',
                            'rules'  => 'trim|required|is_unique[educations.education_code]|min_length[2]|max_length[20]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'education_description' => array(
                            'label'  => lang('create_education_description_label'),
                            'field'  => 'description',
                            'rules'  => 'trim|required|human_name|min_length[2]|max_length[50]|is_unique[educations.education_description]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                    ),
                    'update' => array(
                        'education_code'        => array(
                            'label'  => lang('create_education_code_label'),
                            'field'  => 'code',
                            'rules'  => 'trim|required|is_unique[educations.education_code]|min_length[2]|max_length[20]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'education_description' => array(
                            'label'  => lang('create_education_description_label'),
                            'field'  => 'description',
                            'rules'  => 'trim|required|human_name|min_length[2]|max_length[50]|is_unique[educations.education_description]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'id'                    => array(
                            'field' => 'id',
                            'label' => 'ID',
                            'rules' => 'trim|is_natural_no_zero|required'
                        ),
                    )
                );
        }

}
