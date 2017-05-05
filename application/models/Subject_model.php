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

        protected function _add_created_by($data)
        {
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
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

                $this->has_one['unit'] = array(
                    'foreign_model' => 'Unit_model',
                    'foreign_table' => 'units',
                    'foreign_key'   => 'unit_id',
                    'local_key'     => 'unit_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    // 'insert' => $this->_common('is_unique[subjects.subject_code]'),
                    'update' => $this->_common('callback_check_unique')
                );
        }

        public function insert_validation()
        {
                $tmp = array(
                    'course_id' => array(
                        'label' => lang('index_course_heading'),
                        'field' => 'course',
                        'rules' => 'trim|is_natural'// zero mean gen-ed // then it will remove in update oberver to take NULL in DB
                    )
                );
                return array_merge($tmp, $this->_common('is_unique[subjects.subject_code]'));
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
                    )
                );
        }

        /**
         * 
         * @param int $id id of subject
         * @return bool
         */
        public function is_has_curriculum($id)
        {
                $this->load->model('Curriculum_subject_model');
                return (bool) (0 !== $this->Curriculum_subject_model->where(array(
                            $this->primary_key => $id
                        ))->count_rows());
        }

        public function all_with_curriculum_for_dropdown($field)
        {
                $this->load->model('Curriculum_subject_model');
                /**
                 * get all subject ids in curriculum_subject
                 * in distinct mode
                 */
                $subject_ids = $this->Curriculum_subject_model->
                        fields($this->primary_key)->
                        distinct()->
                        get_all();

                $return = array();
                if ($subject_ids)
                {
                        $s_ids = array();
                        /**
                         * prepare for where_in parameter
                         */
                        foreach ($subject_ids as $v)
                        {
                                $s_ids[] = $v->{$this->primary_key};
                        }
                        /**
                         * I use native CI, because 'where_in' in MY_Model not work properly
                         */
                        $obj = $this->db->
                                select("{$this->primary_key},$field")->
                                where_in($this->primary_key, $s_ids)->
                                get($this->table)->
                                result();

                        if ($obj)
                        {
                                foreach ($obj as $v)
                                {
                                        $return[$v->{$this->primary_key}] = $v->$field;
                                }
                        }
                }
                return $return;
        }

        public function get_leclab_hrs($id)
        {
                $obj = $this->fields('unit_id,course_id')->get($id);
                $lec = 0;
                $lab = 0;
                if ($obj)
                {
                        $this->load->model('Unit_model');
                        if ($obj->unit_id)
                        {
                                /**
                                 * minor
                                 */
                                $tmp = $this->with_unit('fields:lec_value,lab_value')->get($id);
                                if ($tmp)
                                {
                                        $lec = $tmp->unit->lec_value;
                                        $lab = $tmp->unit->lab_value;
                                }
                        }
                        else
                        {
                                $this->load->model(array('Curriculum_model', 'Curriculum_subject_model'));

                                //get active corriculum_id where course_id ->curriculum tbl
                                $curriculum_id = $this->Curriculum_model->
                                                fields('curriculum_id')->
                                                where(array(
                                                    'curriculum_status' => TRUE,
                                                    'course_id'         => $obj->course_id
                                                ))->
                                                get()->curriculum_id;

                                //get unit_id where corriculum_id and subject_id ->curriculum_subject tbl
                                $unit_id = $this->Curriculum_subject_model->
                                                fields('unit_id')->
                                                where(array(
                                                    'curriculum_id' => $curriculum_id,
                                                    'subject_id'    => $id
                                                ))->
                                                get()->unit_id;

                                $unit_obj = $this->Unit_model->get($unit_id);

                                if ($unit_obj)
                                {
                                        $lec = $unit_obj->lec_value;
                                        $lab = $unit_obj->lab_value;
                                }
                        }
                }
                return (object) array(
                            'lec' => (int) $lec,
                            'lab' => (int) $lab
                );
        }

}
