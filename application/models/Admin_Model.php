<?php

/**
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Admin_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * validation rules
     * just call this in insert or update admin data,
     * so less repeated in codings
     * so happy :D, so neat
     * 
     * @access private
     */
    private function admin_validation() {
        //need to load this database loader here, bacause validation need to check if username is exist in admin table
        $this->load->database();

        $this->form_validation->set_rules(
                'fullname', 'Fullname', 'required|regex_match[' . FULLNAME_REGEX . ']|min_length[8]', array(
            'required' => 'You have not provided %s.',
            'regex_match' => 'Invalid %s format.'
                )
        );
        $this->form_validation->set_rules(
                'username', 'Username', 'required|is_unique[admin.admin_username]|regex_match[' . USERNAME_REGEX . ']', array(
            'required' => 'You have not provided %s.',
            'is_unique' => 'This %s already exists.',
            'regex_match' => 'Invalid %s format.'
                )
        );
        $this->form_validation->set_rules(
                'password', 'Password', 'required|regex_match[' . PASSWORD_REGEX . ']', array(
            'required' => 'You have not provided %s.',
            'regex_match' => PASSWORD_MSG_REGEX
                )
        );
    }

    /**
     * only this model to allowed to set add admin view
     * form view of adding admin
     * @access private
     */
    private function admin_form_view() {
        $my_form = array(
            'caption' => 'Add Admin',
            'action' => '',
            'button_name' => 'addadmin',
            'button_title' => 'Add Admin',
        );

        $my_inputs = array(
            'left' =>
            array(
                'size' => '12',
                'attr' =>
                array(
                    'fullname' => array(
                        'title' => 'Fullname',
                        'type' => 'text',
                        'value' => NULL,
                    ),
                    'username' => array(
                        'title' => 'Username',
                        'type' => 'text',
                        'value' => NULL,
                    ),
                    'password' => array(
                        'title' => 'Password',
                        'type' => 'text',
                        'value' => NULL,
                    ),
                )
            ),
        );
        $this->load->model('Form_Model');
        $this->Form_Model->form_view($my_form, $my_inputs);
    }

    public function add() {
        $this->load->library('form_validation');
        //initialise validation
        $this->admin_validation();
        $this->form_validation->set_error_delimiters('<span class="help-block"><i class="fa fa-warning"></i>', '</span>');
        if (!$this->form_validation->run()) {
            //admin form view
            $this->admin_form_view();
        } else {
            $admin = array(
                'admin_fullname' => $this->input->post('fullname'),
                'admin_username' => $this->input->post('username'),
                'admin_password' => password_hash($this->input->post('password'), TRUE),
                'admin_status' => 1,
            );
            $msg = ($this->insert_admin($admin)) ? 'Admin added!.' : 'Failed to add admin.';
            //load view to promt insert status 
            $this->load->view('admin/done', array(
                'msg' => $msg,
            ));
        }
    }

    /**
     * for table view
     * 
     * @return array admins data for table view
     */
    public function all_admins() {
        $data = array();
        $admins = $this->get_admin();
        $inc = 1;
        foreach ($admins as $admin) {
            array_push($data, array(
                'inc' => $inc++,
                'fullname' => $admin['fullname'],
                'username' => $admin['username'],
                'status' => $admin['status'],
                'option' => anchor(base_url(ADMIN_DIRFOLDER_NAME . 'users#'), 'sample'),
            ));
        }
        return $data;
    }

    /**
     * insert data in admin table
     * 
     * note: no need to load database library, it is already load in validating input user
     * 
     * @param array $admin
     * @return bool TRUE if success
     */
    private function insert_admin($admin) {
        $this->db->insert('admin', $admin);
        log_message('debug', $this->db->last_query());
        return $this->db->affected_rows();
    }

    /**
     * Selecting data from admin table
     * to prevent repeated calling CI_DB_mysqli_drive::select() 
     * for admin table
     * 
     * @param array $admin : key: column name | value : input
     * @return boolean|array
     * @access private
     */
    private function get_admin($admin = NULL) {
        $this->load->database();
        $this->db->select('*');
        if (!is_null($admin)) {
            foreach ($admin as $k => $value) {
                $this->db->where($k, $value);
            }
        }
        $rs = $this->db->get('admin');
        log_message('debug', $this->db->last_query());
        if ($rs->row()) {
            $data = array();
            foreach ($rs->result() as $row) {
                array_push($data, array(
                    'id' => $row->admin_id,
                    'fullname' => $row->admin_fullname,
                    'username' => $row->admin_username,
                    'password' => $row->admin_password,
                    'status' => $row->admin_status,
                ));
            }
            return $data;
        }
        return FALSE;
    }

    /**
     * 
     * @return boolean|string TRUE if success|string if failed with corresponding invalid massage for view
     */
    public function validate_login() {

        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');

        $admin = $this->get_admin(array(
            'admin_username' => $usr,
        ));

        if ($admin) {

            //convert multidimention array to a single array, 
            //redundun to use foreach because it is only one row/value
            $admin_ = $admin[0];

            if (password_verify($pwd, $admin_['password'])) {
                if ($admin_['status']) {
                    $this->session->set_userdata(array(
                        'admin_id' => $admin_['id'],
                        'admin_fullname' => $admin_['fullname'],
                        'validated_admin' => TRUE,
                    ));
                    return TRUE;
                } else {
                    return 'User Disabled.';
                }
            } else {
                return 'Invalid username and/or password.';
            }
        } else {
            return 'Invalid username and/or password.';
        }
    }

}
