<?php

/**
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class Admin_Model extends MY_Model {

    const db_table = 'admin';

    function __construct() {
        parent::__construct();
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

    public function update($set, $w = NULL) {
        return $this->my_update(self::db_table, $set, $w);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    public function table_view() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            $inc = 1;
            foreach ($rs->result() as $row) {
                array_push($data, array(
                    'inc' => $inc++,
                    'fullname' => $row->admin_fullname,
                    'username' => $row->admin_username,
                    'status' => ($row->admin_status) ? '<span class="badge badge-success">Enabled</span>' : '<span class="badge badge-important">Disabled</span>',
                    'option' =>
                    anchor(
                            base_url(ADMIN_DIRFOLDER_NAME . 'users/admin-change-status/' . $row->admin_id), 'set ' . (($row->admin_status) ? 'disable' : 'enable'), array(
                        'class' => 'btn btn-success btn-mini'
                            )
                    )
                    . ' | ' .
                    anchor(
                            base_url(ADMIN_DIRFOLDER_NAME . 'users/#'), 'update', array(
                        'class' => 'btn btn-success btn-mini'
                            )
                    )
                ));
            }
        }
        $header = array(
            'inc' => '#',
            'fullname' => 'Fullname',
            'username' => 'Username',
            'status' => 'Status',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    /**
     * 
     * @return boolean|string TRUE if success|string if failed with corresponding invalid massage for view
     */
    public function validate_login() {

        $usr = $this->input->post('username', TRUE);
        $pwd = $this->input->post('password', TRUE);

        $rs = $this->my_select(self::db_table, array(
            'admin_username' => $usr,
        ));

        if ($rs) {
            $this->load->library('Password');
            $row = $rs->row();

            if ($this->password->check_password($pwd, $row->admin_password)) {
                if ($row->admin_status) {
                    $this->session->set_userdata(array(
                        'admin_id' => $row->admin_id,
                        'admin_fullname' => $row->admin_fullname,
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
