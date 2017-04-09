<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Group_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'groups';
                $this->primary_key = 'id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

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
                //    $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
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

        public function button_link($param)
        {
                $id          = NULL;
                $name        = NULL;
                $description = NULL;

                if (is_int($param))
                {
                        $obj         = $this->get($param);
                        $id          = $obj->id;
                        $name        = $obj->name;
                        $description = $obj->description;
                }
                elseif (is_object($param))
                {
                        $id          = $param->id;
                        $name        = $param->name;
                        $description = $param->description;
                }

                if ( ! in_array('edit-group', permission_controllers()))
                {
                        return $name . ' ';
                }
                return table_row_button_link("edit-group?group-id=" . $id, $name, NULL, array('title' => $description));
        }

}
