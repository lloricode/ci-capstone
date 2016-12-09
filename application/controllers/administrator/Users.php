<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();
    }

    private function admin_validation() {
        $this->load->database();
        $this->my_input = array(
            array(
                'field' => 'fullname',
                'label' => 'Fullname',
                'rules' => 'required|human_name|min_length[4]|max_length[20]',
                'type' => 'text'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|is_unique[admin.admin_username]|valid_username|min_length[4]|max_length[15]',
                'type' => 'text'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|password_level[3]',
                'type' => 'text',
            ),
        );
    }

    public function index() {

        $this->my_header_view();

        $this->load->model('Admin_Model');

        $this->load->view('admin/button_view', array(
            'href' => 'users/add-admin',
            'button_label' => 'Add Admin'
        ));
        $this->load->view('admin/table', array(
            'caption' => 'Admin List',
            'table' => $this->Admin_Model->table_view(),
        ));

        $this->load->view('admin/footer', array(
            'controller' => 'table'
        ));
    }

    public function admin_change_status($admin_id = NULL) {
        $this->load->helper('url');
        $row = check_id_from_url('admin_id', 'Admin_Model', $admin_id);

        //no need to load model, its already loaded         ^^^^
        //to prevent change status in current logged user
        if ($row->admin_id != $this->session->userdata('admin_id')) {
            $this->Admin_Model->update(
                    array('admin_status' => ($row->admin_status) ? FALSE : TRUE), array('admin_id' => $row->admin_id)
            );
        }
        $this->index();
    }

    public function add_admin() {
        $this->my_header_view();

        $this->load->library('form_validation');

        $this->admin_validation();
        $this->form_validation->set_rules($this->my_input);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        if ($this->form_validation->run()) {
            $this->add_admin_process();
        } else {
            $this->admin_form();
        }

        $this->load->view('admin/footer');
    }

    private function add_admin_process() {
        $this->load->model('Admin_Model');
        $this->load->library('Password');
        $admin = array(
            'admin_fullname' => $this->input->post('fullname', TRUE),
            'admin_username' => $this->input->post('username', TRUE),
            'admin_password' => $this->password->generate_hash($this->input->post('password')),
        );
        $msg = ($this->Admin_Model->add($admin)) ? 'Admin added!.' : 'Failed to add admin.';
        //load view to promt insert status 
        $this->load->view('admin/done', array(
            'msg' => $msg,
        ));
    }

    private function admin_form() {
        $this->load->helper('form');
        $myform = array(
            'action' => 'users/add-admin',
            'button_name' => 'add_admin_button',
            'button_label' => 'Add Admin',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Admin'
        ));
    }

}
