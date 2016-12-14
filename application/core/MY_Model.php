<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('no direct script allowed');

class MY_Model extends CI_Model {

    public $my_debug_viewer;

    function __construct() {
        parent::__construct();
        $this->my_debug_viewer = (bool) (ENVIRONMENT === 'development'); //this is for debugging propose
    }

    /**
     * 
     * @param string $table
     * @param array $column column names
     * @param array $orderby col ord
     * @return boolean|resultset
     */
    public function my_select($table, $column = NULL, $orderby = NULL) {
        $this->load->database();
        $this->db->select('*');
        if (!is_null($column)) {
            foreach ($column as $k => $value) {
                $this->db->where($k, $value);
            }
        }
        if (!is_null($orderby)) {
            $this->db->order_by($orderby['col'], $orderby['ord']);
        }
        $rs = $this->db->get($table);
        log_message('debug', $this->db->last_query());
        if ($this->my_debug_viewer) {
            echo '<!-- ' . $this->db->last_query() . ' -->';
        }
        if ($rs->row()) {
            return $rs;
        }
        return FALSE;
    }

    /**
     * 
     * @param string $table
     * @param array $data_vale
     * @return bool 
     */
    public function my_insert($table, $data_vale) {
        $this->load->database();
        $this->db->insert($table, $data_vale);
        log_message('debug', $this->db->last_query());
        if ($this->my_debug_viewer) {
            echo '<!-- ' . $this->db->last_query() . ' -->';
        }
        return (bool) $this->db->affected_rows();
    }

    /**
     * 
     * @param string $table
     * @param array $set
     * @param array $where
     * @return bool
     */
    public function my_update($table, $set, $where = NULL) {
        $this->load->database();
        if (!is_null($where)) {
            $this->db->where($where);
        }
        $this->db->update($table, $set);
        log_message('debug', $this->db->last_query());
        if ($this->my_debug_viewer) {
            echo '<!-- ' . $this->db->last_query() . ' -->';
        }
        return (bool) $this->db->affected_rows();
    }


}
