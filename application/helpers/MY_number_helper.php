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

// ------------------------------------------------------------------------

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

                $num = (int) $num;
                if ($num < 1 OR $num > 3999)
                {
                        return;
                }
                return _number_roman($num, 1);
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('_number_roman'))
{

        /**
         * 
         * @param int $num
         * @param string $th
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function _number_roman($num, $th)
        {
                /*
                 * 
                 * 1 - I
                 * 5 - V
                 * 10 - X
                 * 50 - L
                 * 100 - C
                 * 500 - D
                 * 1000 - M
                 */
                $return = '';

                $key1 = NULL;
                $key2 = NULL;
                switch ($th)
                {
                        case 1:
                                $key1  = 'I'; //1
                                $key2  = 'V'; //5
                                $key_f = 'X'; //copy 
                                break;
                        case 2:
                                $key1  = 'X'; //10
                                $key2  = 'L'; //50
                                $key_f = 'C'; //copy 
                                break;
                        case 3:
                                $key1  = 'C'; //100
                                $key2  = 'D'; //500
                                $key_f = 'M'; //copy 
                                break;
                        case 4:
                                $key1  = 'M'; //1000
                                break;
                }
                $n = $num % 10;
                switch ($n)
                {
                        case 1:
                        case 2:
                        case 3:
                                $return = str_repeat($key1, $n);
                                break;
                        case 4:
                                $return = $key1 . $key2;
                                break;
                        case 5:
                                $return = $key2;
                                break;
                        case 6:
                        case 7:
                        case 8:
                                $return = $key2 . str_repeat($key1, $n - 5);
                                break;
                        case 9:
                                $return = $key1 . $key_f;
                                break;
                }
                switch ($num)
                {
                        case 10:
                                $return = $key_f;
                                break;
                }

                if ($num > 10)
                {
                        $return = _number_roman($num / 10, ++ $th) . $return;
                }

                return $return;
        }

}

