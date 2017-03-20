<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Requisites_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'requisites';
                $this->primary_key = 'requisite_id';

                $this->_relations();
                // $this->_form();
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
                $this->has_one['subjects'] = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
//                $this->has_one['type']     = array(
//                    'foreign_model' => 'Requisite_typae_model',
//                    'foreign_table' => 'requisite_types',
//                    'foreign_key'   => 'requisite_id',
//                    'local_key'     => 'requisite_id'
//                );
        }

        public function validations()
        {

//                $this->rules = array(
//                    'insert' =>
                return array(
                    array(
                        'label'  => lang('requisite_co_type_label'),
                        'field'  => 'co[]',
                        'rules'  => 'trim|is_natural_no_zero|differs_array_from_another_array[pre[]]',
                        'errors' => array(
                            'differs_array_from_another_array' => 'Must differ from ' . lang('requisite_pre_type_label') . '.'
                        )
                    ),
                    array(
                        'label'  => lang('requisite_pre_type_label'),
                        'field'  => 'pre[]',
                        'rules'  => 'trim|is_natural_no_zero|differs_array_from_another_array[co[]]',
                        'errors' => array(
                            'differs_array_from_another_array' => 'Must differ from ' . lang('requisite_co_type_label') . '.'
                        )
                    ),
                    array(
                        'label' => lang('requisite_label'),
                        'field' => 'tmp_is_atleast_one', //will use to show error in ci_validation
                        'rules' => 'callback_is_atleast_one'//just to callback this validator
                    ),
                );
//                    'update' => array()
//                );
        }

        /**
         * 
         * @param object $requisites
         * @return object co|pre
         */
        public function subjects($requisites = NULL)
        {
                //print_r($requisites);
                $pre = '';
                $co  = '';
                if (isset($requisites))
                {
                        if ($requisites)
                        {
                                foreach ($requisites as $r)
                                {
                                        ${$r->requisite_type} .= $r->subjects->subject_code . br();
                                }
                        }
                }
                return (object) (array(
                    'pre' => ($pre == '') ? '--' : trim($pre, br()),
                    'co'  => ($co == '') ? '--' : trim($co, br())
                ));
        }

}
