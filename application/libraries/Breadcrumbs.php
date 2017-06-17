<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// inspired from the source >> https://github.com/nobuti/Codeigniter-breadcrumbs
class Breadcrumbs
{


        protected $CI;
        private $breadcrumbs = array();

        public function __construct()
        {

                $this->CI = & get_instance();
                $this->CI->config->load('breadcrumbs', TRUE);

                $this->breadcrumb_open               = $this->CI->config->item('breadcrumb_open', 'breadcrumbs');
                $this->breadcrumb_close              = $this->CI->config->item('breadcrumb_close', 'breadcrumbs');
                $this->breadcrumb_el_open            = $this->CI->config->item('breadcrumb_el_open', 'breadcrumbs');
                $this->breadcrumb_el_open_extra      = $this->CI->config->item('breadcrumb_el_open_extra', 'breadcrumbs');
                $this->breadcrumb_el_close           = $this->CI->config->item('breadcrumb_el_close', 'breadcrumbs');
                $this->breadcrumb_el_first           = $this->CI->config->item('breadcrumb_el_first', 'breadcrumbs');
                $this->breadcrumb_el_first_extra     = $this->CI->config->item('breadcrumb_el_first_extra', 'breadcrumbs');
                $this->breadcrumb_el_last_open_extra = $this->CI->config->item('breadcrumb_el_last_open_extra', 'breadcrumbs');
                $this->breadcrumb_el_last_open       = $this->CI->config->item('breadcrumb_el_last_open', 'breadcrumbs');
                $this->breadcrumb_el_last_close      = $this->CI->config->item('breadcrumb_el_last_close', 'breadcrumbs');
        }

        function array_sorter($key)
        {
                return function ($a, $b) use ($key)
                {
                        return strnatcmp($a[$key], $b[$key]);
                };
        }

        function push($id, $page, $url)
        {
                if ( ! $page OR ! $url)
                        return;

                $url = site_url($url);

                $this->breadcrumbs[$url] = array('id' => $id, 'page' => $page, 'href' => $url);
        }

        function unshift($id, $page, $url)
        {
                if ( ! $page OR ! $url)
                        return;

                if ($url != '#')
                {
                        $url = site_url($url);
                }
                array_unshift($this->breadcrumbs, array('id' => $id, 'page' => $page, 'href' => $url));
        }

        function show()
        {
                if ($this->breadcrumbs)
                {
                        $output = comment_tag('breadcrumbs') . PHP_EOL . $this->breadcrumb_open . PHP_EOL;

                        usort($this->breadcrumbs, $this->array_sorter('id'));

                        foreach ($this->breadcrumbs as $key => $value)
                        {
                                $keys = array_keys($this->breadcrumbs);

                                if ('#' == $value['href'])
                                {
                                        $extr = '';
                                        if (end($keys) == $key)
                                        {
                                                foreach ($this->breadcrumb_el_last_open_extra as $k => $v)
                                                {
                                                        $extr .= ' ' . $k . '="' . $v . '" ';
                                                }
                                        }
                                        $output .= $this->breadcrumb_el_last_open . '<a' . $extr . '>' . $value['page'] . '</a>' . $this->breadcrumb_el_last_close . $this->breadcrumb_el_close . PHP_EOL;
                                }
                                elseif (reset($keys) == $key)
                                {
                                        $output .= $this->breadcrumb_el_open . anchor($value['href'], $this->breadcrumb_el_first . ' ' . $value['page'], $this->breadcrumb_el_first_extra) . $this->breadcrumb_el_close . PHP_EOL;
                                }
                                elseif (end($keys) == $key)
                                {
                                        $this->breadcrumb_el_last_open_extra['title'] = lang('breadcrumd_refresh_to') . ' ' . $value['page'];
                                        $output                                       .= $this->breadcrumb_el_last_open . anchor($value['href'], $value['page'], $this->breadcrumb_el_last_open_extra) . $this->breadcrumb_el_last_close . $this->breadcrumb_el_close . PHP_EOL;
                                }
                                else
                                {
                                        $this->breadcrumb_el_open_extra['title'] = lang('breadcrumd_go_to') . ' ' . $value['page'];
                                        $output                                  .= $this->breadcrumb_el_open . anchor($value['href'], $value['page'], $this->breadcrumb_el_open_extra) . $this->breadcrumb_el_close . PHP_EOL;
                                }
                        }

                        return $output . $this->breadcrumb_close . PHP_EOL . comment_tag('End-breadcrumbs') . PHP_EOL;
                }

                return NULL;
        }

}
