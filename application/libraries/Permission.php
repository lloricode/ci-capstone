<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Permission
{

        public function __construct()
        {
                $this->load->model('Permission_model');
        }

        /**
         * prevent calling undefined functions
         * 
         * @param type $name
         * @param type $arguments
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __call($name, $arguments)
        {
                show_error('method <b>"$this->' . strtolower(get_class()) . '->' . $name . '()"</b> not found in ' . __FILE__ . '.');
        }

        /**
         * easy access CI super global
         * 
         * 
         * @param type $name
         * @return mixed
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __get($name)
        {
                /**
                 * CI reference
                 */
                return get_instance()->$name;
        }

        /**
         * get all user_groups id(s) that allowed permission in controller id as parameter
         * 
         * @param int $controller_id
         * @return array | array of group id
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function controller_groups($controller_id)
        {
                $group_ids      = array();
                $permission_obj = $this->Permission_model->where(array(
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

        /**
         * remove all user_groups id(s) in controller id as parameter
         * 
         * @param int $controller_id
         * @return bool depend on success
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function controller_remove_all_group($controller_id)
        {
                return (bool) $this->Permission_model->delete(array(
                            'controller_id' => $controller_id
                ));
        }

        /**
         * insert permission
         * 
         * @param int $controller_id
         * @param int $group_id
         * @return bool depend on success
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function add_permision($controller_id, $group_id)
        {
                $per_arr = array(
                    'controller_id'   => $controller_id,
                    'group_id'        => $group_id
                );
                return (bool) $this->Permission_model->insert($per_arr);
        }

}
