<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Enrollment_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'enrollments';
                $this->primary_key = 'enrollment_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

                $this->_relations();
                $this->_form();
                $this->_config();

                parent::__construct();
        }

        protected function _add_created_by($data)
        {
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
                if (isset($data['enrollment_status']))
                {
                        if ($data['enrollment_status'] === '0')
                        {
                                return $data; //skip. no need to add user_id,
                        }
                }
                $data['updated_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver         = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix         = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                //   $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_one['course'] = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'courses',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );

                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'id',
                    'local_key'     => 'id'
                );

                $this->has_one['curriculum'] = array(
                    'foreign_model' => 'Curriculum_model',
                    'foreign_table' => 'curriculums',
                    'foreign_key'   => 'curriculum_id',
                    'local_key'     => 'curriculum_id'
                );

                $this->has_one['student'] = array(
                    'foreign_model' => 'Student_model',
                    'foreign_table' => 'stundents',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => $this->_common(),
                    'update' => $this->_common()
                );
        }

        private function _common()
        {
                return array(
                    'enrollment_year_level' => array(
                        'label' => lang('index_student_year_level_th'),
                        'field' => 'level',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    'course_id'             => array(
                        'label' => lang('index_course_id_th'),
                        'field' => 'courseid',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                );
        }

        private function _update()
        {
                return array(
                    'enrollment_school_year' => array(
                        'label' => lang('index_student_school_year_th'),
                        'field' => 'school_year',
                        'rules' => 'trim|required',
                    ),
                    'enrollment_semester'    => array(
                        'label' => lang('index_student_semesterl_th'),
                        'field' => 'semester',
                        'rules' => 'trim|required',
                    )
                );
        }

        public function unenroll_all_past_term()
        {
                $this->where(
                                '`enrollment_semester` != \'' . current_school_semester(TRUE) . '\'' .
                                ' OR `enrollment_school_year` != \'' . current_school_year() . '\''
                                , NULL, NULL, FALSE, FALSE, TRUE
                        )->
                        update(array(
                            'enrollment_status' => '0'
                ));
        }

}
