<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('User_model', 'Course_model', 'Enrollment_model'));
        }

        private function _count_enrolled()
        {
                $obj = $this->Enrollment_model->where(array(
                    'enrollment_status' => TRUE
                ));

                if ($this->session->userdata('user_is_dean'))
                {
                        if ($id = $this->session->userdata('user_dean_course_id'))
                        {
                                $obj->where(array(
                                    'course_id' => $id
                                ));
                        }
                }

                return $obj->count_rows();
        }

        /**
         * Function to show index page with count for dashboard
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {
                $data[''] = NULL; //just incase all not controllers not has permission in current user_group

                if (in_array('users', permission_controllers()))
                {
                        $data['active_users_count'] = $this->User_model->where(array(
                                    'active' => TRUE
                                ))->count_rows();
                }
                if (in_array('students', permission_controllers()))
                {
                        $data['student_enrolled_count'] = $this->_count_enrolled();

                        $courses_detale = array();
                        if ($this->session->userdata('user_is_dean'))
                        {
                                if ($id = $this->session->userdata('user_dean_course_id'))
                                {
                                        $course_row        = $this->Course_model->set_cache('Course_model_get_' . $id)->get($id);
                                        $ecount            = $enrollment_object = $this->Enrollment_model->where(array(
                                                    'course_id'         => $id,
                                                    'enrollment_status' => TRUE
                                                ))->count_rows();

                                        $courses_detale[] = array(
                                            'course_id' => $course_row->course_id,
                                            'counts'    => $ecount,
                                            'icon'      => $course_row->course_icon,
                                            'color'     => $course_row->course_color,
                                            'code'      => $course_row->course_code
                                        );
                                }
                        }
                        else
                        {
                                /*
                                 * get all course
                                 */

                                $course_obj = $this->Course_model->order_by('course_code')->set_cache('course_get_all_orderby_course_code')->get_all();

                                if ($course_obj)
                                {
                                        foreach ($course_obj as $course_row)
                                        {
                                                $ecount            = $enrollment_object = $this->Enrollment_model->where(array(
                                                            'course_id'         => $course_row->course_id,
                                                            'enrollment_status' => TRUE
                                                        ))->count_rows();

                                                //array push
                                                $courses_detale[] = array(
                                                    'course_id' => $course_row->course_id,
                                                    'counts'    => $ecount,
                                                    'icon'      => $course_row->course_icon,
                                                    'color'     => $course_row->course_color,
                                                    'code'      => $course_row->course_code
                                                );
                                        }
                                }
                        }
                        $data['courses_info']          = $courses_detale;
                        $template['stud_course_count'] = MY_Controller::render('admin/_templates/home/student_course_count', $data, TRUE);
                }
                $template['active_user_count']  = MY_Controller::render('admin/_templates/home/user_count', $data, TRUE);
                $template['dashboard_ctrl_var'] = MY_Controller::render('admin/_templates/home/dashboard_ctrl', $data, TRUE);
                $template['bootstrap']          = $this->_bootstrap();
                $this->render('admin/home', $template);
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap()
        {
                /**
                 * for header
                 * 
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/fullcalendar.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'css/jquery.gritter.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/jquery.dataTables.min.js',
                        'js/matrix.js',
                        'js/matrix.tables.js',
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '<script type="text/javascript">
            // This function is called from the pop-up menus to transfer to
            // a different page. Ignore if the value returned is a null string:
            function goPage(newURL) {

                // if url is empty, skip the menu dividers and reset the menu selection to default
                if (newURL != "") {

                    // if url is "-", it is this page -- reset the menu:
                    if (newURL == "-") {
                        resetMenu();
                    }
                    // else, send page to designated URL            
                    else {
                        document.location.href = newURL;
                    }
                }
            }

            // resets the menu selection upon entry to this page:
            function resetMenu() {
                document.gomenu.selector.selectedIndex = 2;
            }
        </script>';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
