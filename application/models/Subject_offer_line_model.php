<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_offer_line_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subject_offer_line';
                $this->primary_key = 'subject_offer_line_id';


                $this->_relations();
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver              = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix              = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                $this->remove_empty_before_write = TRUE; //(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save      = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
//
//                $this->has_one['subject'] = array(
//                    'foreign_model' => 'Subject_model',
//                    'foreign_table' => 'subjects',
//                    'foreign_key'   => 'subject_id',
//                    'local_key'     => 'subject_id'
//                );
                $this->has_one['room'] = array(
                    'foreign_model' => 'Room_model',
                    'foreign_table' => 'rooms',
                    'foreign_key'   => 'room_id',
                    'local_key'     => 'room_id'
                );
//                $this->has_one['faculty'] = array(
//                    'foreign_model' => 'User_model',
//                    'foreign_table' => 'users',
//                    'foreign_key'   => 'id',
//                    'local_key'     => 'user_id'
//                );
        }

        public function insert_validations()
        {
                $validation = array(
                    array(
                        'label' => lang('create_subject_offer_start_label'),
                        'field' => 'start',
                        'rules' => 'required|trim|min_length[3]|max_length[5]|time_24hr|time_24hr|'
                        . 'time_lessthan[' . $this->input->post('end', TRUE) . ']|'
                        . 'callback_subject_offer_check_check_conflict',
                    ),
                    array(
                        'label' => lang('create_subject_offer_end_label'),
                        'field' => 'end',
                        'rules' => 'required|trim|min_length[3]|max_length[5]',
                    ),
                    array(
                        'label' => lang('create_room_id_label'),
                        'field' => 'room',
                        'rules' => 'trim|required|is_natural_no_zero',
                    )
                );
                $this->load->helper('day');
                /**
                 * additional for days
                 */
                foreach (days_for_db() as $d)
                {

                        /**
                         * days
                         */
                        $validation[] = array(
                            'label' => ucfirst($d),
                            'field' => $d,
                            'rules' => '', //not all required
                        );
                }

                return $validation;
        }

        public function insert_validations2()
        {
                $validation = array(
                    array(
                        'label' => lang('create_subject_offer_start_label'),
                        'field' => 'start2',
                        'rules' => 'required|trim|min_length[3]|max_length[5]|time_24hr|time_24hr|'
                        . 'time_lessthan[' . $this->input->post('end2', TRUE) . ']|'
                        . 'callback_subject_offer_check_check_conflict[2]',
                    ),
                    array(
                        'label' => lang('create_subject_offer_end_label'),
                        'field' => 'end2',
                        'rules' => 'required|trim|min_length[3]|max_length[5]',
                    ),
                    'room_id' => array(
                        'label' => lang('create_room_id_label'),
                        'field' => 'room2',
                        'rules' => 'trim|required|is_natural_no_zero',
                    )
                );
                $this->load->helper('day');
                /**
                 * additional for days
                 */
                foreach (days_for_db() as $d)
                {

                        /**
                         * days
                         */
                        $validation[] = array(
                            'label' => ucfirst($d),
                            'field' => $d . '2',
                            'rules' => '', //not all required
                        );
                }

                return $validation;
        }

}
