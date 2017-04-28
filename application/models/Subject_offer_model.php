<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_offer_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subject_offers';
                $this->primary_key = 'subject_offer_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

                $this->_relations();
                $this->_config();

                parent::__construct();
        }

        protected function _add_created_by($data)
        {
                $this->load->helper('mymodel');
                $data                    = remove_empty_before_write($data);
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
                $this->load->helper('mymodel');
                $data                    = remove_empty_before_write($data);
                $data['updated_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
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
                $this->has_one['user_created'] = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'created_user_id'
                );
                $this->has_one['user_updated'] = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'updated_user_id'
                );
                $this->has_one['subject']      = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
                $this->has_one['room']         = array(
                    'foreign_model' => 'Room_model',
                    'foreign_table' => 'rooms',
                    'foreign_key'   => 'room_id',
                    'local_key'     => 'room_id'
                );
                $this->has_one['faculty']      = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'user_id'
                );

                $this->has_many['subject_line'] = array(
                    'foreign_model' => 'Subject_offer_line_model',
                    'foreign_table' => 'subject_offer_line',
                    'foreign_key'   => 'subject_offer_id',
                    'local_key'     => 'subject_offer_id'
                );

                $this->has_one['curriculum_subject'] = array(
                    'foreign_model' => 'Curriculum_subject_model',
                    'foreign_table' => 'curriculum_subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );

                $this->has_one['student_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'subject_offer_id',
                    'local_key'     => 'subject_offer_id'
                );
        }

        public function insert_validations()
        {
                return array(
                    array(
                        'label' => lang('create_user_id_label'),
                        'field' => 'faculty',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    array(
                        'label' => lang('create_subject_id_label'),
                        'field' => 'subject',
                        'rules' => 'trim|required|is_natural_no_zero',
                    )
                );
        }

        private function _query()
        {
                $this->
                        fields('subject_offer_id,created_at,updated_at')->
                        with_user_created('fields:first_name,last_name')->
                        with_user_updated('fields:first_name,last_name')->
                        with_subject('fields:subject_code,subject_description')->
                        with_faculty('fields:first_name,last_name')->
                        with_subject_line(array(
                            'fields' => // array(
                            'subject_offer_line_start,' .
                            'subject_offer_line_end,' .
                            'subject_offer_line_monday,' .
                            'subject_offer_line_tuesday,' .
                            'subject_offer_line_wednesday,' .
                            'subject_offer_line_thursday,' .
                            'subject_offer_line_friday,' .
                            'subject_offer_line_saturday,' .
                            'subject_offer_line_sunday,' .
                            'subject_offer_line_lec,' .
                            'subject_offer_line_lab'
                            , //),
                            'with'   => array(//sub query of sub query
                                'relation' => 'room',
                                'fields'   => 'room_number,room_capacity'
                )));
                return $this;
        }

        public function where_current_sem_year($arr_return = FALSE)//paramter TRUE used in pagination
        {
                $arr = array(
                    'subject_offer_semester'    => current_school_semester(TRUE),
                    'subject_offer_school_year' => current_school_year(),
                );
                if ($arr_return)
                {
                        return $arr;
                }
                $this->where($arr);
                return $this;
        }

        public function all($current_sem_year = FALSE, $curriculum_id = FALSE, $enrollment_id = FALSE, $limit = NULL, $offset = NULL, $faculty_id = NULL/* to get all current schedules */)
        {
                $this->_query();
                if ($current_sem_year)
                {
                        /**
                         * only current semester and year, if set to TRUE
                         */
                        $this->where_current_sem_year();
                }
                if ($enrollment_id)
                {
                        /**
                         * for student profile
                         */
                        $this->with_student_subjects(); //'where:`enrollment_id`!=' . $enrollment_id);
                }
                $where__     = array(
                    'field'    => 'curriculum_subject_year_level,curriculum_subject_semester',
                    'order_by' => 'curriculum_subject_year_level,curriculum_subject_semester',
                    'with'     => array(
                        'relation' => 'curriculum',
                        'field'    => 'curriculum_id'
                ));
                $change_name = '';
                if ($curriculum_id)
                {
                        $nested_where['where'] = array(
                            'curriculum_id' => $curriculum_id
                        );
                        $where__               = array_merge($where__, $nested_where);
                        $change_name           = 'curriculum_id' . $curriculum_id;
                }
                if ( ! is_null($faculty_id))
                {
                        $this->where(array(
                            'user_id' => $faculty_id
                        ));
                }
                $this->with_curriculum_subject($where__);
                if ( ! is_null($limit) && ! is_null($offset))
                {
                        /**
                         * for view all schedule (http://[::1]/ci-capstone/en/subject-offers)
                         */
                        $this->limit($limit, $offset);
                }
                return $this->
                                //set_cache(' '.$change_name)->
                                get_all();
        }

        public function all_on_curriculum($curriculum_id)
        {
                return $this->_query()->
                                {$this->where_current_sem_year()}->
                                where(array(
                                    'curriculum_id' => $curriculum_id
                                ))->
                                //set_cache()->
                                get_all();
        }

}
