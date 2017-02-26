<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subjects';
                $this->primary_key = 'subject_id';

                $this->_relations();
                $this->_form();
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = (bool) $this->config->item('my_model_timestamps');
                $this->return_as         = $this->config->item('my_model_return_as');
                $this->timestamps_format = $this->config->item('my_model_timestamps_format');


                $this->cache_driver = $this->config->item('my_model_cache_driver');
                $this->cache_prefix = $this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //$this->remove_empty_before_write = (bool) $this->config->item('my_model_remove_empty_before_write');
                //$this->delete_cache_on_save      = (bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
        }

        private function _form()
        {
                $this->lang->load('ci_capstone/ci_subjects');

                $this->rules = array(
                    'insert' => array(
                        'subject_code'        => array(
                            'label'  => lang('create_subject_code_label'),
                            'field'  => 'code',
                            'rules'  => 'trim|required|is_unique[subjects.subject_code]|min_length[3]|max_length[20]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'subject_description' => array(
                            'label'  => lang('create_subject_description_label'),
                            'field'  => 'desc',
                            'rules'  => 'trim|required|human_name|min_length[3]|max_length[50]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'subject_unit'        => array(
                            'label'  => lang('create_subject_unit_label'),
                            'field'  => 'unit',
                            'rules'  => 'trim|required|is_natural_no_zero',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                    ),
                );
        }

}
