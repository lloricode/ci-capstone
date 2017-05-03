<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Unit_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'units';
                $this->primary_key = 'unit_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

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
                // $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        public function insert_validation()
        {
                $lec = (int) $this->input->post('lecture', TRUE);
                $lab = (int) $this->input->post('laboratory', TRUE);
                return array(
                    array(//unit_value
                        'label' => lang('unit_unit_label'),
                        'field' => 'units',
                        'rules' => "trim|required|min_length[1]|max_length[2]|is_natural_no_zero|is_unit_relate_types[$lec.$lab]"
                    ),
                    array(//lec_value
                        'label' => lang('unit_lec_label'),
                        'field' => 'lecture',
                        'rules' => 'trim|required|min_length[1]|max_length[2]|is_natural'
                    ),
                    array(//lab_value
                        'label' => lang('unit_lab_label'),
                        'field' => 'laboratory',
                        'rules' => 'trim|required|min_length[1]|max_length[2]|is_natural'
                    ),
                );
        }

}
