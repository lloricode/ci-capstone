<?php

/**
 * http://stackoverflow.com/a/32524245/3405221
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_access
{

        public function __construct()
        {
                
        }

        public function __get($property)
        {
                if ( ! property_exists(get_instance(), $property))
                {
                        show_error('property: ' . strong($property) . ' not exist.');
                }
                return get_instance()->$property;
        }

        public function validate()
        {
                if (in_array($this->router->class, array("auth")))
                {
                        return;
                }
                if ( ! $this->ion_auth->logged_in())
                {
                        redirect(site_url('auth/login'), 'refresh');
                }
                if ( ! in_array(str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller'))), permission_controllers()))
                {
                        show_404();
                }

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

}
