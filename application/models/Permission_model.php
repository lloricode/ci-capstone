<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Permission_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'permissions';
                $this->primary_key = 'permission_id';

                $this->before_create[] = '_add_created_by';

                $this->_relations();
                $this->_config();

                parent::__construct();
        }

        protected function _add_created_by($data)
        {
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
                $data['updated_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver         = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix         = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //  $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_one['group']       = array(
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
        }

}
