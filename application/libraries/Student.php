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


        /**
         * public
         */
        #personael info
        public $id;
        public $school_id;
        public $fullname;
        public $firstname;
        public $middlename;
        public $lastname;
        public $image;
        public $gender;
        public $birthdate;
        public $birthplace;
        public $civil_status;
        public $nationality;
        public $address;
        public $town;
        public $region;
        public $contact;
        public $email;
        #guardian
        public $guardian_fullname;
        public $guardian_adrress;
        public $guardian_contact;
        public $guardian_email;

        #school_info
        public $education_id;
        public $education_code;
        public $education_description;
        public $course_id;
        public $course_code;
        public $course_description;
        public $level;
        public $school_year;
        public $semester;
        public $enrollment_id;
        public $curriculum_id;

        public function __construct($student_id)
        {
                parent::__construct();
                $this->_get($student_id[0]);
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
         * 
         * @param int $studen_id
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _get($studen_id)
        {
                /**
                 * check if exist student id
                 */
                $this->__student = $this->Student_model->
                        set_cache('student_library_get_' . $studen_id)->
                        get($studen_id);
                if (!$this->__student)
                {
                        show_error('student information not found');
                }

                /**
                 * load enrollment, will also load course using with_course and set curriculum_id for curriculum library
                 */
                $this->__load_enrollment_n_course_n_set_corriculum_id();
                $this->__load_education();

                $this->id                    = $this->__student->student_id;
                $this->school_id             = $this->__student->student_school_id;
                $this->fullname              = $this->__student->student_lastname . ', ' . $this->__student->student_firstname . ' ' . $this->__student->student_middlename;
                $this->firstname             = $this->__student->student_firstname;
                $this->middlename            = $this->__student->student_middlename;
                $this->lastname              = $this->__student->student_lastname;
                $this->image                 = $this->__student->student_image;
                $this->gender                = $this->__student->student_gender;
                $this->birthdate             = $this->__student->student_birthdate;
                $this->birthplace            = $this->__student->student_birthplace;
                $this->civil_status          = $this->__student->student_civil_status;
                $this->nationality           = $this->__student->student_nationality;
                $this->address               = $this->__student->student_permanent_address;
                $this->town                  = $this->__student->student_address_town;
                $this->region                = $this->__student->student_address_region;
                $this->contact               = $this->__student->student_personal_contact_number;
                $this->email                 = $this->__student->student_personal_email;
                $this->guardian_fullname     = $this->__student->student_guardian_fullname;
                $this->guardian_adrress      = $this->__student->student_guardian_address;
                $this->guardian_contact      = $this->__student->student_guardian_contact_number;
                $this->guardian_email        = $this->__student->student_guardian_email;
                #######
                $this->education_id          = $this->__education->education_id;
                $this->education_code        = $this->__education->education_code;
                $this->education_description = $this->__education->education_description;
                $this->course_id             = $this->__course->course_id;
                $this->course_code           = $this->__course->course_code;
                $this->course_description    = $this->__course->course_description;
                $this->level                 = (int) $this->__enrollment->enrollment_year_level;
                $this->school_year           = $this->__enrollment->enrollment_school_year;
                $this->semester              = $this->__enrollment->enrollment_semester;
                $this->enrollment_id         = $this->__enrollment->enrollment_id;
                $this->curriculum_id         = $this->__enrollment->curriculum_id;
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

                if (!$this->__enrollment)
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
                $this->_curriculum_subjects = $this->Subject_offer_model->all(TRUE); //parameter is set to current semester and year
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

        protected function __curriculum_subjects()
        {
                return $this->_curriculum_subjects;
        }

}
