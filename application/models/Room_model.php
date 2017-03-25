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

                $this->rules = array(
                    'insert' => array(
                        'room_number' => array(
                            'label'  => lang('create_room_number_label'),
                            'field'  => 'number',
                            'rules'  => 'trim|required|min_length[1]|max_length[50]|is_unique[rooms.room_number]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        )
                    )
                );
        }

}
