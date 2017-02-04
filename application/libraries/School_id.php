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

        public function __construct()
        {
                $this->CI = &get_instance();
        }

        public function generate()
        {
                return '1234-1324';
        }

}
