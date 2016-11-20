<?php

/**
 * 
 * @author Lloric Mauga Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Form_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

    /**
     * 
     * @param array keys[ caption|action|button_name|button_title ] 
     * @param array keys[ 
     * 
     * 
     * 
     * 
     * 
     *  ]
     */
    public function form_view($form, $inputs) {
        $this->load->view('admin/form', array(
            'my_form' => $form,
            'my_forms_inputs' => $inputs,
        ));
    }

}
