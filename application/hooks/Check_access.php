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
                $this->ion_auth->set_hook(
                        'post_set_session', '_set_session_data_event', $this, '_set_session_data', array()
                );

//                $this->ion_auth->set_hook(
//                        'logged_in', '_check_if_multiple_logged_in_one_user_event', $this, '_check_if_multiple_logged_in_one_user', array()
//                );

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

                $current_controller = str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller')));
                //   $this->_check_if_multiple_logged_in_one_user();

                /**
                 * check controllers available of users, depend on user_groups
                 */
                if ( ! in_array($current_controller, permission_controllers()))
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
                        if (in_array($current_controller, get_all_controller_with_enrollment()))
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
                if ('create-student-subject' != $current_controller &&
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

        private function _current_group_string($type = 'description')
        {
                $return = '';
                foreach (get_instance()->ion_auth->get_users_groups()->result() as $g)
                {
                        $return .= $g->$type . '|';
                }
                return trim($return, '|');
        }

        public function _set_session_data()
        {
                // show_error('aaaa');
                $is_dean          = FALSE;
                $dean_course_id   = NULL;
                $dean_course_code = NULL;
                if ($this->ion_auth->in_group($this->config->item('user_group_dean')))
                {
                        $is_dean = TRUE;
                        $this->load->model('Dean_course_model');
                        $obj     = $this->Dean_course_model->where(array(
                                    'user_id' => $this->ion_auth->get_user_id()
                                ))->get();
                        if ($obj)
                        {
                                $this->load->model('Course_model');
                                $dean_course_id   = $obj->course_id;
                                $dean_course_code = $this->Course_model->get($obj->course_id)->course_code;
                        }
                }
                //set the user name/last name in session
                $user_obj = $this->ion_auth->user()->row();
                $this->session->set_userdata(array(
                    'user_first_name'          => $user_obj->first_name,
                    'user_last_name'           => $user_obj->last_name,
                    'user_fullname'            => $user_obj->last_name . ', ' . $user_obj->first_name,
                    'gen_code'                 => $user_obj->gen_code, //this will be use for checking multiple logged machines in one account
                    'user_groups_descriptions' => $this->_current_group_string(),
                    'user_groups_names'        => $this->_current_group_string('name'),
                    'user_is_dean'             => $is_dean,
                    'user_dean_course_id'      => $dean_course_id,
                    'user_dean_course_code'    => $dean_course_code,
                ));
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
//        public function _check_if_multiple_logged_in_one_user()
//        {
//                $user_current_session_id = $this->session->userdata('gen_code');
//                $session_id              = $this->User_model->get($this->ion_auth->get_user_id())->gen_code;
//
//                if ($session_id != $user_current_session_id)
//                {
//                        $message = 'another_logged_in_user_in_this_account';
//                        redirect('auth/logout/' . $message, 'refresh');
//                }
//        }
}
