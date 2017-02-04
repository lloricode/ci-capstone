<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_course extends Admin_Controller {

        function __construct() {
                parent::__construct();
                $this->lang->load('ci_courses');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters(
                        $this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth')
                );
        }

        public function index() {
                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('create_course_name_label'),
                        'field' => 'course_name',
                        'rules' => 'trim|required|human_name|min_length[3]|max_length[50]',
                    ),
                    array(
                        'label' => lang('create_course_description_label'),
                        'field' => 'course_description',
                        'rules' => 'trim|required|human_name|min_length[3]|max_length[50]',
                    )
                ));

                if ($this->form_validation->run()) {
                        $course = array(
                            'course_name'        => $this->input->post('course_name', TRUE),
                            'course_description' => $this->input->post('course_description', TRUE),
                        );
                        $this->load->model('Course_model');
                        if ($this->Course_model->insert($course)) {
                                $this->session->set_flashdata('message', $this->config->item('message_start_delimiter', 'ion_auth') . lang('create_course_succesfully_added_message') . $this->config->item('message_end_delimiter', 'ion_auth'));
                                redirect(current_url(), 'refresh');
                        }
                }

                $this->data['message']            = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['course_name']        = array(
                    'name'  => 'course_name',
                    'id'    => 'course_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('course_name'),
                );
                $this->data['course_description'] = array(
                    'name'  => 'course_description',
                    'id'    => 'course_description',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('course_description'),
                );
                $this->_render_admin_page('admin/create_course', $this->data);
        }

}
