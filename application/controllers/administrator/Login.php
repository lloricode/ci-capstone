<?php
/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        //if already logged in, it will redirect to home view
        //to prevent see this when already logged in
        if ($this->session->userdata('validated_admin')) {
            redirect(ADMIN_DIRFOLDER_NAME);
        }
    }

    public function index($msg = NULL) {
        $this->load->helper('form');
        $this->load->view('admin/login', array(
            'msg' => $msg,
        ));
    }

    /**
     * admin login validation
     */
    public function validate() {
        // Load the model
        $this->load->model('Admin_Model');
        // Validate the admin can login
        $result = $this->Admin_Model->validate_login();
        // Now we verify the result
        // I use this because === means if same datatype else string error meesage if failed.
        if ($result === TRUE) {
            redirect(base_url(ADMIN_DIRFOLDER_NAME), 'refresh');
        } else {
            // If user did not validate, then show them login page again whith invalid message
            $msg = '<span style="color:red">' . $result . '</span>';
            $this->index($msg);
        }
    }

}
