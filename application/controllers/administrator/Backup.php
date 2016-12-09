<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('Direct Script is not allowed');

class Backup extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->my_header_view();


        $this->load->view('admin/button_view', array(
            'href' => 'backup/download',
            'button_label' => 'Download Back up Database'
        ));


        $this->load->view('admin/backup');
        $this->load->view('admin/footer');
    }

    public function download() {
        $this->load->helper('back_up');

        backup_database();
    }

}
