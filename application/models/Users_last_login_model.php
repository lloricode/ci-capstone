<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users_last_login_model extends MY_Model
{

        public function __construct()
        {
                $this->table                        = 'users_last_logins';
                $this->primary_key                  = 'users_last_login_id';
                
                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
