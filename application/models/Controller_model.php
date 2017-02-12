<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Controller_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'controllers';
                $this->primary_key = 'controller_id';


                $this->has_many['permission'] = array(
                    'foreign_model' => 'Permission_model',
                    'foreign_table' => 'permissions',
                    'foreign_key'   => 'permission_id',
                    'local_key'     => 'permission_id'
                );
                $this->timestamps              = TRUE;
                $this->return_as               = 'object';
                $this->timestamps_format       = 'timestamp';
                parent::__construct();
        }

}
