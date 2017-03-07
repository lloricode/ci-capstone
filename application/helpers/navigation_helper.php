<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('navigations_main'))
{

        /**
         * navigation in project
         * 
         * @return array-multi
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function navigations_main()
        {
                return array(
                    'home'                =>
                    array(
                        'label' => lang('home_label'),
                        'icon'  => 'home',
                    ),
                    //---------START curriculum-----
                    'curriculum_menu'     =>
                    array(
                        'label' => lang('curriculum_label'),
                        'icon'  => 'book',
                        'sub'   =>
                        array(
                            /**
                             * viewer
                             */
                            'curriculums'               =>
                            array(
                                'label' => lang('view_curriculum_label'),
                                'seen'  => TRUE,
                            ),
                            /**
                             * create
                             */
                            'create-curriculum'         =>
                            array(
                                'label' => lang('create_curriculum_label'),
                                'seen'  => TRUE,
                            ),
                            'create-curriculum-subject' =>
                            array(
                                'label' => lang('create_curriculum_subject_label'),
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //---------END curriculum-------
                    //---------STUDENT------------
                    'student_menu'        =>
                    array(
                        'label' => lang('index_student_heading'),
                        'icon'  => 'user-md',
                        'sub'   =>
                        array(
                            'students'       =>
                            array(
                                'label' => lang('view_student_label'),
                                'seen'  => TRUE,
                            ),
                            'create-student' =>
                            array(
                                'label' => lang('create_student_heading'),
                                'seen'  => TRUE,
                            ),
                            'edit-student'   =>
                            array(
                                'label' => 'Edit Student',
                                'seen'  => FALSE,
                            ),
                        ),
                    ),
                    //---------END STUDENT--------
                    //sub menu
                    //--------START SCHEDULE------
                    'subject_offer_menu'  =>
                    array(
                        'label' => lang('index_subject_heading_th'),
                        'icon'  => 'calendar',
                        'sub'   =>
                        array(
                            'subjects'             =>
                            array(
                                'label' => lang('view_subject_label'),
                                'seen'  => TRUE,
                            ),
                            'create-subject'       =>
                            array(
                                'label' => lang('create_subject_heading'),
                                'seen'  => TRUE,
                            ),
                            'subject-offers'       =>
                            array(
                                'label' => lang('view_subject_offer_label'),
                                'seen'  => TRUE,
                            ),
                            'create-subject-offer' =>
                            array(
                                'label' => lang('create_subject_offer_heading'),
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //--------END SCHEDULE--------
                    //--------START UTILITIES--------
                    'utilities_menu'      =>
                    array(
                        'label' => lang('index_utility_label'),
                        'icon'  => 'list',
                        'sub'   =>
                        array(
                            'educations'       =>
                            array(
                                'label' => lang('view_education_label'),
                                'seen'  => TRUE,
                            ),
                            'create-education' =>
                            array(
                                'label' => lang('create_education_heading'),
                                'seen'  => TRUE,
                            ),
                            'courses'          =>
                            array(
                                'label' => lang('view_course_label'),
                                'seen'  => TRUE,
                            ),
                            'create-course'    =>
                            array(
                                'label' => lang('create_course_heading'),
                                'seen'  => TRUE,
                            ),
                            'rooms'            =>
                            array(
                                'label' => lang('view_room_label'),
                                'seen'  => TRUE,
                            ),
                            'create-room'      =>
                            array(
                                'label' => lang('create_room_heading'),
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //--------END UTILITIES----------
                    //sub menu
                    'administrator_menus' =>
                    array(
                        'label' => lang('administrators_label'),
                        'icon'  => 'group',
                        'sub'   =>
                        array(
                            'users'        =>
                            array(
                                'label' => lang('index_heading'),
                                'seen'  => TRUE,
                            ),
                            'create-user'  =>
                            array(
                                'label' => lang('create_user_heading'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                            'groups'       =>
                            array(
                                'label' => lang('index_groups_th'),
                                'seen'  => TRUE,
                            ),
                            'create-group' =>
                            array(
                                'label' => lang('create_group_heading'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                            /**
                             * hidden
                             */
                            'edit-group'   =>
                            array(
                                'label' => lang('edit_group_title'),
                                'seen'  => FALSE,
                                'admin' => TRUE
                            ),
                            'deactivate'   =>
                            array(
                                'label' => lang('deactivate_heading'),
                                'seen'  => FALSE,
                                'admin' => TRUE
                            ),
                            'edit-user'    =>
                            array(
                                'label' => lang('edit_user_heading'),
                                'seen'  => FALSE,
                                'admin' => TRUE
                            ),
                        ),
                    ),
                    //sub menu
                    'setting_menu'        =>
                    array(
                        'label' => 'Settings',
                        'icon'  => 'cogs',
                        'sub'   =>
                        array(
                            'database'    =>
                            array(
                                'label' => lang('database_label'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                            'log'         =>
                            array(
                                'label' => lang('error_label'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                            'permissions' =>
                            array(
                                'label' => lang('permission_label'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                            'last-logins' =>
                            array(
                                'label' => lang('last_login_label'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                        ),
                    ),
                );
        }

}


//if (!function_exists('navigations_setting'))
//{
//
//        /**
//         * 
//         * @return type
//         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
//         */
//        function navigations_setting()
//        {
//                return array(
//                    'database' =>
//                    array(
//                        'label' => 'Database',
//                        'desc'  => 'Database Description',
//                        'icon'  => 'file',
//                    ),
//                    'log'      =>
//                    array(
//                        'label' => 'Error Logs',
//                        'desc'  => 'Error Logsn Description',
//                        'icon'  => 'exclamation-sign',
//                    ),
//                );
//        }
//
//}
if (!function_exists('controllers__'))
{

        /**
         * all controllers from navigations_main() [helper], NOT FROM DATABSE
         * 
         * @param string $delimeter if delimeter set,
         *  it will return STRING with delimeter you set, else ARRAY of all controllers
         * 
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        function controllers__($delimeter = '')
        {
                $return_arr = array();
                $return_str = '';
                foreach (navigations_main() as $k => $v)
                {
                        if (isset($v['sub']))
                        {
                                foreach ($v['sub'] as $kk => $vv)
                                {

                                        $return_arr[$kk] = $vv;
                                        $return_str .= $kk . $delimeter;
                                }
                        }
                        else
                        {
                                $return_arr[$k] = $v;
                                $return_str .= $k . $delimeter;
                        }
                }
                if ($delimeter == '')
                {
                        return $return_arr;
                }
                elseif ($delimeter != '')
                {
                        return $return_str;
                }
        }

}

if (!function_exists('sidebar_menu_ci_capstone'))
{

        /**
         * 
         * @param type $menu_current
         * @param type $main_sub
         * @return string generated navigation
         */
        function sidebar_menu_ci_capstone($menu_current, $main_sub)
        {
                /**
                 * navigations
                 */
                $return = comment_tag('navigations') . '<ul>' . PHP_EOL;
                foreach (navigations_main() as $key => $item)
                {

                        if (isset($item['sub']))
                        {
                                /**
                                 * check permission
                                 * default
                                 */
                                $permmission = FALSE;

                                /**
                                 * check permission
                                 * if only one is there, so set the TRUE, else, nothing to show. means FALSE
                                 */
                                foreach ($item['sub'] as $k => $sub)
                                {
                                        $permmission = in_array($k, permission_controllers());
                                        if ($permmission)
                                        {
                                                //now we can stop here, because it has atleast one permission
                                                break;
                                        }
                                }

                                /**
                                 * check permission
                                 */
                                if ($permmission)
                                {
                                        //sub menu
                                        $active1 = ($key == $main_sub ? ' active' : '');

                                        $count = 0;
                                        foreach ($item['sub'] as $k_ => $value)
                                        {
                                                if ($value['seen'])
                                                {
                                                        /**
                                                         * check permission
                                                         */
                                                        if (in_array($k_, permission_controllers()))
                                                        {
                                                                $count++;
                                                        }
                                                }
                                        }

                                        $return .= '<li class="submenu' . $active1 . '">' . PHP_EOL
                                                . '<a href="#"><i class="icon icon-' . $item['icon'] . '"></i>' . PHP_EOL
                                                . '<span>' . $item['label'] . '</span> <span class="label label-important">' . $count . '</span>' . PHP_EOL
                                                . '</a>' . PHP_EOL
                                                . '<ul>' . PHP_EOL;
                                        foreach ($item['sub'] as $sub_key => $sub_item)
                                        {
                                                /**
                                                 * check permission
                                                 */
                                                if (in_array($sub_key, permission_controllers()))
                                                {
                                                        if ($sub_item['seen'])
                                                        {
                                                                $return .= '<li><a href="' . site_url(HOME_REDIRECT . $sub_key) . '">' . $sub_item['label'] . '</a></li>' . PHP_EOL;
                                                        }
                                                }
                                        }
                                        $return .= '</ul>' . PHP_EOL
                                                . '</li>' . PHP_EOL;
                                }
                        }
                        else
                        {
                                /**
                                 * check permission
                                 */
                                if (in_array($key, permission_controllers()))
                                {

                                        $active = ($key == $menu_current ? ' class="active"' : '');

                                        $return .= '<li' . $active . '>'
                                                . '<a href="' . site_url(HOME_REDIRECT . $key) . '">' . PHP_EOL
                                                . '<i class="icon icon-' . $item['icon'] . '"></i>' . PHP_EOL
                                                . '<span>' . $item['label'] . '</span>' . PHP_EOL
                                                . '</a>' . PHP_EOL
                                                . '</li>' . PHP_EOL;
                                }
                        }
                }
                return $return .= '</ul>' . PHP_EOL . comment_tag('end-navigations');
        }

}
