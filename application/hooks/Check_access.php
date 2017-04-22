<?php

/**
 * idea thats where to validate session login
 * http://stackoverflow.com/a/32524245/3405221
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_access
{

        function __construct()
        {
                
        }

        public function __get($property)
        {
                if ( ! property_exists(get_instance(), $property))
                {
                        show_error('property: ' . bold($property) . ' not exist.');
                }
                return get_instance()->$property;
        }

        public function validate()
        {
                /**
                 * ignore login/authentication controller
                 */
                if (in_array($this->router->class, array("auth")))
                {
                        return;
                }
                if ( ! $this->ion_auth->logged_in())
                {
                        redirect(site_url('auth/login'), 'refresh');
                }

             //   $this->_check_if_multiple_logged_in_one_user();

                /**
                 * check controllers available of users, depend on user_groups
                 */
                if ( ! in_array(str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller'))), permission_controllers()))
                {
                        show_404();
                }

                /**
                 * update enrollment status to FALSE in ALL not current semester and school_year
                 */
                $this->Enrollment_model->unenroll_all_past_term();
                /**
                 * when enrollment status is disabled, then check controller that will also disabled
                 */
                if ( ! $this->Enrollment_status_model->status())
                {
                        if (in_array($this->uri->segment($this->config->item('segment_controller')), get_all_controller_with_enrollment()))
                        {
                                show_404();
                        }
                }

                $this->breadcrumbs->unshift(1, lang('home_label'), 'home');


                /**
                 * this is for /create-student-subject controller
                 * use this if navigate to another controller, it will unset session for subject offer
                 * to prevent passing session to another enrolling subjects in another students
                 */
                if ('create-student-subject' != str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller'))) &&
                        $this->session->has_userdata($this->config->item('create_student_subject__session_name')))
                {
                        /**
                         * /create-student-subject controller
                         * 
                         *   $this->_session_name_  
                         */
                        $this->session->unset_userdata($this->config->item('create_student_subject__session_name'));
                }
        }

        /**
         * 
         * checking if one account log in another machine
         * ,this is set hook in constructor in MY_Controller
         * 
         * 
         * 
         * 
         * this idea is came from https://github.com/benedmunds/CodeIgniter-Ion-Auth/issues/947
         * 
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _check_if_multiple_logged_in_one_user()
        {
                $CI                      = &get_instance();
                $user_current_session_id = $CI->session->userdata('gen_code');
                $session_id              = $CI->User_model->get($CI->ion_auth->get_user_id())->gen_code;

                if ($session_id != $user_current_session_id)
                {
                        $message = 'another_logged_in_user_in_this_account';

                        redirect('auth/logout/' . $message, 'refresh');
                }
        }

}
