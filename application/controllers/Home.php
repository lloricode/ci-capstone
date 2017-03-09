<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('User_model', 'Enrollment_model'));
        }

        /**
         * Function to show index page with count for dashboard
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {


                $this->data['active_users_count']     = $this->User_model->where(array(
                            'active' => TRUE
                        ))->count_rows();
                $this->data['student_enrolled_count'] = $this->Enrollment_model->where(array(
                            'enrollment_status' => TRUE
                        ))->count_rows();
                $this->data['stud_beed']              = $this->Enrollment_model->where(array(
                            'course_id' => 1
                        ))->count_rows();               //counts all students in beed for dashboard
                $this->data['stud_hrm']              = $this->Enrollment_model->where(array(
                            'course_id' => 2
                        ))->count_rows();               //counts all students in hrm for dashboard
                $this->data['stud_paramedical']              = $this->Enrollment_model->where(array(
                            'course_id' => 3
                        ))->count_rows();               //counts all students in paramedical for dashboard
                $this->data['stud_ict']              = $this->Enrollment_model->where(array(
                            'course_id' => 4
                        ))->count_rows();               //counts all students in ict for dashboard
                $this->data['stud_highschool']              = $this->Enrollment_model->where(array(
                            'course_id' => 5
                        ))->count_rows();               //counts all students in highschool for dashboard
                $this->data['stud_amt']              = $this->Enrollment_model->where(array(
                            'course_id' => 6
                        ))->count_rows();               //counts all students in amt for dashboard
                $this->data['stud_tesda']              = $this->Enrollment_model->where(array(
                            'course_id' => 7
                        ))->count_rows();               //counts all students in tesda for dashboard
                $this->data['stud_cme']              = $this->Enrollment_model->where(array(
                            'course_id' => 8
                        ))->count_rows();               //counts all students in cme for dashboard
                $this->data['stud_cross_enroll']              = $this->Enrollment_model->where(array(
                            'course_id' => 9
                        ))->count_rows();               //counts all students in cross enroll for dashboard
                $this->template['active_user_count']  = MY_Controller::_render('admin/_templates/home/user_count', $this->data, TRUE);
                $this->template['dashboard_ctrl_var'] = MY_Controller::_render('admin/_templates/home/dashboard_ctrl', $this->data, TRUE);
                $this->template['stud_course_count'] = MY_Controller::_render('admin/_templates/home/student_course_count', $this->data, TRUE);
                $this->template['bootstrap']          = $this->_bootstrap();
                $this->_render('admin/home', $this->template);
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
