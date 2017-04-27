<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subjects';
                $this->primary_key = 'subject_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

                $this->_relations();
                $this->_form();
                $this->_config();

                parent::__construct();
        }

        private function _set_null($data, $contrller)
        {
//                $controll_name = $this->uri->segment($this->config->item('segment_controller'));
//                if ($contrller === (string) str_replace('_', '-', $controll_name))
//                {
//                        if (isset($data['course_id']))
//                        {
//                                if ($data['course_id'] == 0)
//                                {
//                                        if ('create-subject' === $contrller)
//                                        {
//
//                                                //check if really in add subject,then check if "course [post]" is zero 
//                                                //then remove to get NULL,to make gen-ed
//                                                unset($data['course_id']);
//                                        }
//                                }
//                        }
//                }
                return $data;
        }

        protected function _add_created_by($data)
        {
                $data                    = $this->_set_null($data, 'create-subject');
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
                $data                    = $this->_set_null($data, 'edit-subject');
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
                // $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_one['user_created']       = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'created_user_id'
                );
                $this->has_one['user_updated']       = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'updated_user_id'
                );
                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                $this->has_one['curriculum_subject'] = array(
                    'foreign_model' => 'Curriculum_subject_model',
                    'foreign_table' => 'curriculum_subjects',
                    'foreign_key'   => 'curriculum_subject_id',
                    'local_key'     => 'curriculum_subject_id'
                );

                $this->has_one['course'] = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'course',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => $this->_common('is_unique[subjects.subject_code]'),
                    'update' => $this->_common('callback_check_unique')
                );
        }

        private function _common($unique)
        {
                return array(
                    'subject_code'        => array(
                        'label'  => lang('create_subject_code_label'),
                        'field'  => 'code',
                        'rules'  => 'trim|required|min_length[2]|max_length[50]|' . $unique,
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                    'subject_description' => array(
                        'label'  => lang('create_subject_description_label'),
                        'field'  => 'description',
                        'rules'  => 'trim|required|min_length[2]|max_length[100]', //|is_unique[subjects.subject_description]',// suggested in our last chat in chat forum
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                    'course_id'           => array(
                        'label' => lang('index_course_heading'),
                        'field' => 'course',
                        'rules' => 'trim|is_natural'// zero mean gen-ed // then it will remove in update oberver to take NULL in DB
                    )
                );
        }

}
