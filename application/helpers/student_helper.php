<?php

defined('BASEPATH') or exit('no direct script allowed');

if ( ! function_exists('civil_status'))
{

        function civil_status($index = FALSE, $lang = FALSE)
        {
                /**
                 * keys will use as data to insert/update in db
                 */
                $civil_status = array(
                    'single'    => ( ! $lang) ? lang('student_civil_status_single') : 'student_civil_status_single',
                    'married'   => ( ! $lang) ? lang('student_civil_status_married') : 'student_civil_status_married',
                    'seperated' => ( ! $lang) ? lang('student_civil_status_seperated') : 'student_civil_status_seperated',
                    'widower'   => ( ! $lang) ? lang('student_civil_status_widower') : 'student_civil_status_widower'
                );
                if ($index)
                {
                        if (array_key_exists($index, $civil_status))
                        {
                                return $civil_status[$index];
                        }
                        return NULL;
                }
                if (trim($index) == '')
                {

                        return NULL;
                }
                return $civil_status;
        }

}