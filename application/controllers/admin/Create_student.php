<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_student extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_students');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters(
                        $this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth')
                );
        }

        public function index()
        {
                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('create_student_firstname_label'),
                        'field' => 'student_firstname',
                        'rules' => 'trim|required|human_name|min_length[3]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_student_middlename_label'),
                        'field' => 'student_middlename',
                        'rules' => 'trim|required|human_name|min_length[3]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_student_lastname_label'),
                        'field' => 'student_lastname',
                        'rules' => 'trim|required|human_name|min_length[2]|max_length[30]',
                    ),
                    array(
                        'label' => lang('create_student_school_id_label'),
                        'field' => 'student_school_id',
                        'rules' => 'trim|required|exact_length[9]|is_unique[students.student_school_id]|school_id',
                    ),
                    array(
                        'label' => lang('create_student_gender_label'),
                        'field' => 'student_gender',
                        'rules' => 'trim|required|min_length[4]|max_length[6]',
                    ),
                    array(
                        'label' => lang('create_student_permanent_address_label'),
                        'field' => 'student_permanent_address',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    array(
                        'label' => lang('create_course_id_label'),
                        'field' => 'course_id',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    array(
                        'label' => lang('create_student_year_level_label'),
                        'field' => 'student_year_level',
                        'rules' => 'trim|required|is_natural_no_zero',
                    )
                ));

                if ($this->form_validation->run())
                {
                        $student = array(
                            'student_firstname'         => $this->input->post('student_firstname', TRUE),
                            'student_middlename'        => $this->input->post('student_middlename', TRUE),
                            'student_lastname'          => $this->input->post('student_lastname', TRUE),
                            'student_school_id'         => $this->input->post('student_school_id', TRUE),
                            'student_gender'            => $this->input->post('student_gender', TRUE),
                            'student_permanent_address' => $this->input->post('student_permanent_address', TRUE),
                            'course_id'                 => $this->input->post('course_id', TRUE),
                            'student_year_level'        => $this->input->post('student_year_level', TRUE),
                        );
                        $this->load->model('Student_model');
                        if ($this->Student_model->insert($student))
                        {
                                $this->session->set_flashdata('message', $this->config->item('message_start_delimiter', 'ion_auth') . lang('create_student_succesfully_added_message') . $this->config->item('message_end_delimiter', 'ion_auth'));
                                redirect(current_url(), 'refresh');
                        }
                }

                /**
                 * if reach here, load the model, etc...
                 */
                $this->load->model('Course_model');
                $this->load->helper('combobox');
                $this->load->library('school_id');
                $this->config->load('common/config', TRUE);


                $this->data['message']            = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->data['student_firstname']  = array(
                    'name'  => 'student_firstname',
                    'id'    => 'student_firstname',
                    'value' => $this->form_validation->set_value('student_firstname'),
                );
                $this->data['student_middlename'] = array(
                    'name'  => 'student_middlename',
                    'id'    => 'student_middlename',
                    'value' => $this->form_validation->set_value('student_middlename'),
                );

                $this->data['student_lastname'] = array(
                    'name'  => 'student_lastname',
                    'id'    => 'student_lastname',
                    'value' => $this->form_validation->set_value('student_lastname'),
                );

                $this->data['student_school_id'] = array(
                    'name'     => 'student_school_id',
                    'id'       => 'student_school_id',
                    'disabled' => '',
                    'value'    => $this->school_id->generate(),
                );

                $this->data['student_gender'] = array(
                    'name'  => 'student_gender',
                    'id'    => 'student_gender',
                    'value' => $this->form_validation->set_value('student_gender'),
                );

                $this->data['student_permanent_address'] = array(
                    'name'  => 'student_permanent_address',
                    'id'    => 'student_permanent_address',
                    'value' => $this->form_validation->set_value('student_permanent_address'),
                );

                $this->data['course_id']       = array(
                    'name'  => 'course_id',
                    'value' => $this->form_validation->set_value('course_id'),
                );
                $this->data['course_id_value'] = $this->Course_model->as_dropdown('course_name')->get_all();

                $this->data['student_year_level']       = array(
                    'name'  => 'student_year_level',
                    'value' => $this->form_validation->set_value('student_year_level'),
                );
                $this->data['student_year_level_value'] = _numbers_for_drop_down(0, $this->config->item('max_year_level', 'common/config'));



                $this->_render_admin_page('admin/create_student', $this->data);
        }

}
