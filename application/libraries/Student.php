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
 * description of usage functions/attributes is on comment
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Student extends CI_capstone
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

        public function __construct()
        {
                parent::__construct();
        }

        /**
         * 
         * @param int $studen_id
         * @return object student row
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
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
                $this->student = $this->CI->Student_model->
                        set_cache('students_id_' . $studen_id)->
                        get($studen_id);
                if (!$this->student)
                {
                        show_error('student id not found');
                }

                /**
                 * load enrollment, will also load course using with_course
                 */
                $this->load_enrollment();
                $this->_load_education();

                $this->id                    = $this->student->student_id;
                $this->school_id             = $this->student->student_school_id;
                $this->fullname              = $this->student->student_lastname . ', ' . $this->student->student_firstname . ' ' . $this->student->student_middlename;
                $this->firstname             = $this->student->student_firstname;
                $this->middlename            = $this->student->student_middlename;
                $this->lastname              = $this->student->student_lastname;
                $this->image                 = $this->student->student_image;
                $this->gender                = $this->student->student_gender;
                $this->birthdate             = $this->student->student_birthdate;
                $this->birthplace            = $this->student->student_birthplace;
                $this->civil_status          = $this->student->student_civil_status;
                $this->nationality           = $this->student->student_nationality;
                $this->address               = $this->student->student_permanent_address;
                $this->town                  = $this->student->student_address_town;
                $this->region                = $this->student->student_address_region;
                $this->contact               = $this->student->student_personal_contact_number;
                $this->email                 = $this->student->student_personal_email;
                $this->guardian_fullname     = $this->student->student_guardian_fullname;
                $this->guardian_adrress      = $this->student->student_guardian_address;
                $this->guardian_contact      = $this->student->student_guardian_contact_number;
                $this->guardian_email        = $this->student->student_guardian_email;
                #######
                $this->education_id          = $this->education->education_id;
                $this->education_code        = $this->education->education_code;
                $this->education_description = $this->education->education_description;
                $this->course_id             = $this->course->course_id;
                $this->course_code           = $this->course->course_code;
                $this->course_description    = $this->course->course_description;
                $this->level                 = (int) $this->enrollment->enrollment_year_level;
                $this->school_year           = $this->enrollment->enrollment_school_year;
                $this->semester              = $this->enrollment->enrollment_semester;
                $this->enrollment_id         = $this->enrollment->enrollment_id;
        }

        /**
         * 
         * @param type $image_file_name
         * @return object
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function image_resize($image_file_name = FALSE)
        {
                $filename  = NULL;
                $extension = NULL;
                if ($image_file_name)
                {
                        list($filename, $extension) = explode('.', $image_file_name);
                }
                else
                {
                        if (!$this->student)
                        {
                                /**
                                 * just to make sure student already loaded
                                 */
                                show_error('Student not set for getting image data.');
                        }
                        list($filename, $extension) = explode('.', $this->student->student_image);
                }
                return (object) array(
                            'profile' => $this->CI->config->item('student_image_size_profile') . $filename . '_thumb.' . $extension,
                            'table'   => $this->CI->config->item('student_image_size_table') . $filename . '_thumb.' . $extension
                );
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
                $this->CI->load->helper('day');
                $s_o_           = $this->suject_offers_($limit, $offset);
                $subject_offers = array();
                if ($s_o_)
                {
                        foreach ($s_o_ as $stud_sub)
                        {
                                $sub_of           = $this->CI->Subject_offer_model->
                                        with_faculty()->
                                        with_room()->
                                        with_subject()->
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
                return (int) $this->CI->Students_subjects_model->
                                set_cache('students_subject_total' . $this->enrollment->enrollment_id)->
                                count_rows(array(
                                    'enrollment_id' => $this->enrollment->enrollment_id
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
                        return (($this->enrollment->enrollment_status) ? 'Enrolled' : 'Not Enrolled');
                }
                return (bool) $this->enrollment->enrollment_status;
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
                $this->CI->load->library('age');
                $this->CI->age->initialize($this->student->student_birthdate);
                return $this->CI->age->result() . (($msg) ? ' years old' : '');
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

        /**
         * all object var
         * @var objects
         */
        protected $student;
        protected $enrollment;
        protected $course;
        protected $education;

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
                $this->enrollment = $this->CI->Enrollment_model->
                        with_course()->
                        with_education()->
                        set_cache('students_load_enrollment' . $this->student->student_id)->
                        get(array(
                    'student_id' => $this->student->student_id
                ));

                if (!$this->enrollment)
                {
                        show_error('student has no enrollment result"');
                }
                $this->course = $this->enrollment->course;
        }

        protected function _load_education()
        {
                $this->education = $this->CI->Education_model->
                        set_cache('students_load_education' . $this->course->education_id)->
                        get(array(
                    'education_id' => $this->course->education_id
                ));
        }

        protected function suject_offers_($limit, $offset)
        {
                return $this->CI->Students_subjects_model->
                                where(array(
                                    'enrollment_id' => $this->enrollment->enrollment_id
                                ))->
                                as_object()->
                                set_cache('students_suject_offers_' . $this->enrollment->enrollment_id . '_limit_' . $limit . '_offset_' . $offset)->
                                limit($limit, $offset)->get_all();
        }

}
