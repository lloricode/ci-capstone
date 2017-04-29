<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('navigations_main'))
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
                                'label'      => lang('create_curriculum_label'),
                                'seen'       => TRUE,
                                'enrollment' => TRUE
                            ),
                            /**
                             * hidden
                             */
                            'create-curriculum-subject' =>
                            array(
                                'label'      => lang('create_curriculum_subject_label'),
                                'seen'       => FALSE,
                                'enrollment' => TRUE
                            ),
                            'create-requisite'          =>
                            array(
                                'label'      => 'Create Requisite',
                                'seen'       => FALSE,
                                'enrollment' => TRUE
                            ),
                            'set-curriculum-enable'     =>
                            array(
                                'label'      => 'Set Curriculum Enable',
                                'seen'       => FALSE,
                                'enrollment' => TRUE
                            )
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
                            'students'               =>
                            array(
                                'label' => lang('view_student_label'),
                                'seen'  => TRUE,
                            ),
                            'create-student'         =>
                            array(
                                'label'      => lang('create_student_heading'),
                                'seen'       => TRUE,
                                'enrollment' => TRUE
                            ),
                            /**
                             * hidden
                             */
                            'edit-student'           =>
                            array(
                                'label' => lang('edit_student_submit_button_label'),
                                'seen'  => FALSE,
                            ),
                            'create-student-subject' =>
                            array(
                                'label'      => lang('add_student_subject_label'),
                                'seen'       => FALSE,
                                'enrollment' => TRUE
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
                                'label'      => lang('create_subject_heading'),
                                'seen'       => TRUE,
                                'enrollment' => TRUE
                            ),
                            'subject-offers'       =>
                            array(
                                'label' => lang('view_class_schedule_label'),
                                'seen'  => TRUE,
                            ),
                            'create-subject-offer' =>
                            array(
                                'label'      => lang('create_subject_offer_heading'),
                                'seen'       => TRUE,
                                'enrollment' => TRUE
                            ),
                            /**
                             * hidden
                             */
                            'edit-subject'         =>
                            array(
                                'label' => lang('edit_subject_label'),
                                'seen'  => FALSE,
                            )
                        )
                    ),
                    //--------END SCHEDULE--------
                    //--------START UTILITIES--------
                    'utilities_menu'      =>
                    array(
                        'label' => lang('index_utility_label'),
                        'icon'  => 'list',
                        'sub'   =>
                        array(
                            'open-enrollment'  =>
                            array(
                                'label' => lang('enrollment_status_label'),
                                'seen'  => TRUE,
                                'admin' => TRUE
                            ),
                            'educations'       =>
                            array(
                                'label' => lang('view_education_label'),
                                'seen'  => FALSE
                            ),
                            'create-education' =>
                            array(
                                'label'      => lang('create_education_heading'),
                                'seen'       => FALSE,
                                'enrollment' => TRUE
                            ),
                            'courses'          =>
                            array(
                                'label' => lang('view_course_label'),
                                'seen'  => TRUE,
                            ),
                            'create-course'    =>
                            array(
                                'label'      => lang('create_course_heading'),
                                'seen'       => TRUE,
                                'enrollment' => TRUE
                            ),
                            'rooms'            =>
                            array(
                                'label' => lang('view_room_label'),
                                'seen'  => TRUE,
                            ),
                            'create-room'      =>
                            array(
                                'label'      => lang('create_room_heading'),
                                'seen'       => TRUE,
                                'enrollment' => TRUE
                            ),
                            /**
                             * hidden
                             */
                            'edit-room'        =>
                            array(
                                'label'      => lang('create_room_heading'),
                                'seen'       => FALSE,
                                'enrollment' => TRUE
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
                                'admin' => TRUE
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
                            'report-info' =>
                            array(
                                'label' => lang('report_info_label'),
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

// ------------------------------------------------------------------------

if ( ! function_exists('controllers__'))
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
                                        $return_str      .= $kk . $delimeter;
                                }
                        }
                        else
                        {
                                $return_arr[$k] = $v;
                                $return_str     .= $k . $delimeter;
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

// ------------------------------------------------------------------------

if ( ! function_exists('sidebar_menu_ci_capstone'))
{

        /**
         * 
         * @param type $menu_current
         * @param type $main_sub
         * @return string generated navigation
         */
        function sidebar_menu_ci_capstone($menu_current, $main_sub)
        {
                $enrollment_open_status = get_instance()->Enrollment_status_model->status();
                $permission_controllers = permission_controllers();

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
                                        $permmission = in_array($k, $permission_controllers);
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

                                        $count                               = 0;
                                        $skip_controller_for_enrollment_open = array();
                                        foreach ($item['sub'] as $k_ => $value)
                                        {
                                                if ($value['seen'])
                                                {
                                                        /**
                                                         * check for enrollment-open 
                                                         */
                                                        $not_belong_to_enrollment_open = FALSE;
                                                        if (isset($value['enrollment']))
                                                        {
                                                                if ($value['enrollment'])
                                                                {
                                                                        $not_belong_to_enrollment_open = ! $enrollment_open_status;
                                                                        if ( ! $enrollment_open_status)
                                                                        {
                                                                                $skip_controller_for_enrollment_open[] = $k_;
                                                                        }
                                                                }
                                                        }
                                                        /**
                                                         * check permission
                                                         */
                                                        $permmission_resutl = in_array($k_, $permission_controllers);
                                                        if ($permmission_resutl)
                                                        {
                                                                if ( ! $not_belong_to_enrollment_open)
                                                                {
                                                                        $count ++;
                                                                }
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
                                                if (in_array($sub_key, $skip_controller_for_enrollment_open))
                                                {
                                                        continue;
                                                }
                                                /**
                                                 * check permission
                                                 */
                                                if (in_array($sub_key, $permission_controllers))
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
                                $permmission_resutl = in_array($key, $permission_controllers);
                                if ($permmission_resutl)
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
                /**
                 * enrollment status
                 */
                $status__     = ($enrollment_open_status) ? 'Enabled' : 'Disabled';
                $status__     = ' <li class="content">Enrollment Status: <span class="date badge badge-' . (($enrollment_open_status) ? 'success' : 'important') . '">' . $status__ . '</span></li>';
                /**
                 * current semester && school_year
                 */
                $current_term = '<li class="content">' . current_school_year() . ', ' . current_school_semester() . '</li>';
                return $return . $status__ . $current_term . '</ul>' . PHP_EOL . comment_tag('end-navigations');
        }

}

// ------------------------------------------------------------------------

if ( ! function_exists('get_all_controller_with_enrollment'))
{

        /**
         * get all controller than affected when changing enrollment status
         * 
         * @return array
         */
        function get_all_controller_with_enrollment()
        {
                $return = array();

                foreach (navigations_main() as $key => $item)
                {
                        if (isset($item['sub']))
                        {
                                foreach ($item['sub'] as $k_ => $value)
                                {

                                        if (isset($value['enrollment']))
                                        {
                                                if ($value['enrollment'])
                                                {
                                                        $return[] = $k_;
                                                }
                                        }
                                }
                        }
                }
                return $return;
        }

}