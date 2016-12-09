<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_id_form_url')) {

    /**
     * if not exist 404 will occurred
     * 
     * @param string $id id from url | default NULL to prevent error in case user modify url
     * @param array $coumn column from table on database
     * @param string $model  model to get table name
     * @return row data from table
     */
    function check_id_form_url($coumn, $model, $id = NULL) {
        if (is_null($id)) {
            show_404();
        }
        /**
         * Returns current CI instance object
         */
        $CI = & get_instance();

        $CI->load->model($model);
        $rs = $CI->$model->get(array(
            $coumn => $id
        ));


        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

}


if (!function_exists('save_current_url')) {

    /**
     * save to database all url receive 
     */
    function save_current_url() {
        /**
         * Returns current CI instance object
         */
        $CI = & get_instance();
        $CI->load->model('Url_Model');

        $agent = NULL;

        $CI->load->library('user_agent');

        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' - ' . $CI->agent->version();
        } elseif ($CI->agent->is_robot()) {
            $agent = $CI->agent->robot();
        } elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }


        $current_url = current_url();

        //check value
        $rs = $CI->Url_Model->get(array(
            'url_value' => $current_url,
            'url_agent' => $agent,
            'url_platform' => $CI->agent->platform(),
            'admin_id' => $CI->session->userdata('admin_id'),
        ));

        if (!$rs) {
            //insert
            $CI->Url_Model->add(array(
                'url_value' => $current_url,
                'url_agent' => $agent,
                'url_platform' => $CI->agent->platform(),
                'admin_id' => $CI->session->userdata('admin_id'),
            ));
        } else {
            $row = $rs->row();
            //update
            $count = $row->url_count;
            $CI->Url_Model->update(array('url_count' => ++$count), array('url_id' => $row->url_id));
        }
    }

}

