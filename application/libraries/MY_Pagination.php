<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class MY_Pagination extends CI_Pagination
{

        public function __construct($params = array())
        {
                parent::__construct($params);
                log_message('info', 'Extended Pagination Class Initialized');
        }

        /**
         * complete pagination
         * 
         * configuration is in application/config/pagination.php
         * 
         * to keep DRY [Don't Repeat Yourself]
         * and can use in other controller
         * 
         * pagination configuration :
         * application/config/pagination.php
         * 
         * @param string $url
         * @param string $total_row
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function generate_link($url, $total_row)
        {
                $this->CI->pagination->initialize(array(
                    'base_url'   => base_url($url),
                    'total_rows' => $total_row,
                ));

                /**
                 * generate list into <ul></ul> then return | it depend on configuration of pagination
                 */
                return $this->CI->pagination->create_links();
        }

}
