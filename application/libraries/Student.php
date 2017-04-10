<?php

defined('BASEPATH') or exit('no direct script allowed');

/**
 * my Student easy search for enrollment system
 * 
 * 
 * usage:
 * 
 * load the library "Student" 
 * $this->load->library('student');
 * 
 * ++++++++++++++++++++++++++++++++++++++++++++++++
 *  first MUST use $this->__student->get($student_id);
 * +++++++++++++++++++++++++++++++++++++++++++++++
 * then you can now call all public functions
 * description of usage functions/attributes is on comment
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Student extends School_informations
{

        public function __construct($student_id)
        {
                parent::__construct();

                /**
                 * check if exist student id
                 */
                $this->__student = $this->Student_model->
                        set_cache('student_library_get_' . $student_id[0])->
                        get($student_id[0]);
                if ( ! $this->__student)
                {
                        show_error('student information not found');
                }

                /**
                 * load enrollment, will also load course using with_course and set curriculum_id for curriculum library
                 */
                $this->__load_enrollment_n_course_n_set_corriculum_id();
                $this->__load_education();
        }

        /**
         * prevent calling undefined functions
         * 
         * @param type $name
         * @param type $arguments
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function __call($method, $arguments)
        {
                show_error('method <b>"$this->' . strtolower(get_class()) . '->' . $method . '()"</b> not found in ' . __FILE__ . '.');
        }

        /**
         * MAGIC __GET
         * 
         * @param type $property
         * @return type
         */
        public function __get($property)
        {
                switch ($property)
                {
                        case 'id':
                                return $this->__student->student_id;
                        case 'school_id':
                                $s_id = (string) $this->__student->student_school_id;
                                return ($s_id === '') ? NULL : $s_id;
                        case 'fullname':
                                return $this->__student->student_lastname . ', ' .
                                        $this->__student->student_firstname . ' ' .
                                        $this->__student->student_middlename;
                        case 'firstname':
                                return $this->__student->student_firstname;
                        case 'middlename':
                                return $this->__student->student_middlename;
                        case 'lastname':
                                return $this->__student->student_lastname;
                        case 'image':
                                return $this->__student->student_image;
                        case 'gender':
                                return $this->__student->student_gender;
                        case 'birthdate':
                                return $this->__student->student_birthdate;
                        case 'birthplace':
                                return $this->__student->student_birthplace;
                        case 'civil_status':
                                return $this->__student->student_civil_status;
                        case 'nationality':
                                return $this->__student->student_nationality;
                        case 'address':
                                return $this->__student->student_permanent_address;
                        case 'town':
                                return $this->__student->student_address_town;
                        case 'region':
                                return $this->__student->student_address_region;
                        case 'contact':
                                return $this->__student->student_personal_contact_number;
                        case 'email':
                                return $this->__student->student_personal_email;
                        case 'guardian_fullname':
                                return $this->__student->student_guardian_fullname;
                        case 'guardian_adrress':
                                return $this->__student->student_guardian_address;
                        case 'guardian_contact':
                                return $this->__student->student_guardian_contact_number;
                        case 'guardian_email':
                                return $this->__student->student_guardian_email;
                        ####### 
                        case 'education_id':
                                return $this->__education->education_id;
                        case 'education_code':
                                return $this->__education->education_code;
                        case 'education_description':
                                return $this->__education->education_description;
                        case 'course_id':
                                return $this->__course->course_id;
                        case 'course_code':
                                return $this->__course->course_code;
                        case 'course_description':
                                return $this->__course->course_description;
                        case 'level':
                                return (int) $this->__enrollment->enrollment_year_level;
                        case 'level_place':
                                return number_place($this->__enrollment->enrollment_year_level) . ' Year';
                        case 'school_year':
                                return $this->__enrollment->enrollment_school_year;
                        case 'semester':
                                return $this->__enrollment->enrollment_semester;
                        case 'enrollment_id':
                                return $this->__enrollment->enrollment_id;
                        case 'curriculum_id':
                                return $this->__enrollment->curriculum_id;
                        default :

                                /**
                                 * check if property is exist on CI
                                 */
                                if (property_exists(get_instance(), $property))
                                {
                                        return get_instance()->$property;
                                }
                                else
                                {
                                        show_error('property <b>"$this->' . strtolower(get_class()) . '->' . $property . '"</b> not found in ' . __FILE__ . '.');
                                }
                }
        }

        public function school_id($alter = FALSE)
        {
                $s_id = (string) $this->__student->student_school_id;
                if ($alter)
                {
                        if ($s_id === '')
                        {
                                return $this->__student->student_lastname . ', ' .
                                        $this->__student->student_firstname . ' ' .
                                        $this->__student->student_middlename;
                        }
                }
                if ($s_id === '')
                {
                        return 'Not Enrolled yet.';
                }
                return $s_id;
        }

        public function set_enroll()
        {
                if ( ! specific_groups_permission($this->config->item('user_group_accounting')))
                {
                        show_404();
                }

                $student_schoo_id_inserted = TRUE;

                if ((string) $this->__student->student_school_id === '')
                {
                        $this->load->library('school_id', NULL, 'school_id_generator');
                        $this->school_id_generator->initialize($this->__course->course_code_id);
                        $generated_school_id       = (string) $this->school_id_generator->generate();
                        $student_schoo_id_inserted = $this->Student_model->update(array(
                            'student_school_id' => $generated_school_id
                                ), $this->__student->student_id);
                }
                /**
                 * start the DB transaction
                 */
                $this->db->trans_start();


                $subject_ok = $this->_set_enroll_all_subject_offers();

                $enroll_ok = $this->Enrollment_model->update(array(
                    'enrollment_status'      => TRUE,
                    'enrollment_semester'    => current_school_semester(TRUE),
                    'enrollment_school_year' => current_school_year()
                        ), $this->__enrollment->enrollment_id);

                if ( ! $enroll_ok OR ! $subject_ok OR ! $student_schoo_id_inserted)
                {
                        /**
                         * rollback database
                         */
                        $this->db->trans_rollback();
                        $msg = 'Failed to update Enroll.';
                        if ( ! $subject_ok)
                        {
                                $msg = str_replace('.', ',', $msg);
                                $msg .= ' No Subject to Enroll.';
                        }
                        if ( ! $student_schoo_id_inserted)
                        {
                                $msg = str_replace('.', ',', $msg);
                                $msg .= ' School ID Failed to generate.';
                        }
                        $this->session->set_flashdata('message', '<div class="alert alert-error alert-block">' . $msg . '</div>');
                }
                else
                {
                        if ($this->db->trans_commit())
                        {
                                $this->session->set_flashdata('message', 'Student Enrolled!');
                        }
                }
        }

        private function _set_enroll_all_subject_offers()
        {
                return $this->Students_subjects_model->update(array(
                            'student_subject_enroll_status' => TRUE,
                            'enrollment_id'                 => $this->__enrollment->enrollment_id
                                ), 'enrollment_id');
        }

        public function update_level($new_level)
        {
                if ( ! is_int($new_level))
                {
                        $this->session->set_flashdata('message', '<div class="alert alert-error alert-block">Year level not to be Int.</div>');
                        return FALSE;
                }
                if ($new_level > $this->config->item('max_year_level') OR $new_level < $this->__enrollment->enrollment_year_level)
                {
                        $this->session->set_flashdata('message', '<div class="alert alert-error alert-block">Invalid year level update.</div>');
                        return FALSE;
                }
                $this->load->helper('school');
                if ($this->Enrollment_model->update(array(
                            'enrollment_semester'    => current_school_semester(TRUE),
                            'enrollment_school_year' => current_school_year(),
                            'enrollment_year_level'  => $new_level
                                ), $this->__enrollment->enrollment_id))
                {
                        return TRUE;
                }
        }

        /**
         * sample result with one row/result
         * Array
         *  (
         *        [0] => Array
         *        (
         *                [id] => 4
         *                [year] => 1
         *                [semester] => 1st Semester
         *                [subject] => Engl 111
         *                [faculty] => Lastw, Firsty
         *                [unit] => 3
         *                [status] => 0
         *                [day1] => TH
         *                [start1] => 06:30 AM
         *                [end1] => 07:00 AM
         *                [room1] => 105
         *                [day2] => T
         *                [start2] => 07:00 AM
         *                [end2] => 07:30 AM
         *                [room2] => 105
         *        )
         *        
         *  )
         * 
         * @param int $limit
         * @param int $offset
         * @return object
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function subject_offers($button_link = FALSE/* $limit, $offset */)
        {
                $this->load->helper(array('day', 'school', 'time'));
                $s_o_           = $this->__students_subjects(/* $limit, $offset */);
                $subject_offers = array();
                if ($s_o_)
                {
                        foreach ($s_o_ as $stud_sub)
                        {
                                $sub_of = $this->Subject_offer_model->
                                        fields('subject_offer_id')->
                                        with_faculty('fields:last_name,first_name')->
                                        with_subject('fields:subject_code,subject_description')->
                                        with_curriculum_subject(
                                                'fields:curriculum_subject_year_level,'
                                                . 'curriculum_subject_semester,'
                                                . 'curriculum_subject_units'
                                        )->
                                        with_subject_line(array(
                                            'with'   => array(
                                                'relation' => 'room',
                                                'fields'   => 'room_number'
                                            ),
                                            'fields' =>
                                            'subject_offer_line_start,' .
                                            'subject_offer_line_end,' .
                                            'subject_offer_line_monday,' .
                                            'subject_offer_line_tuesday,' .
                                            'subject_offer_line_wednesday,' .
                                            'subject_offer_line_thursday,' .
                                            'subject_offer_line_friday,' .
                                            'subject_offer_line_saturday,' .
                                            'subject_offer_line_sunday'
                                        ))->
                                        set_cache('student_library_subject_offers_' . $stud_sub->subject_offer_id)->
                                        get($stud_sub->subject_offer_id);

                                $subject_line = array();
                                $tmp          = 0;
                                foreach ($sub_of->subject_line as $line)
                                {
                                        $tmp ++;
                                        $subject_line = array_merge($subject_line, array(
                                            'day' . $tmp   => subject_offers_days($line),
                                            'start' . $tmp => convert_24_to_12hrs($line->subject_offer_line_start),
                                            'end' . $tmp   => convert_24_to_12hrs($line->subject_offer_line_end),
                                            'room' . $tmp  => $line->room->room_number,
                                        ));
                                }
                                if ($tmp === 1)
                                {
                                        $tmp ++;
                                        $subject_line = array_merge($subject_line, array(
                                            'day' . $tmp   => '--',
                                            'start' . $tmp => '--',
                                            'end' . $tmp   => '--',
                                            'room' . $tmp  => '--',
                                        ));
                                }
                                $subject_offers[] = (object) array_merge(array(
                                            'id'       => $sub_of->subject_offer_id,
                                            'year'     => number_place($sub_of->curriculum_subject->curriculum_subject_year_level) . ' Year',
                                            'semester' => semesters($sub_of->curriculum_subject->curriculum_subject_semester),
                                            'subject'  => $sub_of->subject->subject_code,
                                            'faculty'  => ($button_link) ? ($sub_of->faculty->last_name . ', ' . $sub_of->faculty->first_name) : $this->User_model->button_link($sub_of->faculty->id, $sub_of->faculty->last_name, $sub_of->faculty->first_name),
                                            //--
                                            'unit'     => $sub_of->curriculum_subject->curriculum_subject_units,
                                            'status'   => ($stud_sub->student_subject_enroll_status) ? 'Enrolled' : 'Pending'
                                                ), $subject_line);
                        }

                        return (object) $subject_offers;
                }
                return NULL;
        }

        /**
         * total subject enrolled
         * 
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function subject_total()
        {
                return (int) $this->Students_subjects_model->
                                count_rows(array(
                                    'enrollment_id' => $this->__enrollment->enrollment_id
                ));
        }

        /**
         * 
         * @param bool $msg where if you want return as string with message
         * @return bool|string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function is_enrolled($msg = FALSE)
        {
                if ($msg)
                {
                        return (($this->__enrollment->enrollment_status) ? 'Enrolled' : 'Not Enrolled');
                }
                return (bool) $this->__enrollment->enrollment_status;
        }

        /**
         * age of current student
         * 
         * @param bool $msg where if you want return as string with message
         * @return int|string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function age($msg = FALSE)
        {
                $this->load->library('age');
                $this->age->initialize($this->__student->student_birthdate);
                return $this->age->result() . (($msg) ? ' years old' : '');
        }

        /**
         * 
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function get_all_subject_available_to_enroll()
        {
                return $this->__curriculum_subjects();
        }

}

/**
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class School_informations
{


        /**
         * all object var
         * @var objects
         */
        protected $__student;
        protected $__enrollment;
        protected $__course;
        protected $__education;
        private $_curriculum_subjects__subject_offers;

        public function __construct()
        {

                /**
                 * loading models
                 */
                $this->load->model(array(
                    'Student_model',
                    'Enrollment_model',
                    'Course_model',
                    'Education_model',
                    'Students_subjects_model',
                    'Subject_offer_model',
                    'Curriculum_subject_model'
                ));
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

        /**
         * load enrollment include course then set curriculum_id for curriculum library
         */
        protected function __load_enrollment_n_course_n_set_corriculum_id()
        {
                $this->__enrollment = $this->Enrollment_model->
                        with_course()->
                        with_education()->
                        set_cache('student_library_students_load_enrollment_' . $this->__student->student_id)->
                        get(array(
                    'student_id' => $this->__student->student_id
                ));

                if ( ! $this->__enrollment)
                {
                        show_error('student has no enrollment result"');
                }
                /**
                 * course
                 */
                $this->__course                             = $this->__enrollment->course;
                /**
                 * set curriculum_id
                 */
                $this->_curriculum_subjects__subject_offers = $this->Subject_offer_model->all(TRUE, $this->__enrollment->curriculum_id, $this->__enrollment->enrollment_id); //parameter is set to current semester and year
        }

        protected function __load_education()
        {
                $this->__education = $this->Education_model->
                        set_cache('student_library_load_education_' . $this->__course->education_id)->
                        get(array(
                    'education_id' => $this->__course->education_id
                ));
        }

        protected function __students_subjects(/* $limit, $offset */)
        {
                return $this->Students_subjects_model->
                                where(array(
                                    'enrollment_id' => $this->__enrollment->enrollment_id
                                ))->
                                //set_cache('student_library_students_subjects_' . $this->__enrollment->enrollment_id . '_limit_' . $limit . '_offset_' . $offset)->
                                set_cache('student_library_students_subjects_' . $this->__enrollment->enrollment_id)->
                                // limit($limit, $offset)->
                                get_all();
        }

        /**
         * filter with level of current student
         * 
         * @return array
         */
        protected function __curriculum_subjects($add_level = 0)//parameter will use in recursive call
        {
                $level  = (int) $this->__enrollment->enrollment_year_level;
                $level  += $add_level;
                $return = array();
                if ($this->_curriculum_subjects__subject_offers)
                {
                        foreach ($this->_curriculum_subjects__subject_offers as $s)
                        {

                                if (isset($s->student_subjects->enrollment_id))
                                {
                                        // i made an issue for this
                                        //https://github.com/avenirer/CodeIgniter-MY_Model/issues/231
                                        //this is temporary,(if fixed will refactor)
                                        if ($s->student_subjects->enrollment_id == $this->__enrollment->enrollment_id)//i set to not != so check if exist then skip
                                        {

                                                continue;
                                        }
                                }


                                // if ($level == $s->curriculum_subject->curriculum_subject_year_level)
                                // {
                                $return[] = $s;
                                // }
                        }
                }
                return $return;
        }

}
