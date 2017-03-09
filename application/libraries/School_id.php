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
         * 
         */
        private $obj;
        private $ver;

        public function __construct()
        {
                $this->config->load('common/config');
                $this->ver = $this->config->item('version_id_generator');

                $arg = array(
                    'table'  => 'students',
                    'column' => 'student_school_id',
                    'model'  => 'Student_model'
                );
                if ($this->ver == 1)
                {
                        $this->obj = new Id_generator_v1($arg);
                }
                else
                {
                        $this->obj = new Id_generator_v2($arg);
                }
                log_message('info', 'class ' . get_class() . ' initiallize.');
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

        public function initialize($course_school_id_code = NULL)
        {
                if ($this->ver == 1)
                {
                        
                }
                else
                {
                        $this->obj->set_course_school_id_code($course_school_id_code);
                }
        }

        public function temporary_id()
        {
                return $this->obj->temporary_id();
        }

        public function generate()
        {
                return $this->obj;
        }

}

/**
 * format will be 12-1234 sample: 43-0321
 * 
 * course-number
 */
class Id_generator_v2 extends Id__
{


        private $total_student_plus_one;
        private $course_school_id;
        private $start_id_generator;

        public function __construct($arg)
        {
                parent::__construct($arg);
                $this->start_id_generator = $this->config->item('start_id_number_generator');
        }

        public function set_course_school_id_code($course_school_id)
        {
                $this->course_school_id = $course_school_id;
                $this->get_total_number_of_stundent();
        }

        private function get_total_number_of_stundent()
        {
                if ($this->start_id_generator == 0)
                {
                        /**
                         * get total exist then plus one
                         */
                        $this->total_student_plus_one = $this->{$this->model}->
                                        //    where($this->db_table_school_id, 'LIKE', $this->year)->
                                        /*
                                         * not include in sat cache in MY_MODEL?
                                         * maybe bcause its not select?
                                         * 
                                         * --Lloric
                                         */
                                        set_cache('get_total_number_of_stundent_v2_')->
                                        count_rows() + 1;
                }
                else
                {
                        $this->{$this->model}->
                                        where($this->db_table_school_id, 'LIKE', $this->start_id_generator)->
                                        count_rows() + 1;
                        $this->total_student_plus_one = $this->start_id_generator;
                }
        }

        public function temporary_id()
        {
                return $this->total_student_plus_one;
        }

        /**
         * just print the object of type this
         * @return string
         */
        public function __toString()
        {
                return $this->course_school_id . '-' . $this->total_student_plus_one;
        }

}

/**
 * format will be YYYY-1234 sample: 2017-0321
 */
class Id_generator_v1 extends Id__
{


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

        public function __construct($arg)
        {
                parent::__construct($arg);

                $this->load->helper('date');


                $this->month_start = (int) $this->config->item('school_year_start');
                $this->month_end   = (int) $this->config->item('school_year_end');
                $this->year        = (int) date('Y');
                $this->month       = (int) date('m');

                $this->generate_school_year();
                $this->generate_number();
                log_message('info', 'class ' . get_class() . ' initiallize.');
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
                $total = $this->{$this->model}->
                                where($this->db_table_school_id, 'LIKE', $this->year)->
                                set_cache('get_total_number_of_stundent_v1_')->
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
         * just print the object of type this
         * @return string
         */
        public function __toString()
        {
                return $this->year . '-' . $this->number;
        }

}

class Id__
{


        /**
         * check the table to generate number
         * 
         * database table 
         */
        protected $db_table;

        /**
         * table primary id
         */
        protected $db_table_id;

        /**
         * table school id
         */
        protected $db_table_school_id;
        protected $model;

        public function __construct($arg)
        {
                $this->model              = $arg['model'];
                $this->db_table           = $arg['table'];
                $this->db_table_school_id = $arg['column'];

                $this->load->model($this->model);
        }

        /**
         * check if generated id is exist in database
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        protected function check_if_school_id_exist()
        {
                $obj = $this->{$this->model}->where(array(
                            $this->db_table_school_id => $this
                        ))->get();
                return (bool) $obj;
        }

}
