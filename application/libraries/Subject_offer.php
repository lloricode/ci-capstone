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
         *
         * database table
         */
        private $table;

        /**
         * fields
         */
        private $days;

        /**
         * 
         */
        private $affected_rows;
        private $rs;

        public function __construct()
        {
                $this->table                 = 'subject_offers';
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
                $or_where_foriegn = array();
                $or_where_days    = array();

                foreach ($this->input_data as $k => $v)
                {
                        $or_where_days[$k] = $v;
                }
                // $where_['subject_offer_start'] = $this->start;
                //  $where_['subject_offer_end']   = $this->end;
                $or_where_foriegn['user_id']    = $this->user_id;
                $or_where_foriegn['room_id']    = $this->room_id;
                $or_where_foriegn['subject_id'] = $this->subject_id;
                $this->rs                       = $this->CI->db->select('*')->
                        //----------
                        group_start()->
                        where('subject_offer_start >= ', $this->start)->
                        where('subject_offer_end <= ', $this->end)->
                        group_end()->
                        //----------
                        or_group_start()->
                        where($or_where_foriegn)->
                        group_end()->
                        //------------
                        or_group_start()->
                        where($or_where_days)->
                        group_end()->
                        get($this->table); //->count_all_results();
//                $this->CI->Subject_offer_model->where($where_)->get_all();
                $this->affected_rows            = $this->CI->db->affected_rows();
                $this->CI->form_validation->set_message('subject_offer_check_check_conflict', $this->error_strat_delimeter .
                        'Confict ' . $this->affected_rows . ' schedules.[<pre>' . $this->CI->db->last_query() .'</pre>'.
                        //   'Conflict Schedule, see table above.' .
                        $this->error_end_delimeter);
                // return (bool) $this->affected_rows == 0;
                return FALSE;
        }

        public function conflict()
        {
                $sub_off = array();
                if ($this->affected_rows > 0)
                {
                        foreach ($this->rs->result() as $row)
                        {
                                $sub_off[] = $this->CI->Subject_offer_model->get($row->subject_offer_id);
                        }
                        return $sub_off;
                }
                return FALSE;
                // return 'test data confict [not implemented yet]<br />' . $this->CI->db->last_query();
        }

}
