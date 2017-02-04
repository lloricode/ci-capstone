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
         * 
         */
        public function __construct()
        {
                $this->CI                 = &get_instance();
                $this->CI->load->helper('date');
                $this->db_table           = 'students';
                $this->db_table_id        = 'student_id';
                $this->db_table_school_id = 'student_school_id';
                log_message('info', 'class ' . get_class() . ' initiallize.');
        }

        /**
         * just check if parameter is ready
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function check_init($school_month_start, $school_month_end)
        {
                /**
                 * check if parameter is ready
                 */
                if (is_null($school_month_start) || is_null($school_month_end))
                {
                        show_error('Parameter(s) missing in ' . get_class() . ' class.');
                }
                /**
                 * check if int
                 */
                if (!is_integer($school_month_start) || !is_integer($school_month_end))
                {
                        show_error('Parameter(s) must INTEGER in ' . get_class() . ' class.');
                }
                /**
                 * valid in month
                 */
                if (($school_month_start > 12 || $school_month_start < 1) || ($school_month_end > 12 || $school_month_end < 1))
                {
                        show_error('Parameter(s) must gtreater than 0 or less than 13 in ' . get_class() . ' class.');
                }
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
        public function initialize($school_month_start = NULL, $school_month_end = NULL)
        {
                $this->check_init($school_month_start, $school_month_end);
                $this->month_start = (int) $school_month_start;
                $this->month_end   = (int) $school_month_end;
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
                $this->CI->db->select($this->db_table_id)
                        ->like(
                                $this->db_table_school_id, $this->year, 'after'
                        )
                        ->get($this->db_table);
                $total  = (int) $this->CI->db->affected_rows();
                $total++;
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
         */
        private function check_if_school_id_exist()
        {
                $this->CI->db->select($this->db_table_id)
                        ->where(array(
                            $this->db_table_school_id => $this->complete_school_id()
                        ))
                        ->limit(1)
                        ->get($this->db_table);
                return (bool) $this->CI->db->affected_rows();
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
