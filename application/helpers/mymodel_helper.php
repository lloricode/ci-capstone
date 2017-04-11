<?php

defined('BASEPATH') or exit('no direct script allowed');
if ( ! function_exists('remove_empty_before_write'))
{

        /**
         * 
         * 
         * @param string|array $data
         * @return array
         */
        function remove_empty_before_write($data)
        {
                /**
                 * temporary
                 */
                return $data;
                $new_data = array();
                if ( ! is_array($data))
                {
                        $data = array($data);
                }
                foreach ($data as $value)
                {
                        if ((string) $value === '')
                        {
                                continue; #skip
                        }
                        $new_data[] = $value;
                }print_r($new_data);
                return $new_data;
        }

}