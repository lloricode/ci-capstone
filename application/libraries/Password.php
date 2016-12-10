<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Password {

    /**
     * CI instance object
     */
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('Bcrypt');
    }

    /**
     * 
     * 
     * @param string $string_pass
     * @return string $encrypted_password
     */
    public function generate_hash($string_pass) {

        return $this->CI->bcrypt->hash_password($string_pass);
        // return password_hash($string_pass, 1);
    }

    /**
     * 
     * @param string $password_to_verify
     * @param type $encrypted_password
     * @return boolean
     */
    public function check_password($password_to_verify, $encrypted_password) {

        return $this->CI->bcrypt->check_password($password_to_verify, $encrypted_password);
        // return password_verify($password_to_verify, $encrypted_password);
    }

}
