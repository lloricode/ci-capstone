<?php

defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('input_bootstrap'))
{

        /**
         * form input designed by current bootstrap framework
         * 
         * @param array $field
         * @param string $lang
         * @param string $input
         * @param string $prepend
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function input_bootstrap($field, $prepend = FALSE)
        {
                if (!isset($field['type']))
                {
                        $field['type'] = 'text';
                }
                if (!isset($field['lang']))
                {
                        $field['lang'] = 'test';
                }
                $CI  = &get_instance();
                $CI->load->helper('html');
                echo PHP_EOL . comment_tag($field['name'] . ' [' . $field['type'] . ']');
                $tmp = (form_error($field['name']) == '') ? '' : ' error';
                echo '<div class="control-group' . $tmp . '">' . PHP_EOL;
                echo lang($field['lang'], $field['name'], array(
                    'class' => 'control-label',
                )) . PHP_EOL;
                echo '<div class="controls">' . PHP_EOL;

                if ($prepend)
                {
                        echo '<div class="input-prepend"> <span class="add-on">' . $prepend . '</span>';
                }
                if (isset($field['lang']))
                {
                        /**
                         * remove lang, to exclude in attributes in form_inputs
                         */
                        unset($field['lang']);
                }
                switch ($field['type'])
                {
                        case 'text':
                                $field['id']   = $field['name'];
                                echo form_input($field);
                                break;
                        case 'textarea':
                                echo form_textarea($field);
                                break;
                        case 'file':
                                echo form_upload($field);
                                break;
                        case 'dropdown':
                                $default_value = (isset($field['default'])) ? $field['default'] : NULL;
                                echo form_dropdown($field['name'], $field['value'], set_value($field['name'], $default_value));
                                break;
                        case 'radio':
                        case 'checkbox':
                                if (isset($field['fields']))
                                {
                                        $labels = $field['fields'];

                                        if (!is_array($labels))
                                        {
                                                $labels = array($labels);
                                        }
                                        switch ($field['type'])
                                        {
                                                case 'radio':
                                                        foreach ($labels as $k => $v)
                                                        {
                                                                $defaut = ($field['value'] == $k);
                                                                echo form_label(form_radio($field['name'], $k, $defaut) . ' ' . $v) . PHP_EOL;
                                                        }
                                                        break;
                                                case 'checkbox':
                                                        foreach ($labels as $v)
                                                        {
                                                                $defaut = ($field['value'] == $v['value']);
                                                                echo form_label(form_checkbox($field['name'], $v['value'], $defaut) . ' ' . $v['label']) . PHP_EOL;
                                                        }
                                                        break;
                                                default:
                                                        /**
                                                         * not supposed to be here.
                                                         * impossible
                                                         * --Lloric
                                                         */
                                                        show_error('No valid type of form input defined, either radio or checkbox.');
                                                        break;
                                        }
                                }
                                break;
                        default:
                                show_error('No valid type of form input defined.');
                                break;
                }
                if ($prepend)
                {
                        echo '</div>';
                }
                echo form_error($field['name']) . PHP_EOL;
                echo '</div>' . PHP_EOL;
                echo '</div>' . PHP_EOL;
                echo comment_tag('end-' . $field['name'] . ' [' . $field['type'] . ']') . PHP_EOL;
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
                $CI = &get_instance();
                $CI->load->helper('html');
                echo PHP_EOL . comment_tag('image');
                //  $tmp = (form_error($field['name']) == '') ? '' : ' error';
                echo '<div class="control-group' . /* $tmp . */ '">' . PHP_EOL;
//                echo lang($lang, $field['name'], array(
//                    'class' => 'control-label',
//                )) . PHP_EOL;
                echo '<div class="controls">' . PHP_EOL;


                echo img($image_properties);


                echo '</div>' . PHP_EOL;
                echo '</div>' . PHP_EOL;
                echo comment_tag('end-imgae') . PHP_EOL;
        }

}