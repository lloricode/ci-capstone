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
                                return $this->__student->student_school_id;
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

        /**
         * 
         * subject_offer_id
         * days  
         * start  
         * end
         * subject_id       
         * subject_code        
         * subject_description            
         * subject_unit               
         * room_id    
         * room_number    
         * room_description   
         * faculty_id
         * faculty
         * 
         * @param int $limit
         * @param int $offset
         * @return object
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function subject_offers($limit, $offset)
        {
                $this->load->helper('day');
                $s_o_           = $this->__students_subjects($limit, $offset);
                $subject_offers = array();
                if ($s_o_)
                {
                        foreach ($s_o_ as $stud_sub)
                        {
                                $sub_of           = $this->Subject_offer_model->
                                        with_faculty()->
                                        with_room()->
                                        with_subject()->
                                        set_cache('student_library_subject_offers_' . $stud_sub->subject_offer_id)->
                                        get(array(
                                    'subject_offer_id' => $stud_sub->subject_offer_id
                                ));
                                $subject_offers[] = (object) array(
                                            //local
                                            'subject_offer_id'    => $sub_of->subject_offer_id,
                                            'days'                => subject_offers_days($sub_of),
                                            'start'               => $sub_of->subject_offer_start,
                                            'end'                 => $sub_of->subject_offer_end,
                                            //subject
                                            'subject_id'          => $sub_of->subject->subject_id,
                                            'subject_code'        => $sub_of->subject->subject_code,
                                            'subject_description' => $sub_of->subject->subject_description,
                                            'subject_unit'        => $sub_of->subject->subject_unit,
                                            //room
                                            'room_id'             => $sub_of->room->room_id,
                                            'room_number'         => $sub_of->room->room_number,
                                            'room_description'    => $sub_of->room->room_description,
                                            //user
                                            'faculty_id'          => $sub_of->faculty->id,
                                            'faculty'             => $sub_of->faculty->last_name . ', ' . $sub_of->faculty->first_name,
                                );
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
        private $_curriculum_subjects;

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
                $this->__course             = $this->__enrollment->course;
                /**
                 * set curriculum_id
                 */
                $this->_curriculum_subjects = $this->Subject_offer_model->all(TRUE, $this->__enrollment->curriculum_id); //parameter is set to current semester and year
        }

        protected function __load_education()
        {
                $this->__education = $this->Education_model->
                        set_cache('student_library_load_education_' . $this->__course->education_id)->
                        get(array(
                    'education_id' => $this->__course->education_id
                ));
        }

        protected function __students_subjects($limit, $offset)
        {
                return $this->Students_subjects_model->
                                where(array(
                                    'enrollment_id' => $this->__enrollment->enrollment_id
                                ))->
                                set_cache('student_library_students_subjects_' . $this->__enrollment->enrollment_id . '_limit_' . $limit . '_offset_' . $offset)->
                                limit($limit, $offset)->get_all();
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
                if ($this->_curriculum_subjects)
                {
                        foreach ($this->_curriculum_subjects as $s)
                        {
                                if ($level == $s->curriculum_subject->curriculum_subject_year_level)
                                {
                                        $return[] = $s;
                                }
                        }
                }
                return $return;
        }

}
