<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * if not exist 404 will occurred
 * 
 * @param string $id id from url | default NULL to prevent error in case user modify url
 * @param array $coumn column from table on database
 * @param string $model  model to get table name
 * @return row data from table
 */
function check_id_form_url($id = NULL, $coumn, $model) {
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
