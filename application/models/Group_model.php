<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Group_model extends MY_Model
{

        public function __construct()
        {
                $this->table             = 'groups';
                $this->primary_key       = 'id';
                //   $this->soft_deletes = true;
                //$this->has_one['details'] = 'User_details_model';
                // $this->has_one['details'] = array('User_details_model','user_id','id');
                //  $this->has_one['details'] = array('local_key' => 'id', 'foreign_key' => 'user_id', 'foreign_model' => 'User_details_model');
                // $this->has_many['posts'] = 'Post_model';
                $this->has_many['permission'] = array(
                    'foreign_model' => 'Permission_model',
                    'foreign_table' => 'permissions',
                    'foreign_key'   => 'permission_id',
                    'local_key'     => 'permission_id'
                );

                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
