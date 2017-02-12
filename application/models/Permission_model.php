<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Permission_model extends MY_Model
{

        public function __construct()
        {
                $this->table                     = 'permissions';
                $this->primary_key               = 'permission_id';
                $this->has_one['group'] = array(
                    'foreign_model' => 'Group_model',
                    'foreign_table' => 'groups',
                    'foreign_key'   => 'id',
                    'local_key'     => 'group_id'
                );
                 $this->has_many['controller'] = array(
                    'foreign_model' => 'Controller_model',
                    'foreign_table' => 'controllers',
                    'foreign_key'   => 'controller_id',
                    'local_key'     => 'controller_id'
                );
                


                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
