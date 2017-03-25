<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Curriculum_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'curriculums';
                $this->primary_key = 'curriculum_id';

                $this->_relations();
                $this->_form();
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver              = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix              = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                $this->remove_empty_before_write = TRUE; //(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save      = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_one['course']      = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'courses',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );
                /**
                 * seperated table
                 */
                $this->has_many['requisites'] = array(
                    'foreign_model' => 'Requisites_model',
                    'foreign_table' => 'requisites',
                    'foreign_key'   => 'curriculum_subject_id',
                    'local_key'     => 'curriculum_subject_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => $this->_insert(),
                    'update' => $this->_update()
                );
        }

        private function _common()
        {
                return array();
        }

        private function _insert()
        {
                return array(
                    'curriculum_description'           => array(
                        'label' => lang('curriculumn_description'),
                        'field' => 'desc',
                        'rules' => 'trim|required|min_length[2]|max_length[100]'
                    ),
                    'curriculum_effective_school_year' => array(
                        'label' => lang('curriculumn_effective_year'),
                        'field' => 'year',
                        'rules' => 'trim|required|exact_length[9]'
                    ),
                    'curriculum_status'                => array(
                        'label' => lang('curriculumn_status'),
                        'field' => 'status',
                        'rules' => 'trim'
                    ),
                    'course_id'                        => array(
                        'label' => lang('curriculumn_course'),
                        'field' => 'course',
                        'rules' => 'trim|is_natural_no_zero|required'
                    ),
                );
        }

        private function _update()
        {
                return array();
        }

}
