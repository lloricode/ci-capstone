<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('navigations_main')) {

    function navigations_main() {
        return array(
            'dashboard' =>
            array(
                'label' => 'Dashboard',
                'desc' => 'Dashboard Description',
                'icon' => 'beaker',
            ),
            //sub menu
            'menus' =>
            array(
                'label' => 'Users',
                'icon' => 'user',
                'sub' =>
                array(
                    'users' =>
                    array(
                        'label' => 'Users',
                        'desc' => 'Users Description',
                        'seen' => TRUE,
                    ),
                    'create-user' =>
                    array(
                        'label' => 'Create Users',
                        'desc' => 'Create Users Description',
                        'seen' => TRUE,
                    ),
                    'edit-group' =>
                    array(
                        'label' => 'Edit Group',
                        'desc' => 'Edit Group Description',
                        'seen' => FALSE,
                    ),
                    'deactivate' =>
                    array(
                        'label' => 'Deactivate User',
                        'desc' => 'Deactivate User Description',
                        'seen' => FALSE,
                    ),
                    'edit-user' =>
                    array(
                        'label' => 'Edit User',
                        'desc' => 'Edit User Description',
                        'seen' => FALSE,
                    ),
                ),
            ),
            //sub menu
            'menus4' =>
            array(
                'label' => 'Settings',
                'icon' => 'cogs',
                'sub' =>
                array(
                    'database' =>
                    array(
                        'label' => 'Database',
                        'desc' => 'Database Description',
                        'seen' => TRUE,
                    ),
                    'log' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Logsn Description',
                        'seen' => TRUE,
                    ),
                ),
            ),
        );
    }

}


if (!function_exists('navigations_setting')) {

    function navigations_setting() {
        return array(
            'database' =>
            array(
                'label' => 'Database',
                'desc' => 'Database Description',
                'icon' => 'file',
            ),
            'log' =>
            array(
                'label' => 'Error Logs',
                'desc' => 'Error Logsn Description',
                'icon' => 'exclamation-sign',
            ),
        );
    }

}
