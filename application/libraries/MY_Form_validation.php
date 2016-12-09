<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

/**
 * Extended Form Validation
 * 
 * since CodeIgniter version 3.1.2
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
class MY_Form_validation extends CI_Form_validation {

    public function __construct($rules = array()) {
        parent::__construct($rules);
      
    }

    /**
     * REGEX
     */
    const human_name_regex = '/^[a-zA-Z. ]*$/';
    const school_id_regex = '/^\d{4}[-]\d{4}$/';

    /**
     * 
     * 
     * @param string $value
     * @return boolean
     */
    public function numeric_0_to_9($value) { 
        $this->CI->form_validation->set_message('numeric_0_to_9', 'Please select score in Key {field}.');
        if ($value >= 0 && $value <= 9) {
            return TRUE;
        } else if ($value < 0 || $value > 9) {

            /**
             * if someone try in inspect element then change the html values
             */
            $this->CI->form_validation->set_message('numeric_0_to_9', 'Invalid score in Key {field}.');
            return FALSE;
        }
        return FALSE;
    }

    /**
     * Real human name
     * 
     * validated using regex expresion
     * 
     * @param string $value
     * @return boolean
     */
    public function human_name($value) { 
        $this->CI->form_validation->set_message('human_name', 'Invalid {field} format.');
        if (preg_match(MY_Form_validation::human_name_regex, $value)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * validation for input school ID's
     * MUST XXXX-XXXX format | X means numerical
     * 
     * soon: valid year in ID's
     * 
     * 
     * validated using regex expresion
     * 
     * @param string $value
     * @return boolean
     */
    public function school_id($value) {
        $this->CI->form_validation->set_message('school_id', 'Invalid {field} format. must be XXXX-XXXX');
        if (preg_match(MY_Form_validation::school_id_regex, $value)) {
            return TRUE;
        }
        return FALSE;
    }

}
