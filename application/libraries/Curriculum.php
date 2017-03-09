<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curriculum
{


        public $id;

        public function __construct()
        {
                $this->load->model(array(
                    'Curriculum_subject_model',
                    'Curriculum_model',
                    'Course_model'
                ));
        }

        /**
         * prevent calling undefined functions
         * 
         * @param type $name
         * @param type $arguments
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __call($name, $arguments)
        {
                show_error('method <b>"$this->' . strtolower(get_class()) . '->' . $name . '()"</b> not found in ' . __FILE__ . '.');
        }

        /**
         * easy access CI super global
         * 
         * 
         * @param type $name
         * @return mixed
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __get($name)
        {
                /**
                 * CI reference
                 */
                return get_instance()->$name;
        }

        public function set_id($id)
        {
                $this->id = $id;
        }

        public function get_subjects()
        {
                return $this->Curriculum_subject_model->
                                where(array('curriculum_id' => $this->id))->
                                order_by('curriculum_subject_year_level', 'ASC')->
                                order_by('curriculum_subject_semester', 'ASC')->
                                set_cache('curriculum_library_curriculum_subject_' . $this->id)->
                                get_all();
        }

}
