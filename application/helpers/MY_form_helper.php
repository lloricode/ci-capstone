<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('input_bootstrap'))
{

        /**
         * 
         * @param string $field field
         * @param string $lang lang
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function input_bootstrap($field, $lang, $input = 'input')
        {
                $tmp = (form_error($field['name']) == '') ? '' : ' error';
                echo '<div class="control-group' . $tmp . '">' . "\n";
                echo lang($lang, $field['name'], array(
                    'class' => 'control-label',
                )) . "\n";
                echo '<div class="controls">' . "\n";

                switch ($input)
                {
                        case 'input':
                                echo form_input($field);
                                break;
                        case 'textarea':
                                echo form_textarea($field);
                                break;
                        case 'file':
                                echo form_upload($field);
                                break;
                        default:
                                break;
                }
                echo form_error($field['name']);
                echo '</div>' . "\n";
                echo '</div>' . "\n";
        }

}
if (!function_exists('image_view'))
{

        /**
         * 
         * @param string $field field
         * @param string $lang lang
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function image_view($image_properties)//, $lang, $input = 'input')
        {
                //  $tmp = (form_error($field['name']) == '') ? '' : ' error';
                echo '<div class="control-group' . /* $tmp . */ '">' . "\n";
//                echo lang($lang, $field['name'], array(
//                    'class' => 'control-label',
//                )) . "\n";
                echo '<div class="controls">' . "\n";


                echo img($image_properties);


                echo '</div>' . "\n";
                echo '</div>' . "\n";
        }

}
//if (!function_exists('input_date_picker_bootstrap'))
//{
//
//        /**
//         * 
//         * @param string $field field
//         * @param string $lang lang
//         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
//         */
//        function input_date_picker_bootstrap($field, $lang)
//        {
//                $tmp = (form_error($field['name']) == '') ? '' : ' error';
//                echo '<div class = "control-group' . $tmp . '">' . "\n";
//                echo lang($lang, $field['name'], array(
//                    'class' => 'control-label',
//                    'id'    => 'inputError'
//                )) . "\n";
//                echo '<div class = "controls">' . "\n";
//
//                echo ' <div data-date = "12-02-2012" class = "input-append date datepicker">';
//                echo form_input($field);
//                echo ' <span class = "add-on"><i class = "icon-th"></i></span> ';
//                echo form_error($field['name']);
//                echo '</div>' . "\n";
//                echo '</div>' . "\n";
//
//
//             
//        }
//
//}
if (!function_exists('input_dropdown_bootstrap'))
{

        /**
         * 
         * @param string $field
         * @param string $lang
         * @param array $value_combo
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function input_dropdown_bootstrap($field, $lang, $value_combo, $default = NULL)
        {
                $tmp = (form_error($field) == '') ? '' : ' error';
                echo '<div class = "control-group' . $tmp . '">' . "\n";
                echo lang($lang, $field, array(
                    'class' => 'control-label',
                )) . "\n";
                echo '<div class = "controls">' . "\n";

                echo form_dropdown($field, $value_combo, set_value($field, $default));

                echo form_error($field);
                echo '</div>' . "\n";
                echo '</div>' . "\n";
        }

}