<?php

defined('BASEPATH') or exit('no direct script allowed');

if ( ! function_exists('input_bootstrap'))
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
                if ( ! isset($field['type']))
                {
                        $field['type'] = 'text';
                }
                if ( ! isset($field['lang']))
                {
                        $field['lang'] = 'test';
                }
                $CI  = &get_instance();
                $CI->load->helper('html');
                echo PHP_EOL . comment_tag($field['name'] . ' [' . $field['type'] . ']');
                $tmp = (form_error($field['name']) == '') ? '' : ' error';
                echo '<div class="control-group' . $tmp . '">' . PHP_EOL;

                if (isset($field['lang']['main_lang']))
                {
                        echo sprintf(lang($field['lang']['main_lang'], $field['name'], array(
                            'class' => 'control-label',
                                )), $field['lang']['sprintf']) . PHP_EOL;
                }
                else
                {
                        echo lang($field['lang'], $field['name'], array(
                            'class' => 'control-label',
                        )) . PHP_EOL;
                }
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
                        case 'password':
                                $field['id'] = $field['name'];
                                switch ($field['type'])
                                {
                                        case 'text':
                                                echo form_input($field);
                                                break;
                                        case 'password':
                                                echo form_password($field);
                                                break;
                                        default:
                                                /**
                                                 * not supposed to be here.
                                                 * impossible
                                                 * --Lloric
                                                 */
                                                show_error('No valid type of form input defined, either text or password.');
                                                break;
                                }
                                break;
                        case 'textarea':
                                echo form_textarea($field);
                                break;
                        case 'file':
                                echo form_upload($field);
                                break;
                        case 'dropdown':
                        case 'multiselect':
                                $default_value = (isset($field['default'])) ? $field['default'] : NULL;
                                switch ($field['type'])
                                {

                                        case 'dropdown':
                                                echo form_dropdown($field['name'], $field['value'], set_value($field['name'], $default_value));
                                                break;
                                        case 'multiselect':
                                                echo form_multiselect($field['name'], $field['value'], get_instance()->input->post($field['name'], TRUE));
                                                break;
                                        default:
                                                /**
                                                 * not supposed to be here.
                                                 * impossible
                                                 * --Lloric
                                                 */
                                                show_error('No valid type of form input defined, either dropdown or multiselect.');
                                                break;
                                }
                                break;
                        case 'radio':
                        case 'checkbox':
                                if (isset($field['fields']))
                                {
                                        $labels = $field['fields'];

                                        if ( ! is_array($labels))
                                        {
                                                $labels = array($labels);
                                        }
                                        switch ($field['type'])
                                        {
                                                case 'checkbox':
                                                case 'radio':
                                                        foreach ($labels as $k => $v)
                                                        {
                                                                $defaut = NULL;
                                                                switch ($field['type'])
                                                                {
                                                                        case 'checkbox':
                                                                                if (isset($field['default']) && ((int) count((array) $CI->input->post($field['name'], TRUE)) === 0))
                                                                                {
                                                                                        $field_default = $field['default'];
                                                                                        if ( ! is_array($field_default))
                                                                                        {
                                                                                                $field_default = array($default_value);
                                                                                        }
                                                                                        $defaut = (bool) in_array($k, $field_default);
                                                                                }
                                                                                else
                                                                                {
                                                                                        $defaut = (bool) in_array($k, (array) $CI->input->post($field['name'], TRUE));
                                                                                }
                                                                                break;
                                                                        case 'radio':
                                                                                $defaut = ($field['value'] == $k);
                                                                                break;
                                                                }
                                                                $lang_ = NULL;


                                                                $ignore = FALSE;
                                                                if (isset($field['field_lang']))
                                                                {
                                                                        if ( ! $field['field_lang'])
                                                                        {
                                                                                /**
                                                                                 * no need lang
                                                                                 */
                                                                                $lang_  = $v;
                                                                                $ignore = TRUE;
                                                                        }
                                                                }
                                                                if ( ! $ignore)
                                                                {
                                                                        if (is_numeric($v))
                                                                        {
                                                                                /**
                                                                                 * no need lang if numeric
                                                                                 */
                                                                                $lang_ = $v;
                                                                        }
                                                                        else
                                                                        {

                                                                                $lang_ = lang($v);
                                                                        }
                                                                }
                                                                $form_ = 'form_' . $field['type'];
                                                                echo form_label($form_($field['name'], $k, $defaut) . ' ' . $lang_) . PHP_EOL;
                                                        }
                                                        break;
//                                                case 'checkbox':
//                                                        foreach ($labels as $v)
//                                                        {
//                                                                $defaut = ($field['value'] == $v['value']);
//                                                                echo form_label(form_checkbox($field['name'], $v['value'], $defaut) . ' ' . $v['label']) . PHP_EOL;
//                                                        }
//                                                        break;
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
                if (isset($field['note']))
                {
                        echo '<span class="help-block">' . $field['note'] . '</span>' . PHP_EOL;
                }
                echo form_error($field['name']) . PHP_EOL;
                echo '</div>' . PHP_EOL;
                echo '</div>' . PHP_EOL;
                echo comment_tag('end-' . $field['name'] . ' [' . $field['type'] . ']') . PHP_EOL;
        }

}