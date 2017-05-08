<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('lang_array_'))
{

        function lang_array_()
        {
                return array(
                    'en' => 'English',
                    'fi' => 'Filipino',
                    'ce' => 'Cebuano',
//                    'sp' => 'Spanish',
//                    'jp' => 'Japanese',
                );
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('lang'))//load only this when ENVIRONMENT is 'development'
{

        /**
         * Lang (extended)
         *
         * Fetches a language variable and optionally outputs a form label
         *
         * @param	string	$line		The language line
         * @param	string	$for		The "for" value (id of the form element)
         * @param	array	$attributes	Any additional HTML attributes
         * @return	string
         */
        function lang($line, $for = '', $attributes = array())
        {
                $label = $line;
                $line  = get_instance()->lang->line($line);

                //===================================================================== 
                $line = ($line) ? $line : ((ENVIRONMENT === 'development') ? '## ' . $label . ' ##' : $label);
                //=====================================================================
                unset($label);
                if ($for !== '')
                {
                        $line = '<label for="' . $for . '"' . _stringify_attributes($attributes) . '>' . $line . '</label>';
                }

                return $line;
        }

}