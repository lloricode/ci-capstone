<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('number_places'))
{

        /**
         * 
         * @param int $num it will convert to int
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function number_place($num)
        {
                $num    = (int) $num;
                $places = array(
                    1 => 'First',
                    2 => 'Second',
                    3 => 'Third',
                    4 => 'Fourth',
                    5 => 'Fifth',
                    6 => 'Sixth'
                );
                if (isset($places[$num]))
                {
                        return $places[$num];
                }
                return NULL;
        }

}
if ( ! function_exists('number_roman'))
{

        /**
         * 
         * @param int $num it will convert to int
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function number_roman($num)
        {
                $num   = (int) $num;
                /**
                 * soon to improve dynamically
                 */
                $roman = array(
                    1 => 'I',
                    2 => 'II',
                    3 => 'III',
                    4 => 'IV',
                    5 => 'V',
                    6 => 'VI'
                );
                if (isset($roman[$num]))
                {
                        return $roman[$num];
                }
                return NULL;
        }

}

