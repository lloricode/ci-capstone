<?php

defined('BASEPATH') or exit('no direct script allowed');

class Subject_offer_validation
{


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
        public $form_;

        /**
         * 
         */
        private $affected_rows;
        private $subject_offer_line_conflict_result_object;
        private $enable_migrate;

        public function __construct()
        {
                $this->enable_migrate        = FALSE;
                $this->load->model(array(
                    'Subject_offer_line_model'
                ));
                $this->load->helper(array(
                    'day'
                ));
                $this->error_strat_delimeter = $this->config->item('error_start_delimiter', 'ion_auth');
                $this->error_end_delimeter   = $this->config->item('error_end_delimiter', 'ion_auth');
                $this->days                  = days_for_db();
        }

        public function reset__()
        {


                $this->error_strat_delimeter = NULL;
                $this->error_end_delimeter   = NULL;

                #ids
                $this->user_id    = NULL;
                $this->room_id    = NULL;
                $this->subject_id = NULL;

                #time
                $this->start = NULL;
                $this->end   = NULL;

                /**
                 *
                 * @var array inputs
                 */
                $this->input_data_days = NULL;

                /**
                 * fields
                 */
                // $this->days  = NULL;
                //  $this->form_ = NULL;

                /**
                 * 
                 */
                $this->affected_rows                             = NULL;
                $this->subject_offer_line_conflict_result_object = NULL;
                $this->enable_migrate                            = NULL;
        }

        /**
         * prevent calling undefined functions
         * 
         * @param type $name
         * @param type $arguments
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __call($name, $arguments)
        {
                show_error('method <b>"$this->' . strtolower(get_class()) . '->' . $name . '()"</b> not found in ' . __FILE__ . '.');
        }

        /**
         * easy access CI super global
         * 
         * 
         * @param type $name
         * @return mixed
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __get($name)
        {
                /**
                 * CI reference
                 */
                return get_instance()->$name;
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

        public function form_($f)
        {
                $this->form_ = $f;
        }

        private function post()
        {
                /**
                 * set foreign ids
                 */
                $this->user_id    = $this->input->post('faculty', TRUE);
                $this->room_id    = $this->input->post('room' . $this->form_, TRUE);
                $this->subject_id = $this->input->post('subject', TRUE);
                $this->start      = $this->input->post('start' . $this->form_, TRUE);
                $this->end        = $this->input->post('end' . $this->form_, TRUE);

                foreach ($this->days as $v)
                {
                        $this->input_data_days['subject_offer_line_' . $v] = (is_null($this->input->post($v . $this->form_, TRUE)) ? FALSE : TRUE);
                }
        }

        public function migrate_test($sub_offr)
        {
                if ( ! $this->enable_migrate)
                {
                        show_error('must enable migrate test in ' . get_class() . ' class.');
                }
                /**
                 * set foreign ids
                 */
                $this->user_id    = $sub_offr['user_id'];
                $this->room_id    = $sub_offr['room_id'];
                $this->subject_id = $sub_offr['subject_id'];
                $this->start      = $sub_offr['subject_offer_line_start'];
                $this->end        = $sub_offr['subject_offer_line_end'];

                foreach ($this->days as $v)
                {
                        $this->input_data_days['subject_offer_' . $v] = $sub_offr['subject_offer_' . $v];
                }
        }

        private function _query_group()
        {

                $foriegn_ids = array();
                $days        = array();


                $atleast_one_day = FALSE;
                /**
                 * populate days with value from input
                 *///echo print_r($this->input_data_days);
                foreach ($this->input_data_days as $k => $v)
                {
                        if ($v)
                        {
                                $atleast_one_day = TRUE;
                                $days[$k]        = $v;
                        }
                }//echo print_r($this->input_data_days );
                if ( ! $atleast_one_day)
                {
                        if ( ! $this->enable_migrate)
                        {

                                $this->form_validation->set_message(
                                        'subject_offer_check_check_conflict', $this->error_strat_delimeter .
                                        'Days required.' .
                                        $this->error_end_delimeter);
                        }
                        return FALSE;
                }

                $foriegn_ids['user_id']    = $this->user_id;
                $foriegn_ids['room_id']    = $this->room_id;
                $foriegn_ids['subject_id'] = $this->subject_id;
                return $this->Subject_offer_line_model->
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
                                where('subject_offer_line_start <= ', $this->start)->
                                where('subject_offer_line_start <= ', $this->end)->
                                where('subject_offer_line_end > ', $this->start)->
                                where('subject_offer_line_end <= ', $this->end)->
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
                                where('subject_offer_line_start >= ', $this->start)->
                                where('subject_offer_line_start < ', $this->end)->
                                where('subject_offer_line_end >= ', $this->start)->
                                where('subject_offer_line_end >= ', $this->end)->
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
                                where('subject_offer_line_start <= ', $this->start)->
                                where('subject_offer_line_start < ', $this->end)->
                                where('subject_offer_line_end > ', $this->start)->
                                where('subject_offer_line_end >= ', $this->end)->
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
                                where('subject_offer_line_start >= ', $this->start)->
                                where('subject_offer_line_start < ', $this->end)->
                                where('subject_offer_line_end > ', $this->start)->
                                where('subject_offer_line_end <= ', $this->end)->
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
                                //------------


                                /**
                                 * 
                                 * 
                                 * semester and year
                                 */
                                group_start()->
                                where('subject_offer_semester', current_school_semester(TRUE))->
                                where('subject_offer_school_year', current_school_year())->
                                group_end();
        }

        /**
         * 
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function subject_offer_check_check_conflict()
        {


                /**
                 * 
                 * generate a query
                 * then get result set, for the view of conflict subject offer
                 */
                // $this->subject_offer_line_conflict_result_object = ; //->
                // get_all();  //echo  $this->db->last_query();

                /**
                 * get affected row count
                 */
                // $this->affected_rows = count($this->subject_offer_line_conflict_result_object); //
                // echo       '['.$this->affected_rows.']';
                $tmp = $this->_query_group();
                if ($tmp)
                {
                        $this->affected_rows = $tmp->count_rows();
                }
                else
                {
                        return FALSE;
                }
                /**
                 * set error/invalid message
                 */
                if ( ! $this->enable_migrate)
                {
                        $this->form_validation->set_message(
                                'subject_offer_check_check_conflict', bootstrap_error('Schedule conflicts ' .
                                        $this->affected_rows . ' schedule/s' . br(1) .
                                        ' above. Refer to table above.')
                        );
                }

                return (bool) ! $this->affected_rows; //0 is true/means no conflict
                //return FALSE;
        }

        public function conflict()
        {
                /**
                 * generate name for db cache, so i will use all post value to be using
                 */
                $db_cache_name = '';
//                foreach ($this->input->post() as $p)
//                {
//                        $tmp           = str_replace(' ', '_', $p);
//                        $db_cache_name .= $tmp . '_';
//                }
//                $db_cache_name = trim($db_cache_name, '_');
                $sub_off       = array();
                if ($this->affected_rows)
                {
                        $res = $this->_query_group()->
                                        //-----------
                                        set_cache('subject_offer_check_check_conflict_' . $db_cache_name . $this->form_)->get_all();
                        //echo $this->db->last_query();
                        foreach ($res as $row)
                        {
                                $sub_off[] = $this->Subject_offer_line_model->where(array('subject_offer_id' => $row->subject_offer_id))->get();
                        }//echo print_r($sub_off);
                        return $sub_off;
                }
                return FALSE;
                // return 'test data confict [not implemented yet]<br />' . $this->db->last_query();
        }

}
