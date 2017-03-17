<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Requisites_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'requisites';
                $this->primary_key = 'requisite_id';

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


                $this->cache_driver         = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix         = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //  $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
//                $this->has_one['students_subjects'] = array(
//                    'foreign_model' => 'Students_subjects_model',
//                    'foreign_table' => 'students_subjects',
//                    'foreign_key'   => 'user_id',
//                    'local_key'     => 'id'
//                );
//                $this->has_one['subject_offers']    = array(
//                    'foreign_model' => 'Subject_offer_model',
//                    'foreign_table' => 'subject_offers',
//                    'foreign_key'   => 'subject_offer_id',
//                    'local_key'     => 'subject_offer_id'
//                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => array(
                        'requisite_curriculum_subject_id' => array(
                            'label' => lang('requisite_subject_label'),
                            'field' => 'requisite_subject[]',
                            'rules' => 'trim|is_natural_no_zero|required'
                        ),
                        'requisite_type'                  => array(
                            'label' => lang('requisite_type_label'),
                            'field' => 'type',
                            'rules' => 'trim|required'
                        ),
                    ),
                    'update' => array()
                );
        }

}
