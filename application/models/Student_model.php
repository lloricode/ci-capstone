<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'students';
                $this->primary_key = 'student_id';


                $this->_relations();
                $this->_form();

                $this->timestamps                = TRUE;
                $this->return_as                 = 'object';
                $this->timestamps_format         = 'timestamp';
                $this->remove_empty_before_write = TRUE;
                parent::__construct();
        }

        private function _relations()
        {
                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
        }

        private function _form()
        {
                $this->lang->load('ci_capstone/ci_educations');

                $this->rules = array(
                    'insert' => $this->_insert(),
                    'update' => $this->_update()
                );
        }

        private function _insert()
        {
                return array(
                    'student_firstname'               => array(
                        'label' => lang('index_student_firstname_th'),
                        'field' => 'firstname',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    'student_middlename'              => array(
                        'label' => lang('index_student_middlename_th'),
                        'field' => 'middlename',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    'student_lastname'                => array(
                        'label' => lang('index_student_lastname_th'),
                        'field' => 'lastname',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    'student_gender'                  => array(
                        'label' => lang('index_student_gender_th'),
                        'field' => 'gender',
                        'rules' => 'trim|required|min_length[4]|max_length[6]',
                    ),
                    'student_birthdate'               => array(
                        'label' => lang('index_student_birthdate_th'),
                        'field' => 'birthdate',
                        'rules' => 'trim|required',
                    ),
                    'student_permanent_address'       => array(
                        'label' => lang('index_student_permanent_address_th'),
                        'field' => 'address',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    'student_birthplace'              => array(
                        'label' => lang('index_student_birthplace_th'),
                        'field' => 'birthplace',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    'student_civil_status'            => array(
                        'label' => lang('index_student_civil_status_th'),
                        'field' => 'status',
                        'rules' => 'trim|required|min_length[3]|max_length[15]',
                    ),
                    'student_nationality'             => array(
                        'label' => lang('index_student_nationality_th'),
                        'field' => 'nationality',
                        'rules' => 'trim|required|min_length[4]|max_length[20]',
                    ),
                    //--
                    'student_guardian_fullname'       => array(
                        'label' => lang('index_student_guardian_fullname_th'),
                        'field' => 'guardian_fullname',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    'student_address_town'            => array(
                        'label' => lang('index_student_town_th'),
                        'field' => 'town',
                        'rules' => 'trim|min_length[3]|max_length[30]',
                    ),
                    'student_address_region'          => array(
                        'label' => lang('index_student_region_th'),
                        'field' => 'region',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    'student_guardian_address'        => array(
                        'label' => lang('index_student_guardian_address_th'),
                        'field' => 'guardian_address',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    'student_personal_contact_number' => array(
                        'label' => lang('index_student_personal_contact_th'),
                        'field' => 'ontact_number',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    'student_guardian_contact_number' => array(
                        'label' => lang('index_student_guardian_contact_th'),
                        'field' => 'guardian_contact_number',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    //-----email
                    'student_personal_email'          => array(
                        'label'  => lang('index_student_personal_email_th'),
                        'field'  => 'personal_email',
                        'rules'  => 'trim|max_length[50]|valid_email' .
                        (('' != $this->input->post('personal_email', TRUE)) ?
                        '|is_unique[students.student_personal_email]' : ''),
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                    'student_guardian_email'          => array(
                        'label'  => lang('index_student_guardian_email_th'),
                        'field'  => 'guardian_email',
                        'rules'  => 'trim|max_length[50]|valid_email' .
                        (('' != $this->input->post('guardian_email', TRUE)) ?
                        '|is_unique[students.student_guardian_email]' : ''),
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                );
        }

        private function _update()
        {
                return array(
                );
        }

}
