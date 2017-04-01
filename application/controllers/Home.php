<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('User_model', 'Course_model', 'Enrollment_model'));
        }

        /**
         * Function to show index page with count for dashboard
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {


                $this->data['active_users_count'] = $this->User_model->where(array(
                            'active' => TRUE
                        ))->count_rows();

                $this->data['student_enrolled_count'] = $this->Enrollment_model->where(array(
                            'enrollment_status' => TRUE
                        ))->count_rows();

                /*
                 * get all course
                 */

                $courses_detale = array();
                $course_obj     = $this->Course_model->set_cache('course_get_all')->get_all();

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
                $this->data['courses_info'] = $courses_detale;

                if (in_array('students', permission_controllers()))
                {

                        $this->template['stud_course_count']  = MY_Controller::render('admin/_templates/home/student_course_count', $this->data, TRUE);
                
                }
                $this->template['active_user_count']  = MY_Controller::render('admin/_templates/home/user_count', $this->data, TRUE);
                $this->template['dashboard_ctrl_var'] = MY_Controller::render('admin/_templates/home/dashboard_ctrl', $this->data, TRUE);
                $this->template['bootstrap']          = $this->_bootstrap();
                $this->render('admin/home', $this->template);
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
                        'js/excanvas.min.js',
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/jquery.flot.min.js',
                        'js/jquery.flot.resize.min.js',
                        'js/jquery.peity.min.js',
                        'js/fullcalendar.min.js',
                        'js/matrix.js',
                        'js/matrix.dashboard.js',
                        'js/jquery.gritter.min.js',
                        'js/matrix.interface.js',
                        'js/matrix.chat.js',
                        'js/jquery.validate.js',
                        'js/matrix.form_validation.js',
                        'js/jquery.wizard.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/matrix.popover.js',
                        'js/jquery.dataTables.min.js',
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
