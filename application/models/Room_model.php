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

                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
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
