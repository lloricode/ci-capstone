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
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = TRUE;//(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object';//$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp';//$this->config->item('my_model_timestamps_format');


                $this->cache_driver              = 'file';//$this->config->item('my_model_cache_driver');
                $this->cache_prefix              = 'cicapstone';//$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save      = TRUE;//(bool) $this->config->item('my_model_delete_cache_on_save');
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
