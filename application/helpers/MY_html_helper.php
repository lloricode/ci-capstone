<?php

defined('BASEPATH') or exit('no direct script allowed');

if ( ! function_exists('my_htmlspecialchars'))
{

        /**
         * Convert special characters to HTML entities
         * 
         * @param string $string
         * @return string
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        function my_htmlspecialchars($string)
        {
                return htmlspecialchars($string, ENT_QUOTES, get_instance()->config->item('charset'));
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('paragraph'))
{

        /**
         * Paragraph
         *
         * Generates an HTML paragraph tag.
         *
         * @param	string	content
         * @param	string
         * @return	string
         */
        function paragraph($data = '', $attributes = '')
        {
                return '<p' . _stringify_attributes($attributes) . '>' . $data . '</p>';
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('strong'))
{

        /**
         * Paragraph
         *
         * Generates an HTML paragraph tag.
         *
         * @param	string	content
         * @param	string
         * @return	string
         */
        function strong($data = '', $attributes = '')
        {
                return '<strong' . _stringify_attributes($attributes) . '>' . $data . '</strong>';
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('image_view'))
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

// ------------------------------------------------------------------------

if ( ! function_exists('script_tag'))
{

        /**
         * Script
         *
         * Generates an HTML script tag.
         *
         * @param	string	content
         * @return	string
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        function script_tag($src = '')
        {
                $link = '';

                if ( ! preg_match('#^([a-z]+:)?//#i', $src))
                {
                        $link .= get_instance()->config->slash_item('base_url') . $src;
                }
                else
                {
                        $link .= $src;
                }

                return '<script src="' . $link . '"></script>' . PHP_EOL;
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('comment_tag'))
{

        /**
         * Comment
         *
         * Generates an HTML Comment tag.
         *
         * @param	string	content
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        function comment_tag($conntent = '')
        {

                return PHP_EOL . '<!-- ' . $conntent . ' -->' . PHP_EOL;
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('generate_link_script_tag'))
{

        /**
         * 
         * @param array $header
         * @param array $footer
         * @return array header|footer
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        function generate_link_script_tag($header = array(), $footer = array(), $footer_extra = '')
        {
                $bootstarp_dir = get_instance()->config->item('bootstarp_dir');

                /**
                 * will stored value
                 * type string
                 */
                $header_bootstrap = '';
                $footer_bootstrap = '';
                /**

                 * storing for header
                 */
                if (isset($header['css']))
                {
                        foreach ($header['css'] as $v)
                        {
                                if ( ! preg_match('#^([a-z]+:)?//#i', $v))
                                {
                                        $v = $bootstarp_dir . $v;
                                }
                                $header_bootstrap .= link_tag($v);
                        }
                }
                if (isset($header['js']))
                {
                        foreach ($header['js'] as $v)
                        {
                                if ( ! preg_match('#^([a-z]+:)?//#i', $v))
                                {
                                        $v = $bootstarp_dir . $v;
                                }
                                $header_bootstrap .= script_tag($v);
                        }
                }
                /**
                 * storing for footer
                 */
                if (isset($footer['css']))
                {
                        foreach ($footer['css'] as $v)
                        {
                                if ( ! preg_match('#^([a-z]+:)?//#i', $v))
                                {
                                        $v = $bootstarp_dir . $v;
                                }
                                $footer_bootstrap .= link_tag($v);
                        }
                }
                if (isset($footer['js']))
                {
                        foreach ($footer['js'] as $v)
                        {
                                if ( ! preg_match('#^([a-z]+:)?//#i', $v))
                                {
                                        $v = $bootstarp_dir . $v;
                                }
                                $footer_bootstrap .= script_tag($v);
                        }
                }
                /**
                 * return all
                 */
                return array(
                    'header'       => $header_bootstrap,
                    'footer'       => $footer_bootstrap,
                    'footer_extra' => $footer_extra,
                );
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('table_row_button_link'))
{

        /**
         * generate button view for table column row
         * 
         * @param string $link
         * @param string $label
         * @param string $additional
         * @return string html
         * @author Lloric Garcia <emorickfighter@gmail.com>
         */
        function table_row_button_link($link, $label, $additional = NULL, $attibutes = NULL)
        {
                return anchor(
                        //url link
                        $link,
                        //label for user interface
                        '<button class="btn btn-mini' . (( ! is_null($additional) ? ' ' . $additional : '')) . '">' . $label . '</button>',
                        /**
                         * attributes if not null
                         */ $attibutes
                );
        }

}