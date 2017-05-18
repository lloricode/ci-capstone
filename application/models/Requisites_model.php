<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Requisites_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'requisites';
                $this->primary_key = 'requisite_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

                $this->_relations();
                $this->_config();

                parent::__construct();
        }

        protected function _add_created_by($data)
        {
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
                $data['updated_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
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
                $this->has_one['subjects'] = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
        }

        public function validations()
        {
                return array(
                    array(
                        'label' => lang('requisite_co_type_label'),
                        'field' => 'co[]',
                        'rules' => 'trim|is_natural_no_zero|differs_array_from_another_array[pre[].Subject_model.subject_code]|'
                        . 'callback_is_co_requisite_same_level_and_semester'
                    ),
                    array(
                        'label' => lang('requisite_pre_type_label'),
                        'field' => 'pre[]',
                        'rules' => 'trim|is_natural_no_zero|differs_array_from_another_array[co[].Subject_model.subject_code]|'
                        . 'callback_is_pre_requisite_low_level_and_semester'
                    ),
                    array(
                        'label' => lang('requisite_label'),
                        'field' => 'tmp_is_atleast_one', //will use to show error in ci_validation
                        'rules' => 'callback_is_atleast_one'//just to callback this validator
                    )
                );
        }

        /**
         * 
         * @param object $requisites
         * @return object co|pre
         */
        public function subjects($requisites = NULL, $delimeter = ', ')
        {
                $pre = '';
                $co  = '';
                if (isset($requisites))
                {
                        if ($requisites)
                        {
                                foreach ($requisites as $r)
                                {
                                        ${$r->requisite_type} .= $r->subjects->subject_code . $delimeter;
                                }
                                ${$r->requisite_type} = trim(${$r->requisite_type}, $delimeter);
                        }
                }
                return (object) (array(
                    'pre' => ($pre == '') ? '--' : $pre,
                    'co'  => ($co == '') ? '--' : $co
                ));
        }

}
