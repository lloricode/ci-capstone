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

