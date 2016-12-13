<?php

/**
 * from: Elbert
 * REFERENCE: https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Password {

    // A higher "cost" is more secure but consumes more processing power
    private $cost = 10;

    public function __construct() {
        
    }

    /**
     * 
     * generate hash to password
     * 
     * 
     * @param string $string_pass
     * @return string $encrypted_password
     */
    public function generate_hash($string_pass) {

        // Create a random salt
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // Prefix information about the hash so PHP knows how to verify it later.
        // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
        $salt = sprintf("$2a$%02d$", $this->cost) . $salt;

        // Hash the password with the salt
        return crypt($string_pass, $salt);
    }

    /**
     * generate the hash then compare
     * 
     * @param string $password_to_verify
     * @param type $encrypted_password
     * @return boolean | depends on valid password
     */
    public function check_password($password_to_verify, $encrypted_password) {

        // Hashing the password with its hash as the salt returns the same hash
        return (bool) hash_equals($encrypted_password, crypt($password_to_verify, $encrypted_password));
    }

}
