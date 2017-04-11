<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_info_model extends MY_Model
{

        public function __construct()
        {
                $this->table = 'report_info';

                $this->before_create[] = '_delete_all';
                $this->_config();
                $this->_form();
                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //   $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                //$this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        /**
         * this will call before insert 
         */
        protected function _delete_all($data)
        {
                $this->db->empty_table($this->table);
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }
        
          private function _form()
        {

                $this->rules = array(
                    'insert' => array(
                       
                        'school_name' => array(
                            'label' => lang('report_info_name_validation'),
                            'field' => 'name',
                            'rules' => 'trim|required|min_length[1]|max_length[100]'
                        ),
                        'school_address' => array(
                            'label' => lang('report_info_address_validation'),
                            'field' => 'address',
                            'rules' => 'trim|required|min_length[1]|max_length[100]'
                        ),
                        'school_contact' => array(
                            'label' => lang('report_info_contact_validation'),
                            'field' => 'contact',
                            'rules' => 'trim|required|min_length[1]|max_length[100]'
                        )
                    )
                );
        }

}
