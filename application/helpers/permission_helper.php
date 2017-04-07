<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('permission_controllers'))
{

        /**
         * 
         *  get all permission controllers in current user,except when enrollment is disabled
         * 
         * if current user has "admin" group, it will just return all controller names,except when enrollment is disabled
         * 
         * 
         * @param bool $bool_return TRUE if only bool return else an ARRAY of controllers of current user
         * @return mixed bool|array
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function permission_controllers($check_controller = '')
        {
                $CI                     = &get_instance();
                $enrollment_open_status = $CI->Enrollment_status_model->status();

                /**
                 * check if admin, then just return all controller names
                 * except when enrollment is disabled
                 */
                if ($CI->ion_auth->is_admin())
                {
                        $obj   = $CI->Controller_model->
                                fields('controller_name,controller_enrollment_open')->
                                //set_cache()->
                                get_all();
                        $array = array();
                        foreach ($obj as $v)
                        {
                                if ( ! $enrollment_open_status)
                                {
                                        if ($v->controller_enrollment_open)
                                        {
                                                continue; //skip
                                        }
                                }
                                $array[] = $v->controller_name;
                        }
                        if ($check_controller != '')
                        {
                                return (bool) in_array($check_controller, $array);
                        }
                        else
                        {
                                return $array;
                        }
                }


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
                                 * get all controller id's in permission table where group id is equal
                                 */
                                $p_o = $CI->Permission_model->where(array('group_id' => $g->id))->
                                        set_cache('permission_controllers_group_' . $g->id)->
                                        get_all();
                                if ($p_o)
                                {
                                        foreach ($p_o as $p)
                                        {
                                                /**
                                                 * get all controller where controller id
                                                 */
                                                $c = $CI->Controller_model->
                                                        fields('controller_name,controller_enrollment_open')->
                                                        set_cache('permission_controllers_' . $p->controller_id)->
                                                        get($p->controller_id);
                                                if ($c)
                                                {
                                                        if ( ! $enrollment_open_status)
                                                        {
                                                                if ($c->controller_enrollment_open)
                                                                {
                                                                        continue; //skip
                                                                }
                                                        }
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

if ( ! function_exists('specific_groups_permission'))
{

        /**
         * check depend on parameter if current user is has user_group,
         * 
         * if current user is admin, it will just return TRUE
         * 
         * @param string/array $current_groups post_fix of config in common/user_group.php
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function specific_groups_permission($current_groups)
        {

                $CI = &get_instance();
                if ($CI->ion_auth->is_admin())//is admin?
                {
                        return TRUE; //just return TRUE
                }


                if ( ! is_array($current_groups))
                {
                        $current_groups = array($current_groups);
                }
                $user_groups = array();
                foreach ($current_groups as $g)
                {
                        $user_groups[] = $CI->config->item('user_group_' . $g);
                }
                $user_groups_ion_auth = $CI->ion_auth->get_users_groups()->result();

                foreach ($user_groups as $v)
                {
                        foreach ($user_groups_ion_auth as $vv)
                        {
                                if ($vv->name == $v)
                                {
                                        return TRUE;
                                }
                        }
                }
                return FALSE;
        }

}