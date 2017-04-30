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
                $output = '';
                if ( ! isset($field['type']))
                {
                        $field['type'] = 'text';
                }
                if ( ! isset($field['lang']))
                {
                        $field['lang'] = 'test';
                }
                $CI     = &get_instance();
                $CI->load->helper('html');
                $output .= PHP_EOL . comment_tag($field['name'] . ' [' . $field['type'] . ']');
                $tmp    = (form_error($field['name']) == '') ? '' : ' error';
                $output .= '<div class="control-group' . $tmp . '">' . PHP_EOL;

                if (isset($field['lang']['main_lang']))
                {
                        $output .= sprintf(lang($field['lang']['main_lang'], $field['name'], array(
                                    'class' => 'control-label',
                                        )), $field['lang']['sprintf']) . PHP_EOL;
                }
                else
                {
                        $lang_or_label = 'lang';
                        if (isset($field['ingnore_lang']))
                        {
                                if ($field['ingnore_lang'] === TRUE)
                                {
                                        $lang_or_label = 'form_label';
                                }
                        }
                        $output .= $lang_or_label($field['lang'], $field['name'], array(
                                    'class' => 'control-label',
                                )) . PHP_EOL;
                }
                $output .= '<div class="controls">' . PHP_EOL;

                if ($prepend)
                {
                        $output .= '<div class="input-prepend"> <span class="add-on">' . $prepend . '</span>';
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
                                                $output .= form_input($field);
                                                break;
                                        case 'password':
                                                $output .= form_password($field);
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
                                $output        .= form_textarea($field);
                                break;
                        case 'file':
                                $output        .= form_upload($field);
                                break;
                        case 'dropdown':
                        case 'multiselect':
                                $default_value = (isset($field['default'])) ? $field['default'] : NULL;
                                switch ($field['type'])
                                {

                                        case 'dropdown':
                                                $output .= form_dropdown($field['name'], $field['value'], set_value($field['name'], $default_value), array('style' => 'width: 220px'));
                                                break;
                                        case 'multiselect':
                                                $output .= form_multiselect($field['name'], $field['value'], $CI->input->post($field['name'], TRUE));
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
                                                                $lang_  = NULL;

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

                                                                switch ($field['type'])
                                                                {
                                                                        case 'checkbox':
                                                                                if (isset($field['value_is_one_name_is_label']))
                                                                                {
                                                                                        $defaut = (bool) $CI->input->post(strtolower($lang_ . $field['append_name']), TRUE);
                                                                                }
                                                                                elseif (isset($field['default']) && ((int) count((array) $CI->input->post($field['name'], TRUE)) === 0))
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

                                                                $form_ = 'form_' . $field['type'];
                                                                if (isset($field['value_is_one_name_is_label']))
                                                                {
                                                                        $output .= form_label($form_(strtolower($lang_ . $field['append_name']), 1, $defaut) . ' ' . $lang_) . PHP_EOL;
                                                                }
                                                                else
                                                                {
                                                                        $output .= form_label($form_($field['name'], $k, $defaut) . ' ' . $lang_) . PHP_EOL;
                                                                }
                                                        }
                                                        break;
//                                                case 'checkbox':
//                                                        foreach ($labels as $v)
//                                                        {
//                                                                $defaut = ($field['value'] == $v['value']);
//                                                                 $output .= form_label(form_checkbox($field['name'], $v['value'], $defaut) . ' ' . $v['label']) . PHP_EOL;
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
                        $output .= '</div>';
                }
                if (isset($field['note']))
                {
                        $output .= '<span class="help-block">' . $field['note'] . '</span>' . PHP_EOL;
                }
                $output .= form_error($field['name']) . PHP_EOL;
                $output .= '</div>' . PHP_EOL;
                $output .= '</div>' . PHP_EOL;
                $output .= comment_tag('end-' . $field['name'] . ' [' . $field['type'] . ']') . PHP_EOL;

                return $output;
        }

}