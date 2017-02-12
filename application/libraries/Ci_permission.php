<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class CI_permission
{


        private $CI;

        public function __construct()
        {
                $this->CI = &get_instance();
                $this->CI->load->model('Permission_model');
        }

        /**
         * 
         * @param int $controller_id
         * @return array group ids
         */
        public function controller_groups($controller_id)
        {
                $group_ids      = array();
                $permission_obj = $this->CI->Permission_model->where(array(
                            'controller_id' => $controller_id
                        ))->get_all();
                if ($permission_obj)
                {
                        foreach ($permission_obj as $p)
                        {
                                $group_ids[] = $p->group_id;
                        }
                }
                return $group_ids;
        }

        public function controller_remove_all_group($controller_id)
        {
                return (bool) $this->CI->Permission_model->delete(array(
                            'controller_id' => $controller_id
                ));
        }

        public function add_permision($controller_id, $group_id)
        {
                $per_arr                  = array(
                    'controller_id'   => $controller_id,
                    'group_id'        => $group_id,
                    'updated_user_id' => $this->CI->ion_auth->user()->row()->id,
                );
                return (bool) $this->CI->permission_ids = $this->CI->Permission_model->insert($per_arr);
        }

}
