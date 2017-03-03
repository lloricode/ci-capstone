<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Curriculum_subject_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'curriculum_subjects';
                $this->primary_key = 'curriculum_subject_id';

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
//                $this->has_many['course'] = array(
//                    'foreign_model' => 'Course_model',
//                    'foreign_table' => 'courses',
//                    'foreign_key'   => 'course_id',
//                    'local_key'     => 'course_id'
//                );
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

        private function _inlist_semesters()
        {
                $this->load->helper('school');
                $return = '';
                foreach (semesters() as $k => $v)
                {
                        $return .= $k . ',';
                }
                $return = trim($return, ',');
                return $return;
        }

        private function _insert()
        {
                return array(
                    'curriculum_subject_semester'         => array(
                        'label'  => lang('curriculum_subject_semester_label'),
                        'field'  => 'semester',
                        'rules'  => 'trim|required|in_list[' . $this->_inlist_semesters() . ']', //must be specific value needed,table type type in enum
                        'errors' => array(
                            'in_list' => 'Invalid value in {field}'
                        )
                    ),
                    'curriculum_subject_units'            => array(
                        'label' => lang('curriculum_subject_units_label'),
                        'field' => 'units',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
                    'curriculum_subject_lecture_hours'    => array(
                        'label' => lang('curriculum_subject_lecture_hours_label'),
                        'field' => 'lecture',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
                    'curriculum_subject_laboratory_hours' => array(
                        'label' => lang('curriculum_subject_laboratory_hours_label'),
                        'field' => 'laboratory',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
                    'curriculum_id'                       => array(
                        'label' => lang('curriculum_subject_curriculum_label'),
                        'field' => 'curriculum',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
                    'subject_id'                          => array(
                        'label' => lang('curriculum_subject_subject_label'),
                        'field' => 'subject',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
                    'subject_id_pre'                      => array(
                        'label' => lang('curriculum_subject_pre_subject_label'),
                        'field' => 'pre_requisite',
                        'rules' => 'trim|is_natural_no_zero|differs[co_requisite]'//no co with the same in pre
                    ),
                    'subject_id_co'                       => array(
                        'label' => lang('curriculum_subject_co_subject_label'),
                        'field' => 'co_requisite',
                        'rules' => 'trim|is_natural_no_zero|differs[pre_requisite]'//no co with the same in pre
                    ),
                );
        }

        private function _update()
        {
                return array();
        }

}
