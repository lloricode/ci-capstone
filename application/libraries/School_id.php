<?php

defined('BASEPATH') or exit('no direct script allowed');

/**
 * for dynamically generate school id, depend on database and current year/school year
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class School_id
{


        /**
         * CI reference
         *
         * @var reference 
         */
        private $CI;

        /**
         * year
         */
        private $year;

        /**
         * number
         */
        private $number;

        /**
         * month
         */
        private $month;

        /**
         * month_start
         */
        private $month_start;

        /**
         * month_end
         */
        private $month_end;

        /**
         * check the table to generate number
         * 
         * database table 
         */
        private $db_table;

        /**
         * table primary id
         */
        private $db_table_id;

        /**
         * table primary id
         */
        private $db_table_school_id;

        /**
         * table primary id
         */
        private $model;

        /**
         * 
         */
        public function __construct()
        {
                $this->CI                 = &get_instance();
                $this->CI->load->helper('date');
                $this->CI->config->load('common/config');
                $this->db_table           = 'students';
                $this->db_table_id        = 'student_id';
                $this->db_table_school_id = 'student_school_id';
                $this->model              = 'Student_model';
                $this->CI->load->model($this->model);
                log_message('info', 'class ' . get_class() . ' initiallize.');
        }

        /**
         * set this to automatically set year
         * 
         * 1=January, 2=Febbruary, etc...
         * 
         * @param int $school_month_start
         * @param int $school_month_end
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function initialize()
        {
                $this->month_start = (int) $this->CI->config->item('school_year_start');
                $this->month_end   = (int) $this->CI->config->item('school_year_end');
                $this->year        = (int) date('Y');
                $this->month       = (int) date('m');
                $this->generate_school_year();
                $this->generate_number();
        }

        private function generate_school_year()
        {
                if ($this->month < $this->month_start)
                {
                        /**
                         * minus one because the start month not start :D
                         */
                        $this->year --;
                }
        }

        private function generate_number($attemp = 0)
        {
                /**
                 * get total exist then plus one
                 */
                $total = $this->CI->{$this->model}->
                                where($this->db_table_school_id, 'LIKE', $this->year)->
                                count_rows() + 1;

                /**
                 * add attemp to generate new number
                 */
                $total  += $attemp;
                $string = '';
                if ($total > 0 && $total < 10)
                {
                        $string = '000' . $total;
                }
                elseif ($total >= 10 && $total < 100)
                {
                        $string = '00' . $total;
                }
                elseif ($total >= 100 && $total < 1000)
                {
                        $string = '0' . $total;
                }
                elseif ($total >= 1000 && $total < 10000)
                {
                        $string = $total;
                }
                $this->number = (string) $string;
                if ($this->check_if_school_id_exist())
                {
                        /**
                         * recursive plus increment attempp
                         */
                        $this->generate_number($attemp++);
                }
        }

        /**
         * check if generated id is exist in database
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function check_if_school_id_exist()
        {
                $obj = $this->CI->{$this->model}->where(array(
                            $this->db_table_school_id => $this->complete_school_id()
                        ))->get();
                return (bool) $obj;
        }

        private function complete_school_id()
        {
                return $this->year . '-' . $this->number;
        }

        public function generate()
        {
                return $this->complete_school_id();
        }

}
