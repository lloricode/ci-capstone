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
                $this->has_one['curriculum']  = array(
                    'foreign_model' => 'Curriculum_model',
                    'foreign_table' => 'curriculums',
                    'foreign_key'   => 'curriculum_id',
                    'local_key'     => 'curriculum_id'
                );
                $this->has_one['subject']     = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                $this->has_one['subject_pre'] = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id_pre'
                );
                $this->has_one['subject_co']  = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id_co'
                );
                $this->has_one['user']        = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'created_user_id'
                );
                /**
                 * subject offer
                 */
                $this->has_many['subject_offers']        = array(
                    'foreign_model' => 'Subject_offer_model',
                    'foreign_table' => 'subject_offers',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
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
                    'curriculum_subject_year_level'       => array(
                        'label' => lang('curriculum_subject_year_level_label'),
                        'field' => 'level',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
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
                        'rules' => 'trim|required|is_natural_no_zero|differs[pre_requisite]|differs[co_requisite]|callback_check_subject_in_curiculum'
                    ),
                    'subject_id_pre'                      => array(
                        'label' => lang('curriculum_subject_pre_subject_label'),
                        'field' => 'pre_requisite',
                        'rules' => 'trim|is_natural_no_zero|differs[co_requisite]|differs[subject]|callback_is_pre_requisite_low_level'
                    ),
                    'subject_id_co'                       => array(
                        'label' => lang('curriculum_subject_co_subject_label'),
                        'field' => 'co_requisite',
                        'rules' => 'trim|is_natural_no_zero|differs[pre_requisite]|differs[subject]|callback_is_co_requisite_same_level'
                    ),
                );
        }

        private function _update()
        {
                return array();
        }

}
