<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Controller_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'controllers';
                $this->primary_key = 'controller_id';


                $this->_relations();
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = (bool) $this->config->item('my_model_timestamps');
                $this->return_as         = $this->config->item('my_model_return_as');
                $this->timestamps_format = $this->config->item('my_model_timestamps_format');


                $this->cache_driver = $this->config->item('my_model_cache_driver');
                $this->cache_prefix = $this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //$this->remove_empty_before_write = (bool) $this->config->item('my_model_remove_empty_before_write');
                //$this->delete_cache_on_save      = (bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_many['permission'] = array(
                    'foreign_model' => 'Permission_model',
                    'foreign_table' => 'permissions',
                    'foreign_key'   => 'permission_id',
                    'local_key'     => 'permission_id'
                );
        }

}
