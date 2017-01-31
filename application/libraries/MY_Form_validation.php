<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

/**
 * Extended Form Validation
 * 
 * since CodeIgniter version 3.1.2
 * 
 * usually i used regex expression here here.
 * reference: http://php.net/manual/en/function.preg-match.php
 * 
 * 
 * 
 * Simple regex

  Regex quick reference
  [abc]     A single character: a, b or c
  [^abc]     Any single character but a, b, or c
  [a-z]     Any single character in the range a-z
  [a-zA-Z]     Any single character in the range a-z or A-Z
  ^     Start of line
  $     End of line
  \A     Start of string
  \z     End of string
  .     Any single character
  \s     Any whitespace character
  \S     Any non-whitespace character
  \d     Any digit
  \D     Any non-digit
  \w     Any word character (letter, number, underscore)
  \W     Any non-word character
  \b     Any word boundary character
  (...)     Capture everything enclosed
  (a|b)     a or b
  a?     Zero or one of a
  a*     Zero or more of a
  a+     One or more of a
  a{3}     Exactly 3 of a
  a{3,}     3 or more of a
  a{3,6}     Between 3 and 6 of a

  options: i case insensitive m make dot match newlines x ignore whitespace in regex o perform #{...} substitutions only once
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
class MY_Form_validation extends CI_Form_validation
{

        public function __construct($rules = array())
        {
                parent::__construct($rules);
        }

        /**
         * accept input only from 0 to 9
         * if not numeric will return FALSE with invalid message.
         * 
         * @param string $value
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function numeric_0_to_9($value)
        {
                $this->CI->form_validation->set_message('numeric_0_to_9', lang('validation_numeric_0_to_9'));
                if ($value >= 0 && $value <= 9)
                {
                        return TRUE;
                }
                else if ($value < 0 || $value > 9)
                {

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
         * validated using regex expression
         * 
         * @param string $value
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function human_name($value)
        {
                $this->CI->form_validation->set_message('human_name', lang('validation_human_name'));

                # a to z(small chars) 
                # A to Z (capital)
                # period or space
                # * means zero or more length of character
                if (preg_match('/^[a-zA-Z. ]*$/', $value))
                {
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
         * validated using regex expression
         * 
         * @param string $value
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function school_id($value)
        {
                $this->CI->form_validation->set_message('school_id', lang('validation_school_id'));

                #  '\d' means digit/numeric
                #  '{4}' means exactly 4 length of character
                #  '[-]' means with dash "-" 
                #   so need exactly 4 digits followed by dash "-" then followed again with exactly 4 digits
                if (preg_match('/^\d{4}[-]\d{4}$/', $value))
                {
                        return TRUE;
                }
                return FALSE;
        }

        /**
         * check password difficulties
         * maximum difficulties: 5
         * 
         * validated using regex expression
         * 
         * @param string $value
         * @param int $level 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function password_level($value, $level)
        {
                $score = 0;
                $this->CI->form_validation->set_message('password_level', lang('validation_password_level'));

                # plus 1 score if has numeric
                if (preg_match('!\d!', $value))
                {
                        $score++;
                }
                # has capital letter
                if (preg_match('![A-Z]!', $value))
                {
                        $score++;
                }
                # has small letter
                if (preg_match('![a-z]!', $value))
                {
                        $score++;
                }
                # has special character
                if (preg_match('!\W!', $value))
                {
                        $score++;
                }
                # length greater than or equal 8
                if (strlen($value) >= 8)
                {
                        $score++;
                }

                return $score >= $level;
        }

        /**
         * a validation for username 
         * 
         * validated using regex expression
         * 
         * @param type $value
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function username($value)
        {
                $this->CI->form_validation->set_message('username', lang('validation_username'));
                if (preg_match('/^[a-zA-Z0-9]+[_.-]{0,1}[a-zA-Z0-9]+$/m', $value))
                {
                        return TRUE;
                }
                return FALSE;
        }

        /**
         * no space allowed
         * 
         * @param type $value
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function no_space($value)
        {
                $this->CI->form_validation->set_message('no_space', lang('validation_no_space'));

                # from start to end of a line must no have white space.
                if (strpos($value, " ") === FALSE)
                {
                        return TRUE;
                }
                return FALSE;
        }

}
