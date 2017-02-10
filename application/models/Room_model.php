<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Room_model extends MY_Model
{

        public function __construct()
        {
                $this->table                     = 'rooms';
                $this->primary_key               = 'room_id';
                $this->has_many['subject_offer'] = array(
                    'foreign_model' => 'Subject_offer_model',
                    'foreign_table' => 'subject_offers',
                    'foreign_key'   => 'subject_offer_id',
                    'local_key'     => 'subject_offer_id'
                );
                


                $this->timestamps        = TRUE;
                $this->return_as         = 'object';
                $this->timestamps_format = 'timestamp';
                parent::__construct();
        }

}
