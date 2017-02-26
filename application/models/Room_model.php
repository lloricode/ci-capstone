<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Room_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'rooms';
                $this->primary_key = 'room_id';

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
                $this->has_many['subject_offer'] = array(
                    'foreign_model' => 'Subject_offer_model',
                    'foreign_table' => 'subject_offers',
                    'foreign_key'   => 'subject_offer_id',
                    'local_key'     => 'subject_offer_id'
                );
        }

        private function _form()
        {
                $this->lang->load('ci_capstone/ci_rooms');

                $this->rules = array(
                    'insert' => array(
                        'room_number'      => array(
                            'label'  => lang('create_room_number_label'),
                            'field'  => 'number',
                            'rules'  => 'trim|required|numeric|min_length[1]|max_length[30]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'room_description' => array(
                            'label'  => lang('create_room_description_label'),
                            'field'  => 'description',
                            'rules'  => 'trim|required|human_name|min_length[3]|max_length[30]', 'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                    ),
                );
        }

}
