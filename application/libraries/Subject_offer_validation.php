<?php

defined('BASEPATH') or exit('no direct script allowed');

class Subject_offer_validation
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
        private $input_data_days;

        /**
         * fields
         */
        private $days;

        /**
         * 
         */
        private $affected_rows;
        private $subject_offer_conflict_result_object;
        private $enable_migrate;

        public function __construct()
        {
                $this->enable_migrate        = FALSE;
                $this->CI                    = &get_instance();
                $this->CI->load->model(array(
                    'Subject_offer_model'
                ));
                $this->CI->load->helper(array(
                    'day'
                ));
                $this->error_strat_delimeter = $this->CI->config->item('error_start_delimiter', 'ion_auth');
                $this->error_end_delimeter   = $this->CI->config->item('error_end_delimiter', 'ion_auth');
                $this->days                  = days_for_db();
        }

        public function init($method = NULL)
        {
                if (is_null($method))
                {
                        show_error('init method required in ' . get_class() . ' class.');
                }
                switch ($method)
                {
                        case 'post':
                                $this->post();
                                break;
                        case 'migrate':
                                $this->enable_migrate = TRUE;
                                break;
                        default :
                                show_error('parameter invalid in ' . get_class() . ' class.');
                }
        }

        private function post()
        {
                /**
                 * calling this in controller ,so directly access will this, so better check if button in form is triggered.
                 */
                if ((bool) $this->CI->input->post('submit'))
                {
                        /**
                         * set foreign ids
                         */
                        $this->user_id    = $this->CI->input->post('faculty', TRUE);
                        $this->room_id    = $this->CI->input->post('room', TRUE);
                        $this->subject_id = $this->CI->input->post('subject', TRUE);
                        $this->start      = $this->CI->input->post('start', TRUE);
                        $this->end        = $this->CI->input->post('end', TRUE);

                        foreach ($this->days as $v)
                        {
                                $this->input_data_days['subject_offer_' . $v] = (is_null($this->CI->input->post($v, TRUE)) ? FALSE : TRUE);
                        }
                }
                else
                {
                        show_error('Invalid Request.');
                }
        }

        public function migrate_test($sub_offr)
        {
                if (!$this->enable_migrate)
                {
                        show_error('must enable migrate test in ' . get_class() . ' class.');
                }
                /**
                 * set foreign ids
                 */
                $this->user_id    = $sub_offr['user_id'];
                $this->room_id    = $sub_offr['room_id'];
                $this->subject_id = $sub_offr['subject_id'];
                $this->start      = $sub_offr['subject_offer_start'];
                $this->end        = $sub_offr['subject_offer_end'];

                foreach ($this->days as $v)
                {
                        $this->input_data_days['subject_offer_' . $v] = $sub_offr['subject_offer_' . $v];
                }
        }

        /**
         * 
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function subject_offer_check_check_conflict()
        {
                /**
                 * generate name for db cache, so i will use all post value to be using
                 */
                $db_cache_name = '';
                foreach ($this->CI->input->post() as $p)
                {
                        $tmp           = str_replace(' ', '_', $p);
                        $db_cache_name .= $tmp . '_';
                }
                $db_cache_name = trim($db_cache_name, '_');

                $foriegn_ids = array();
                $days        = array();


                $atleast_one_day = FALSE;
                /**
                 * populate days with value from input
                 */
                foreach ($this->input_data_days as $k => $v)
                {
                        if ($v)
                        {
                                $atleast_one_day = TRUE;
                                $days[$k]        = $v;
                        }
                }
                if (!$atleast_one_day)
                {
                        if (!$this->enable_migrate)
                        {

                                $this->CI->form_validation->set_message(
                                        'subject_offer_check_check_conflict', $this->error_strat_delimeter .
                                        'Days required.' .
                                        $this->error_end_delimeter);
                        }
                        return FALSE;
                }
                $foriegn_ids['user_id']                     = $this->user_id;
                $foriegn_ids['room_id']                     = $this->room_id;
                $foriegn_ids['subject_id']                  = $this->subject_id;
                /**
                 * 
                 * generate a query
                 * then get result set, for the view of conflict subject offer
                 */
                $this->subject_offer_conflict_result_object = $this->CI->Subject_offer_model->
                        //**********
                        group_start()->//big start
                        //::::::::::::::::::::::::::::::
                        //----------------------------------------------------------------------------------1
                        /**
                         * 
                         * input
                         * AM                               PM
                         *           |---------------|
                         * |----------------|
                         * 
                         * db
                         * 
                         * 
                         */
                        #1
                        or_group_start()->
                        where('subject_offer_start <= ', $this->start)->
                        where('subject_offer_start <= ', $this->end)->
                        where('subject_offer_end > ', $this->start)->
                        where('subject_offer_end <= ', $this->end)->
                        group_end()->
                        //----------------------------------------------------------------------------------2

                        /**
                         * 
                         * input
                         * 
                         *     |---------------|
                         *            |------------------|
                         * 
                         * db
                         * 
                         * 
                         */
                        #2
                        or_group_start()->
                        where('subject_offer_start >= ', $this->start)->
                        where('subject_offer_start < ', $this->end)->
                        where('subject_offer_end >= ', $this->start)->
                        where('subject_offer_end >= ', $this->end)->
                        group_end()->
                        //----------------------------------------------------------------------------------3
                        /**
                         * 
                         * input
                         * 
                         *         |---------------|
                         * |--------------------------------|
                         * 
                         * db
                         * 
                         * 
                         */
                        #3
                        or_group_start()->
                        where('subject_offer_start <= ', $this->start)->
                        where('subject_offer_start < ', $this->end)->
                        where('subject_offer_end > ', $this->start)->
                        where('subject_offer_end >= ', $this->end)->
                        group_end()->
                        //----------------------------------------------------------------------------------4
                        /**
                         * 
                         * input
                         * 
                         *  |--------------------------------|
                         *           |----------------|
                         * 
                         * db
                         * 
                         * 
                         */
                        #4
                        or_group_start()->
                        where('subject_offer_start >= ', $this->start)->
                        where('subject_offer_start < ', $this->end)->
                        where('subject_offer_end > ', $this->start)->
                        where('subject_offer_end <= ', $this->end)->
                        group_end()->
                        //::::::::::::::::::::::::::::::
                        //----------------------------------------------------------------------------------end



                        group_end()->//big end
                        //**********

                        /**
                         * 
                         * 
                         * user | room | subject
                         * foreign key
                         */
                        group_start()->
                        or_where($foriegn_ids)->
                        group_end()->
                        //------------

                        /**
                         * 
                         * 
                         * days
                         */
                        group_start()->
                        or_where($days)->
                        group_end()->
                        //-----------
                        set_cache('subject_offer_check_check_conflict_' . $db_cache_name)->
                        get_all();

                /**
                 * get affected row count
                 */
                $this->affected_rows = $this->CI->db->affected_rows();

                /**
                 * set error/invalid message
                 */
                if (!$this->enable_migrate)
                {
                        $this->CI->form_validation->set_message(
                                'subject_offer_check_check_conflict', $this->error_strat_delimeter .
                                'Conflict ' . $this->affected_rows .
//                                ' schedules.' .
//                                '<pre>' .
//                                $this->CI->db->last_query() .
//                                '</pre>' .
                                $this->error_end_delimeter);
                }

                return (bool) ($this->affected_rows == 0);
                //return FALSE;
        }

        public function conflict()
        {
                $sub_off = array();
                if ($this->affected_rows > 0)
                {
                        foreach ($this->subject_offer_conflict_result_object as $row)
                        {
                                $sub_off[] = $this->CI->Subject_offer_model->get($row->subject_offer_id);
                        }
                        return $sub_off;
                }
                return FALSE;
                // return 'test data confict [not implemented yet]<br />' . $this->CI->db->last_query();
        }

}
