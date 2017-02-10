<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_offer_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subject_offers';
                $this->primary_key = 'subject_offer_id';

                $this->has_one['subject'] = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                $this->has_one['room'] = array(
                    'foreign_model' => 'Room_model',
                    'foreign_table' => 'rooms',
                    'foreign_key'   => 'room_id',
                    'local_key'     => 'room_id'
                );
                $this->has_one['faculty'] = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'user_id'
                );
                


                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
