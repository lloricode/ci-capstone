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
 *  first MUST use $this->student->get($student_id);
 * +++++++++++++++++++++++++++++++++++++++++++++++
 * then you can now call all public functions
 * description of usage functions is on comment
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Student extends CI_capstone
{


        /**
         * all object var
         * @var objects
         */
        protected $student;
        protected $enrollment;
        protected $course;
        protected $education;
        protected $student_subjects;

        public function __construct()
        {
                parent::__construct();
        }

        /**
         * 
         * @param int $studen_id
         */
        public function get($studen_id = NULL)
        {
                if (!$studen_id)
                {
                        show_error('missing parameter.');
                }
                /**
                 * check if exist student id
                 */
                $this->student = $this->CI->Student_model->get($studen_id);
                if (!$this->student)
                {
                        show_error('student id not found');
                }

                /**
                 * load enrollment, will also load course using with_course
                 */
                $this->load_enrollment();
                $this->_load_education();
                $this->_load_student_subjects();

                return $this->student;
        }

        /**
         * 
         * 
         * 
         * all available public functions
         * 
         * paramete TRUE if all subjects
         * 
         * 
         * 'id'
         * 'subject_code'  
         * 'subject_description' 
         * 'subject_unit'        
         * 'days'              
         * 'start'            
         * 'end'               
         * 'room_number'        
         * 'room_description'    
         * 'faculty'   
         * 
         */
        public function subject_enrolled()
        {
                $subject_offers = array();
                if ($this->student_subjects)
                {
                        foreach ($this->student_subjects as $stud_sub)
                        {
                                $sub_of           = $this->CI->Subject_offer_model->with_faculty()->with_room()->with_subject()->get(array(
                                    'subject_offer_id' => $stud_sub->subject_offer_id
                                ));
                                $subject_offers[] = (object) array(
                                            'id'                  => $sub_of->subject_offer_id,
                                            'subject_code'        => $sub_of->subject->subject_code,
                                            'subject_description' => $sub_of->subject->subject_description,
                                            'subject_unit'        => $sub_of->subject->subject_unit,
                                            'days'                => $this->days($sub_of),
                                            'start'               => $sub_of->subject_offer_start,
                                            'end'                 => $sub_of->subject_offer_end,
                                            'room_number'         => $sub_of->room->room_number,
                                            'room_description'    => $sub_of->room->room_description,
                                            'faculty'             => $sub_of->faculty->last_name . ', ' . $sub_of->faculty->first_name,
                                );
                        }

                        return (object) $subject_offers;
                }
                return NULL;
        }

        public function subject_total()
        {
                return (int) $this->CI->Students_subjects_model->count_rows(array(
                            'enrollment_id' => $this->enrollment->enrollment_id
                ));
        }

        private function days($sub_off_obj)
        {
                return 'day not implemented yet';
        }

        /**
         * is student enrolled
         */
        public function is_enrolled($msg = TRUE)
        {
                if ($msg)
                {
                        return (($this->enrollment->enrollment_status) ? 'Enrolled' : 'Not Enrolled');
                }
                return (bool) $this->enrollment->enrollment_status;
        }

        public function course_code()
        {
                return $this->course->course_code;
        }

        public function course_description()
        {
                return $this->course->course_description;
        }

        public function education_code()
        {
                return $this->education->education_code;
        }

        public function education_description()
        {
                return $this->education->education_description;
        }

        public function level()
        {
                return $this->enrollment->enrollment_year_level;
        }

}

/**
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class CI_capstone
{


        /**
         *
         * @var reference CodeIgniter
         */
        protected $CI;

        public function __construct()
        {

                /**
                 * get reference
                 */
                $this->CI = & get_instance();
                /**
                 * loading models
                 */
                $this->CI->load->model(array(
                    'Student_model',
                    'Enrollment_model',
                    'Course_model',
                    'Education_model',
                    'Students_subjects_model',
                    'Subject_offer_model'
                ));
        }

        protected function load_enrollment()
        {
                $this->enrollment = $this->CI->Enrollment_model->with_course()->with_education()->get(array(
                    'student_id' => $this->student->student_id
                ));

                if (!$this->enrollment)
                {
                        show_error('student hos no enrollment result"');
                }
                $this->course = $this->enrollment->course;
        }

        protected function _load_education()
        {
                $this->education = $this->CI->Education_model->get(array(
                    'education_id' => $this->course->education_id
                ));
        }

        protected function _load_student_subjects()
        {
                $this->student_subjects = $this->CI->Students_subjects_model->where(array(
                            'enrollment_id' => $this->enrollment->enrollment_id
                        ))->as_object()->get_all();
        }

}
