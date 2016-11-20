<?php

/**
 * Php Log class
 *
 * Display the php log
 *
 * @category	Log
 * @author		Nicolás Bistolfi
 * @link		https://dl.dropboxusercontent.com/u/20596750/code/php/log.php
 */
defined('BASEPATH') or exit('no direct script allowed');

class Log extends MY_Controller {

    private $logPath; //path to the php log

    /**
     * 	Class constructor
     */

    function __construct() {
        parent::__construct();
        $this->logPath = ini_get('error_log');
    }

    /**
     * index: Shows the php error log
     * @access public
     */
    public function index() {
        $this->my_header_view();
        //  echo nl2br(@file_get_contents($this->logPath));
        if (@is_file($this->logPath)) {
            $this->load->view('admin/log', array(
                'msg' => nl2br(@file_get_contents($this->logPath))
            ));
        } else {
            $this->load->view('admin/log', array(
                'msg' => 'The log cannot be found in the specified route ' . $this->logPath
            ));
        }
        $this->load->view('admin/footer');
        // exit;
    }

    /**
     * delete: Deletes the php error log
     * @access public
     */
    public function delete() {
        if (@is_file($this->logPath)) {
            if (@unlink($this->logPath)) {
                echo 'PHP Error Log deleted';
            } else {
                echo 'There has been an error trying to delete the PHP Error log ' . $this->logPath;
            }
        } else {
            echo 'The log cannot be found in the specified route  ' . $this->logPath . '.';
        }
        //   exit;
    }

}
