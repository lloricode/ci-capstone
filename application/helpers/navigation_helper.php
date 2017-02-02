<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('navigations_main'))
{

        /**
         * 
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function navigations_main()
        {
                return array(
                    'home' =>
                    array(
                        'label' => 'Home',
                        'desc'  => 'Home Description',
                        'icon'  => 'beaker',
                    ),
                    //sub menu
                    'menus'     =>
                    array(
                        'label' => lang('index_heading'),
                        'icon'  => 'user',
                        'sub'   =>
                        array(
                            'users'       =>
                            array(
                                'label' => lang('index_heading'),
                                'desc'  => 'Users Description',
                                'seen'  => TRUE,
                            ),
                            'create-user' =>
                            array(
                                'label' => lang('create_user_heading'),
                                'desc'  => 'Create Users Description',
                                'seen'  => TRUE,
                            ),
                            'edit-group'  =>
                            array(
                                'label' => lang('edit_group_title'),
                                'desc'  => 'Edit Group Description',
                                'seen'  => FALSE,
                            ),
                            'deactivate'  =>
                            array(
                                'label' => lang('deactivate_heading'),
                                'desc'  => 'Deactivate User Description',
                                'seen'  => FALSE,
                            ),
                            'edit-user'   =>
                            array(
                                'label' => lang('edit_user_heading'),
                                'desc'  => 'Edit User Description',
                                'seen'  => FALSE,
                            ),
                        ),
                    ),
                    //sub menu
                    'menus4'    =>
                    array(
                        'label' => 'Settings',
                        'icon'  => 'cogs',
                        'sub'   =>
                        array(
                            'language' =>
                            array(
                                'label' => lang('lang_label'),
                                'desc'  => 'Language Description',
                                'seen'  => TRUE,
                            ),
                            'database' =>
                            array(
                                'label' => 'Database',
                                'desc'  => 'Database Description',
                                'seen'  => TRUE,
                            ),
                            'log'      =>
                            array(
                                'label' => 'Error Logs',
                                'desc'  => 'Error Logsn Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                );
        }

}


if (!function_exists('navigations_setting'))
{

        /**
         * 
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function navigations_setting()
        {
                return array(
                    'language' =>
                    array(
                        'label' => lang('lang_label'),
                        'desc'  => 'Language Description',
                        'icon'  => 'file',
                    ),
                    'database' =>
                    array(
                        'label' => 'Database',
                        'desc'  => 'Database Description',
                        'icon'  => 'file',
                    ),
                    'log'      =>
                    array(
                        'label' => 'Error Logs',
                        'desc'  => 'Error Logsn Description',
                        'icon'  => 'exclamation-sign',
                    ),
                );
        }

}
