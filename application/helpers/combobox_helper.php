<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('my_semester_for_combo'))
{

        /**
         * 
         * @return array 1-1st Semester,2-2nd Semester,3-Summer Semester
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_semester_for_combo()
        {
                return array(
                    'first'  => '1st Semester',
                    'second' => '2nd Semester',
                    'summer' => 'Summer Semester',
                );
        }

}


if (!function_exists('my_lang_combo'))
{

        /**
         * 
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function my_lang_combo()
        {
                return array(
                    'english'  => 'English',
                    'filipino' => 'Filipino',
                    'cebuano'  => 'Cebuano',
                );
        }

}


if (!function_exists('_numbers_for_drop_down'))
{

        /**
         * 
         * @param int $s start
         * @param int $e end
         * @return array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com
         */
        function _numbers_for_drop_down($s, $e)
        {
                $array = array();
                for ($i = $s; $i <= $e; $i++)
                {
                        $array[$i] = $i;
                }
                return $array;
        }

}