<?php

defined('BASEPATH') or exit('no direct script allowed');

class Subject_offer
{


        private $CI;
        private $error_strat_delimeter;
        private $error_end_delimeter;

        #ids
        private $user_id;
        private $room_id;
        private $subject_id;

        #time
        private $start;
        private $end;

        /**
         *
         * @var array inputs
         */
        private $input_data;

        /**
         * fields
         */
        private $days;

        public function __construct()
        {
                $this->days                  = array(
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                );
                $this->CI                    = &get_instance();
                $this->CI->load->model(array(
                    'Subject_offer_model'
                ));
                $this->error_strat_delimeter = $this->CI->config->item('error_start_delimiter', 'ion_auth');
                $this->error_end_delimeter   = $this->CI->config->item('error_end_delimiter', 'ion_auth');
                /**
                 * set foreign ids
                 */
                $this->user_id               = $this->CI->input->post('user_id', TRUE);
                $this->room_id               = $this->CI->input->post('room_id', TRUE);
                $this->subject_id            = $this->CI->input->post('subject_id', TRUE);
                $this->start                 = $this->CI->input->post('subject_offer_start', TRUE);
                $this->end                   = $this->CI->input->post('subject_offer_end', TRUE);

                foreach ($this->days as $v)
                {
                        $this->input_data['subject_offer_' . $v] = (is_null($this->CI->input->post('subject_offer_' . $v, TRUE)) ? FALSE : TRUE);
                }
        }

        public function subject_offer_check_check_conflict()
        {
                $this->CI->form_validation->set_message('subject_offer_check_check_conflict', $this->error_strat_delimeter .
                        'this is test conflict message.' .
                        //   'Conflict Schedule, see table above.' .
                        $this->error_end_delimeter);
                $where_ = array();

                foreach ($this->input_data as $k => $v)
                {
                        $where_[$k] = $v;
                }
                $where_['subject_offer_start'] = $this->start;
                $where_['subject_offer_end']   = $this->end;
                $where_['user_id']             = $this->user_id;
                $where_['room_id']             = $this->room_id;
                $where_['subject_id']          = $this->subject_id;
                $this->CI->Subject_offer_model->where($where_)->get_all();
                return FALSE;
        }

        public function conflict()
        {
                return 'test data confict [not implemented yet]<br />' . $this->CI->db->last_query();
        }

}
