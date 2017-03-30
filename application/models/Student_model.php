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
                $this->_config();

                parent::__construct();
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver              = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix              = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                $this->remove_empty_before_write = TRUE; //(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save      = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
                $this->has_one['enrollment']         = array(
                    'foreign_model' => 'Enrollment_model',
                    'foreign_table' => 'enrollments',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => array_merge($this->_common(), $this->_insert()),
                    'update' => array_merge($this->_common(), $this->_update())
                );
        }

        private function _common()
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
                        'label'  => lang('index_student_gender_th'),
                        'field'  => 'gender',
                        'rules'  => 'trim|required|min_length[4]|in_list[male,female]',
                        'errors' => array(
                            'in_list' => 'Invalid value in {field}'
                        )
                    ),
                    'student_birthdate'               => array(
                        'label' => lang('index_student_birthdate_th'),
                        'field' => 'birthdate',
                        'rules' => 'trim|required|regex_match[/^\d{2}[-]\d{2}[-]\d{4}$/]|_age_limit[5.90]',
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
                );
        }

        private function _insert()
        {
                return array(
                    //-----email
                    'student_personal_email' => array(
                        'label'  => lang('index_student_personal_email_th'),
                        'field'  => 'personal_email',
                        'rules'  => 'trim|max_length[50]|valid_email' .
                        (( $this->input->post('personal_email', TRUE)) ?
                        '|is_unique[' . $this->table . '.student_personal_email]' : ''),
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                    'student_guardian_email' => array(
                        'label'  => lang('index_student_guardian_email_th'),
                        'field'  => 'guardian_email',
                        'rules'  => 'trim|max_length[50]|valid_email' .
                        (( $this->input->post('guardian_email', TRUE)) ?
                        '|is_unique[' . $this->table . '.student_guardian_email]' : ''),
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                );
        }

        private function _update()
        {
                return array(
                    'student_personal_email' => array(
                        'label' => lang('index_student_personal_email_th'),
                        'field' => 'personal_email',
                        'rules' => 'trim|max_length[50]|valid_email|callback_email_personal'
                    ),
                    'student_guardian_email' => array(
                        'label' => lang('index_student_guardian_email_th'),
                        'field' => 'guardian_email',
                        'rules' => 'trim|max_length[50]|valid_email|callback_email_guardian'
                    ),
                        /**
                         * needs improvement  -- Lloric 2/25/17 1:55am (mardags home)
                         */
//                    'student_personal_email' => array(
//                        'label' => lang('index_student_personal_email_th'),
//                        'field' => 'personal_email',
//                        'rules' => 'trim|max_length[50]|valid_email' .
//                        (($this->student->email != $this->input->post('personal_email', TRUE)) ?
//                        '|is_unique[students.student_personal_email]' : ''),
//                    ),
//                    'student_guardian_email' => array(
//                        'label' => lang('index_student_guardian_email_th'),
//                        'field' => 'guardian_email',
//                        'rules' => 'trim|max_length[50]|valid_email' .
//                        (($this->student->guardian_email != $this->input->post('guardian_email', TRUE)) ?
//                        '|is_unique[students.student_guardian_email]' : ''),
//                    ),
                );
        }

        public function image_config()
        {
                return array(
                    'encrypt_name'  => TRUE,
                    'upload_path'   => $this->config->item('student_image_dir'),
                    'allowed_types' => 'jpg|png|jpeg',
                    'max_size'      => "1000KB",
                    'max_height'    => "1000",
                    'max_width'     => "1000"
                );
        }

        /**
         * after set this, you can now use $this->student->{attributes|functions}
         * 
         * @param int $student_id
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function set_informations($student_id = NULL)
        {
                if ( ! $student_id)
                {
                        show_error('missing parameter in set student information.');
                }
                $this->load->library('student', array($student_id));
        }

        /**
         * 
         * @param type $image_file_name
         * @return object
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function image_resize($image_file_name = FALSE)
        {
                $filename  = NULL;
                $extension = NULL;
                $has_image = TRUE;
                if ($image_file_name)
                {
                        list($filename, $extension) = explode('.', $image_file_name);
                }
                else
                {
                        if ( ! $this->student)
                        {
                                /**
                                 * just to make sure student already loaded
                                 */
                                show_error('Student library not set for getting image data.');
                        }
                        $has_image = (bool) $this->student->image;
                        if ($has_image)
                        {
                                list($filename, $extension) = explode('.', $this->student->image);
                        }
                }
                if ($has_image)
                {
                        return (object) array(
                                    'profile' => $this->config->item('student_image_dir') . $this->config->item('student_image_size_profile') . $filename . '_thumb.' . $extension,
                                    'table'   => $this->config->item('student_image_dir') . $this->config->item('student_image_size_table') . $filename . '_thumb.' . $extension
                        );
                }
                else
                {
                        return (object) array(
                                    'profile' => NULL,
                                    'table'   => NULL
                        );
                }
        }

}
