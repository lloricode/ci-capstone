<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_offer_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subject_offers';
                $this->primary_key = 'subject_offer_id';


                $this->_relations();
                $this->_form();

                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';

                /**
                 * some of field is not required,in this model, atleast one day is required, so other will exclude in array
                 */
                $this->remove_empty_before_write = TRUE;

                parent::__construct();
        }

        private function _relations()
        {

                $this->has_one['subject'] = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                $this->has_one['room']    = array(
                    'foreign_model' => 'Room_model',
                    'foreign_table' => 'rooms',
                    'foreign_key'   => 'room_id',
                    'local_key'     => 'room_id'
                );
                $this->has_one['faculty'] = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'user_id'
                );
        }

        private function _form()
        {
                $this->lang->load('ci_capstone/ci_subject_offers');
                $this->load->helper('day');

                $__insert__ = $this->_insert();
                foreach (days_for_db() as $d)
                {

                        /**
                         * days
                         */
                        $__insert__['subject_offer_' . $d] = array(
                            'label' => ucfirst($d),
                            'field' => $d,
                            'rules' => '',
                        );
                }
             //   echo print_r($__insert__);
                $this->rules = array(
                    'insert' => $__insert__,
                    'update' => $this->_update()
                );
        }

        private function _insert()
        {
                return array(
                    'subject_offer_start' => array(
                        'label' => lang('create_subject_offer_start_label'),
                        'field' => 'start',
                        'rules' => 'required|trim|min_length[3]|max_length[5]|time_24hr|time_24hr|'
                        . 'time_lessthan[' . $this->input->post('end', TRUE) . ']|'
                        . 'callback_subject_offer_check_check_conflict',
                    ),
                    'subject_offer_end'   => array(
                        'label' => lang('create_subject_offer_end_label'),
                        'field' => 'end',
                        'rules' => 'required|trim|min_length[3]|max_length[5]',
                    ),
                    'user_id'             => array(
                        'label' => lang('create_user_id_label'),
                        'field' => 'faculty',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    'subject_id'          => array(
                        'label' => lang('create_subject_id_label'),
                        'field' => 'subject',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    'room_id'             => array(
                        'label' => lang('create_room_id_label'),
                        'field' => 'room',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
//                    array(
//                        'label' => 'Subject Offer',
//                        'field' => 'subject_offer_check_check_conflict',
//                        'rules' => 'callback_subject_offer_check_check_conflict',
//                    ),
                );
        }

        private function _update()
        {
                return array(
                );
        }

}
