<?php


defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language in URL for CodeIgniter.
 *
 * @author		Walid Aqleh <waleedakleh23@hotmail.com>
 * @version		1.1.1
 * @based on	        Internationalization (i18n) library for CodeIgniter 2 by Jerome Jaglale (http://jeromejaglale.com/doc/php/codeigniter_i18n)
 * @link https://github.com/waqleh/CodeIgniter-Language-In-URL-Internationalization-
 */

class MY_Config extends CI_Config {

    function site_url($uri = '', $protocol = NULL) {
        if (is_array($uri)) {
            $uri = implode('/', $uri);
        }

        if (class_exists('CI_Controller')) {
            $CI = & get_instance();
            $uri = $CI->lang->localized($uri);
        }

        return parent::site_url($uri);
    }

}