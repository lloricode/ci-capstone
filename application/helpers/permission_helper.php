<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('permission_controllers'))
{

        /**
         * 
         *  get all permission controllers in current user
         * 
         * @param bool $bool_return TRUE if only bool return else an ARRAY of controllers of current user
         * @return mixed bool|array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function permission_controllers($check_controller = '')
        {
                $CI          = &get_instance();
                /**
                 * get all groups of current user
                 */
                $user_groups = $CI->ion_auth->get_users_groups()->result();
                /**
                 * controller names stored
                 */
                $controllers = array();
                if ($user_groups)
                {
                        foreach ($user_groups as $g)
                        {
                                /**
                                 * get all controller ids in permission table where group id is equeal
                                 */
                                $p_o = $CI->Permission_model->where(array('group_id' => $g->id))->get_all();
                                if ($p_o)
                                {
                                        foreach ($p_o as $p)
                                        {
                                                /**
                                                 * get all controller where controller id
                                                 */
                                                $c = $CI->Controller_model->get($p->controller_id);
                                                if ($c)
                                                {
                                                        /**
                                                         * push array here
                                                         */
                                                        $controllers[] = $c->controller_name;
                                                }
                                        }
                                }
                        }
                }
                if ($check_controller != '')
                {
                        return (bool) in_array($check_controller, $controllers);
                }
                else
                {
                        return $controllers;
                }
        }

}