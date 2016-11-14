<?php

defined('BASEPATH') or exit('no direct script allowed');

class Admin_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

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
     * Selecting data from admin table
     * @param array $admin : key: column name | value : input
     * @return boolean|array
     */
    public function get_admin($admin = NULL) {
        $this->db->select('*');
        if (!is_null($admin)) {
            foreach ($admin as $k => $value) {
                $this->db->where($k, $admin[$k]);
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

    public function validate() {
        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');

        $admin = $this->get_admin(array(
            'admin_username' => $usr,
        ));

        if ($admin) {
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
