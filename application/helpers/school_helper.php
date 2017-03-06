<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('semesters'))
{

        /**
         * 'first'  => '1st Semester',
         * 'second' => '2nd Semester',
         * 'summer' => 'Summer Semester',
         * 
         * @param string $index | default FALSE just return array (all data)]
         * @return string|array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function semesters($index = FALSE)
        {
                $_semesters = array(
                    'first'  => '1st Semester',
                    'second' => '2nd Semester',
                    'summer' => 'Summer Semester',
                );
                if ($index)
                {
                        if (array_key_exists($index, $_semesters))
                        {

                                return $_semesters[$index];
                        }
                }
                return $_semesters;
        }

}

if (!function_exists('current_school_year'))
{

        /**
         * current school year
         * 
         * @return string | sample 2017-1234
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function current_school_year()
        {
                $CI                       = &get_instance();
                $output                   = NULL;
                /**
                 * get configuration 
                 */
                $school_year__month_start = $CI->config->item('school_year_start');

                /**
                 * current
                 */
                $current_month = (int) date('m');
                $current_year  = (int) date('Y');

                if ($school_year__month_start <= $current_month)
                {
                        $output = $current_year . '-' . ($current_year + 1);
                }
                elseif ($school_year__month_start > $current_month)
                {
                        $output = ($current_year - 1) . '-' . $current_year;
                }


                return $output;
        }

}

if (!function_exists('current_school_semester'))
{

        /**
         * 
         * @return string current month that will be save in database
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function current_school_semester($key = FALSE)
        {

                $CI                       = &get_instance();
                $CI->load->helper('month');
                $terms                    = semesters();
                $output                   = NULL;
                /**
                 * get configuration 
                 */
                $school_year__month_start = $CI->config->item('school_year_start');
                $school_year__month_end   = $CI->config->item('school_year_end');
                $first_start_month        = $CI->config->item('first_semester_start');
                $second_start_month       = $CI->config->item('second_semester_start');
                $summer_start_month       = $CI->config->item('summer_semester_start');

                /**
                 * current
                 */
                $current_month = (int) date('m');
                $current_year  = (int) date('Y');


                $first_array  = get_months_in_between($first_start_month, $second_start_month);
                $second_array = get_months_in_between($second_start_month, $summer_start_month);
                $summer_array = get_months_in_between($summer_start_month, $first_start_month);



                $key_value = NULL;
                if (in_array($current_month, $first_array))
                {
                        $key_value = 'first';
                        $output    = $terms['first'];
                }
                else if (in_array($current_month, $second_array))
                {
                        $key_value = 'second';
                        $output    = $terms['second'];
                }
                else if (in_array($current_month, $summer_array))
                {
                        $key_value = 'summer';
                        $output    = $terms['summer'];
                }
                if ($key)
                {
                        return $key_value;
                }
                return $output;
        }

}


if (!function_exists('school_years'))
{

        /**
         * output dependend on current year and school year set up  in commom/comfig.pnp config_item [school_year_start]
         * 
         * @param string $default | default= NULL, this will use to update so add default will include it to selections
         * @param int $year_range | default = 3
         * @return array  or school year
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function school_years($default = NULL, $year_range = 3)
        {

                $CI     = &get_instance();
                $output = array();
                if (!is_null($default))
                {
                        /**
                         * add default value for none of generated years
                         */
                        $output[$default] = $default;
                }

                /**
                 * get configuration 
                 */
                $school_year__month_start = $CI->config->item('school_year_start');

                /**
                 * current
                 */
                $current_month = (int) date('m');
                $current_year  = (int) date('Y');

                $whre_to_start = NULL;
                if ($school_year__month_start <= $current_month)
                {
                        $whre_to_start = $current_year;
                }
                elseif ($school_year__month_start > $current_month)
                {
                        $whre_to_start = ($current_year - 1);
                }

                for ($i = $whre_to_start; $i < $whre_to_start + $year_range; $i++)
                {

                        $tmp          = $i . '-' . ($i + 1);
                        $output[$tmp] = $tmp;
                }


                return $output;
        }

}