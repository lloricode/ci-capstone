<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Curriculum_subject_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'curriculum_subjects';
                $this->primary_key = 'curriculum_subject_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

                $this->_relations();
                $this->_form();
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
                $this->has_one['curriculum'] = array(
                    'foreign_model' => 'Curriculum_model',
                    'foreign_table' => 'curriculums',
                    'foreign_key'   => 'curriculum_id',
                    'local_key'     => 'curriculum_id'
                );
                $this->has_one['subject']    = array(
                    'foreign_model' => 'Subject_model',
                    'foreign_table' => 'subjects',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );

                /**
                 * seperated table
                 */
                $this->has_many['requisites'] = array(
                    'foreign_model' => 'Requisites_model',
                    'foreign_table' => 'requisites',
                    'foreign_key'   => 'curriculum_subject_id',
                    'local_key'     => 'curriculum_subject_id'
                );

                $this->has_one['user']            = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'created_user_id'
                );
                /**
                 * subject offer
                 */
                $this->has_many['subject_offers'] = array(
                    'foreign_model' => 'Subject_offer_model',
                    'foreign_table' => 'subject_offers',
                    'foreign_key'   => 'subject_id',
                    'local_key'     => 'subject_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => $this->_insert(),
                    'update' => $this->_update()
                );
        }

        private function _common()
        {
                return array();
        }

        private function _inlist_semesters()
        {
                $this->load->helper('school');
                $return = '';
                foreach (semesters() as $k => $v)
                {
                        $return .= $k . ',';
                }
                $return = trim($return, ',');
                return $return;
        }

        private function _insert()
        {
                return array(
                    'curriculum_subject_year_level'       => array(
                        'label' => lang('curriculum_subject_year_level_label'),
                        'field' => 'level',
                        'rules' => 'trim|required|is_natural_no_zero'
                    ),
                    'curriculum_subject_semester'         => array(
                        'label'  => lang('curriculum_subject_semester_label'),
                        'field'  => 'semester',
                        'rules'  => 'trim|required|in_list[' . $this->_inlist_semesters() . ']', //must be specific value needed,table type type in enum
                        'errors' => array(
                            'in_list' => 'Invalid value in {field}'
                        )
                    ),
                    'curriculum_subject_units'            => array(
                        'label' => lang('curriculum_subject_units_label'),
                        'field' => 'units',
                        'rules' => 'trim|required|is_natural_no_zero|callback_unit_relate_types'
                    ),
                    'curriculum_subject_lecture_hours'    => array(
                        'label' => lang('curriculum_subject_lecture_hours_label'),
                        'field' => 'lecture',
                        'rules' => 'trim|required|is_natural'
                    ),
                    'curriculum_subject_laboratory_hours' => array(
                        'label' => lang('curriculum_subject_laboratory_hours_label'),
                        'field' => 'laboratory',
                        'rules' => 'trim|required|is_natural'
                    ),
                    'subject_id'                          => array(
                        'label' => lang('curriculum_subject_subject_label'),
                        'field' => 'subject',
                        'rules' => 'trim|required|is_natural_no_zero|differs[pre_requisite]|differs[co_requisite]|callback_check_subject_in_curiculum'
                    ),
                );
        }

        private function _update()
        {
                return array();
        }

        private function _curriculum_subject_query()
        {
                $this->
                        //specific fields in local table
                        fields(array(
                            'curriculum_id',
                            'curriculum_subject_year_level',
                            'curriculum_subject_semester',
                            'curriculum_subject_units',
                            'curriculum_subject_lecture_hours',
                            'curriculum_subject_laboratory_hours'
                        ))->
                        /**
                         * foreign table with specific fields
                         */
                        with_subject('fields:subject_code,subject_description')->
                        /**
                         * it has nested relation with subjects
                         */
                        with_requisites(array(
                            'with'   => array(
                                'relation' => 'subjects',
                                'fields'   => 'subject_code'
                            ),
                            'fields' => 'requisite_type'//specific fields
                        ))->
                        //specific fields
                        with_user('fields:first_name,last_name');

                return $this; //just cotinuation of a function chain
        }

        public function curriculum_subjects($curriculum_id, $subject_offer = FALSE)
        {
                return $this->
                                _curriculum_subject_query()->
                                where(array('curriculum_id' => $curriculum_id))->
                                order_by('curriculum_subject_year_level', 'ASC')->
                                order_by('curriculum_subject_semester', 'ASC')->
                                //set_cache()->
                                get_all();
        }

        public function curriculum_subject($curriculum_subject_id, $subject_offer = FALSE)
        {
                return $this->
                                _curriculum_subject_query()->
                                //set_cache()->
                                get($curriculum_subject_id);
        }

        public function subjects_dropdown_for_add_requisite($curriculum_id, $subject_id)
        {
                $subject_from_cur = $this->curriculum_subjects($curriculum_id);

                $return     = array();
                $requisites = array();

                if ($subject_from_cur)
                {
                        /**
                         * get requisite
                         */
                        foreach ($subject_from_cur as $v)
                        {
                                if ($subject_id == $v->subject_id)
                                {
                                        if (isset($v->requisites))
                                        {
                                                foreach ($v->requisites as $vv)
                                                {
                                                        //get all requisite of current subject
                                                        $requisites[] = $vv->subjects->subject_id;
                                                }
                                        }
                                        break;
                                }
                        }
                        //set option for array

                        foreach ($subject_from_cur as $v)
                        {
                                if (!in_array($v->subject_id, $requisites))//check if already added as requisite
                                {
                                        $return[$v->subject_id] = $v->subject->subject_code;
                                }
                        }

                        if (isset($return[$subject_id]))
                        {
                                unset($return[$subject_id]); //unset current subject
                        }
                }
//
//                return (object) array(
//                            'pre' => $return,
//                            'co'  => $return
//                );
                return $return;
        }

        public function total_units_per_term($cur_id, $sem, $yr_lvl)
        {
                return $this->db->select_sum('curriculum_subject_units')->
                                where(array(
                                    'curriculum_id'                 => $cur_id,
                                    'curriculum_subject_semester'   => $sem,
                                    'curriculum_subject_year_level' => $yr_lvl
                                ))->
                                get($this->table)->row()->curriculum_subject_units;
        }

        public function get_unit($id = NULL, $curr_id = NULL, $subject_id = NULL)
        {
                $obj = $this;
                if (is_null($id))
                {
                        $obj->where(array(
                            'curriculum_id' => $curr_id,
                            'subject_id'    => $subject_id
                        ));
                        return (int) $obj->get()->
                                curriculum_subject_units;
                }
                return (int) $obj->get($id)->
                        curriculum_subject_units;
        }

        /**
         * count if subject exists in curriculum
         * 
         * 
         * @param int $curriculum_id
         * @return bool
         * @author Edzar Calibod <lightningzeay@yahoo.com>
         */
        public function is_has_subject($curriculum_id)
        {
                return (bool) $this->where(array(
                            'curriculum_id' => $curriculum_id
                        ))->count_rows();
        }

}
