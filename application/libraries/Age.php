<?php

defined('BASEPATH') or exit('no direct script allowed');

/**
 * my Age converter
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Age
{


        private $pregmatch;
        private $mm;
        private $dd;
        private $yy;
        private $current_month;
        private $current_day;
        private $current_year;
        private $age;

        public function __construct()
        {
                $this->pregmatch     = '/^\d{2}[-]\d{2}[-]\d{4}$/';
                $this->current_month = (int) date('m');
                $this->current_day   = (int) date('d');
                $this->current_year  = (int) date('Y');
                $this->age           = 0;
        }

        /**
         * initialize with birthdate
         * @param type $date
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function initialize($date)
        {
                if (!preg_match($this->pregmatch, $date))
                {
                        show_error('Invalid date format for Age class. must mm-dd-yyyy');
                }
                list($this->mm, $this->dd, $this->yy) = explode('-', $date);
        }

        private function convert()
        {
                if ($this->yy <= $this->current_year)
                {
                        $this->age += $this->current_year - $this->yy;
                }
                else
                {
                        show_error('not valid value in Age class.');
                }
                if (!(($this->mm <= $this->current_month) &&
                        ($this->dd <= $this->current_day) &&
                        ($this->mm == $this->current_month)))
                {
                        $this->age--;
                }
        }

        /**
         * converted result
         * @return int
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function result()
        {
                $this->convert();
                return (int) $this->age;
        }

}
