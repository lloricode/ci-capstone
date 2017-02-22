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
                    'home'               =>
                    array(
                        'label' => 'Home',
                        'desc'  => 'Home Description',
                        'icon'  => 'home',
                    ),
                    //sub menu
                    'user_menus'         =>
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
                    //---------STUDENT------------
                    'student_menu'       =>
                    array(
                        'label' => 'Students',
                        'icon'  => 'user-md',
                        'sub'   =>
                        array(
                            'students'       =>
                            array(
                                'label' => 'Student',
                                'desc'  => 'Student Description',
                                'seen'  => TRUE,
                            ),
                            'create-student' =>
                            array(
                                'label' => 'Add Student',
                                'desc'  => 'Add Student Description',
                                'seen'  => TRUE,
                            ),
                            'edit-student'   =>
                            array(
                                'label' => 'Edit Student',
                                'desc'  => 'Edit Student Description',
                                'seen'  => FALSE,
                            ),
                        ),
                    ),
                    //---------END STUDENT--------
                    //sub menu
                    //---------START SUBJECTS-----
                    'subjects_menu'      =>
                    array(
                        'label' => 'Subjects',
                        'icon'  => 'book',
                        'sub'   =>
                        array(
                            'subjects'       =>
                            array(
                                'label' => 'Subject',
                                'desc'  => 'Subject Description',
                                'seen'  => TRUE,
                            ),
                            'create-subject' =>
                            array(
                                'label' => 'Add Subject',
                                'desc'  => 'Add Subject Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //---------END SUBJECTS-------
                    //sub menu
                    //--------START COURSE--------
                    'course_menu'        =>
                    array(
                        'label' => 'Courses',
                        'icon'  => 'list',
                        'sub'   =>
                        array(
                            'courses'       =>
                            array(
                                'label' => 'Course',
                                'desc'  => 'Course Description',
                                'seen'  => TRUE,
                            ),
                            'create-course' =>
                            array(
                                'label' => 'Create Course',
                                'desc'  => 'Create Course Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //--------END COURSE----------
                    //
                    //--------START EDUCATION--------
                    'education_menu'     =>
                    array(
                        'label' => 'Educations',
                        'icon'  => 'pencil',
                        'sub'   =>
                        array(
                            'educations'       =>
                            array(
                                'label' => 'Education',
                                'desc'  => 'Education Description',
                                'seen'  => TRUE,
                            ),
                            'create-education' =>
                            array(
                                'label' => 'Create Education',
                                'desc'  => 'Create Education Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //--------END EDUCATION----------
                    //
                    //
                    //--------START ROOM--------
                    'room_menu'          =>
                    array(
                        'label' => 'Rooms',
                        'icon'  => 'lock',
                        'sub'   =>
                        array(
                            'rooms'       =>
                            array(
                                'label' => 'Room',
                                'desc'  => 'Room Description',
                                'seen'  => TRUE,
                            ),
                            'create-room' =>
                            array(
                                'label' => 'Create Room',
                                'desc'  => 'Create Room Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //--------END ROOM----------
                    //sub menu
                    //--------START SCHEDULE------
                    'subject_offer_menu' =>
                    array(
                        'label' => 'Subject Offers',
                        'icon'  => 'calendar',
                        'sub'   =>
                        array(
                            'subject-offers'       =>
                            array(
                                'label' => 'Subject Offer',
                                'desc'  => 'Subject Offer Description',
                                'seen'  => TRUE,
                            ),
                            'create-subject-offer' =>
                            array(
                                'label' => 'Create Subject Offer',
                                'desc'  => 'Create Subject Offer Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //--------END SCHEDULE--------
                    //sub menu
                    'group_menu'         =>
                    array(
                        'label' => lang('index_groups_th'),
                        'icon'  => 'group',
                        'sub'   =>
                        array(
                            'groups'       =>
                            array(
                                'label' => lang('index_groups_th'),
                                'desc'  => lang('index_groups_th') . ' Description',
                                'seen'  => TRUE,
                            ),
                            'create-group' =>
                            array(
                                'label' => lang('create_group_heading'),
                                'desc'  => lang('create_group_heading') . ' Description',
                                'seen'  => TRUE,
                            ),
                        ),
                    ),
                    //sub menu
                    'setting_menu'       =>
                    array(
                        'label' => 'Settings',
                        'icon'  => 'cogs',
                        'sub'   =>
                        array(
                            'language'    =>
                            array(
                                'label' => lang('lang_label'),
                                'desc'  => 'Language Description',
                                'seen'  => TRUE,
                            ),
                            'database'    =>
                            array(
                                'label' => 'Database',
                                'desc'  => 'Database Description',
                                'seen'  => TRUE,
                            ),
                            'log'         =>
                            array(
                                'label' => 'Error Logs',
                                'desc'  => 'Error Logsn Description',
                                'seen'  => TRUE,
                            ),
                            'permissions' =>
                            array(
                                'label' => 'Permissions',
                                'desc'  => 'permission Description',
                                'seen'  => TRUE,
                            ),
                            'last-logins' =>
                            array(
                                'label' => 'Last Logins',
                                'desc'  => 'Last Logins Description',
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

                                        $return_arr[] = $kk;
                                        $return_str   .= $kk . $delimeter;
                                }
                        }
                        else
                        {
                                $return_arr[] = $k;
                                $return_str   .= $k . $delimeter;
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
                $return = '<ul>' . "\n";
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

                                        $return .= '<li class="submenu' . $active1 . '">' . "\n"
                                                . '<a href="#"><i class="icon icon-' . $item['icon'] . '"></i>' . "\n"
                                                . '<span>' . $item['label'] . '</span> <span class="label label-important">' . $count . '</span>' . "\n"
                                                . '</a>' . "\n"
                                                . '<ul>' . "\n";
                                        foreach ($item['sub'] as $sub_key => $sub_item)
                                        {
                                                /**
                                                 * check permission
                                                 */
                                                if (in_array($sub_key, permission_controllers()))
                                                {
                                                        if ($sub_item['seen'])
                                                        {
                                                                $return .= '<li><a href="' . base_url(HOME_REDIRECT . $sub_key) . '">' . $sub_item['label'] . '</a></li>' . "\n";
                                                        }
                                                }
                                        }
                                        $return .= '</ul>' . "\n"
                                                . '</li>' . "\n";
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
                                                . '<a href="' . base_url(HOME_REDIRECT . $key) . '">' . "\n"
                                                . '<i class="icon icon-' . $item['icon'] . '"></i>' . "\n"
                                                . '<span>' . $item['label'] . '</span>' . "\n"
                                                . '</a>' . "\n"
                                                . '</li>' . "\n";
                                }
                        }
                }
                return $return .= '</ul>' . "\n";
        }

}
