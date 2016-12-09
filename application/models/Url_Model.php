<?php

/**
 * 
 * @author Lloric Mauga Garcia <emorickfighter@gmail.com>
 */
class Url_Model extends MY_Model {

    const db_table = 'url';

    public function __construct() {
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
            $this->load->model('Admin_Model');
            $inc = 1;
            foreach ($rs->result() as $row) {
                $admin = 'not logged in';
                $rs_a = $this->Admin_Model->get(array('admin_id' => $row->admin_id));
                if ($rs_a) {
                    $admin = $rs_a->row()->admin_fullname;
                }
                array_push($data, array(
                    'inc' => $inc++,
                    'url' => $row->url_value,
                    'agent' => $row->url_agent,
                    'platform' => $row->url_platform,
                    'count' => $row->url_count,
                    'admin' => $admin,
                    'client' => 'not implemeted yet.',
                ));
            }
        }
        $header = array(
            'inc' => '#',
            'url' => 'Url',
            'agent' => 'Agent',
            'platform' => 'Platform',
            'count' => 'Visited Count',
            'admin' => 'Admin',
            'client' => 'User',
        );
        return $this->my_table_view($header, $data);
    }

}
