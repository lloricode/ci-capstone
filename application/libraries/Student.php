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


        private $_not_enrolled_msg = 'Not Enrolled yet.';

        public function __construct($student_id)
        {
                parent::__construct();
                $this->load->helper('student');
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
                $this->__load_curriculum();
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
                                return civil_status($this->__student->student_civil_status);
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
                        case 'level_roman':
                                return number_roman($this->__enrollment->enrollment_year_level);
                        case 'school_year':
                                return $this->__enrollment->enrollment_school_year;
                        case 'semester':
                                return semesters($this->__enrollment->enrollment_semester);
                        case 'enrollment_id':
                                return $this->__enrollment->enrollment_id;
                        case 'curriculum_id':
                                return $this->__curriculum->curriculum_id;
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

        public function curriculum($anchor = FALSE)
        {
                $id           = $this->__curriculum->curriculum_id;
                $effectv_year = $this->__curriculum->curriculum_effective_school_year;
                $desc         = $this->__curriculum->curriculum_description;
                if ($anchor)
                {
                        $label = $effectv_year . ' -  ' . $desc;
                        return anchor('curriculums/view?curriculum-id=' . $id, bold($label), array('title' => 'View Curriculum', 'class' => "tip-bottom"));
                }
                return 'not implemented yet..';
        }

        public function enrolled_term_year()
        {
                if (is_null($this->__enrollment->enrollment_school_year) OR is_null($this->__enrollment->enrollment_semester))
                {
                        return $this->_not_enrolled_msg;
                }
                return $this->__enrollment->enrollment_school_year . ', ' . semesters($this->__enrollment->enrollment_semester);
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
                        return $this->_not_enrolled_msg;
                }
                return $s_id;
        }

        public function set_enroll()
        {
                if ( ! specific_groups_permission($this->config->item('user_group_accounting')))
                {
                        show_404();
                }
                if ($this->__enrollment->enrollment_status)
                {
                        $this->session->set_flashdata('message', bootstrap_error('Student Already Enrolled'));
                        return;
                }
                /**
                 * start the DB transaction
                 */
                $this->db->trans_begin();

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

                $subject_ok = $this->set_enroll_all_subject_offers();

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
                        $this->session->set_flashdata('message', bootstrap_error($msg));
                }
                else
                {
                        if ($this->db->trans_commit())
                        {
                                $this->session->set_flashdata('message', bootstrap_success('Student Enrolled!'));
                        }
                }
        }

        public function set_enroll_all_subject_offers()
        {
                return $this->Students_subjects_model->
                                where(array(
                                    'student_subject_semester'    => current_school_semester(TRUE),
                                    'student_subject_school_year' => current_school_year()
                                ))->
                                update(array(
                                    'student_subject_enroll_status' => TRUE,
                                    'enrollment_id'                 => $this->__enrollment->enrollment_id
                                        ), 'enrollment_id');
        }

        /**
         * return false if student is NOT enrolled
         * 
         * @return bool
         */
        public function is_has_pending()
        {
                if ( ! $this->__enrollment->enrollment_status)
                {
                        return FALSE;
                }

                return (bool) $this->Students_subjects_model->where(array(
                            'student_subject_enroll_status' => FALSE,
                            'enrollment_id'                 => $this->__enrollment->enrollment_id
                        ))->count_rows();
        }

        public function update_level($new_level)
        {
                if ( ! is_int($new_level))
                {
                        $this->session->set_flashdata('message', bootstrap_error('Year level not to be Int.'));
                        return FALSE;
                }
                if ($new_level > $this->config->item('max_year_level') OR $new_level < $this->__enrollment->enrollment_year_level)
                {
                        $this->session->set_flashdata('message', bootstrap_error('Invalid year level update.'));
                        return FALSE;
                }
                $this->load->helper('school');
                if ($this->Enrollment_model->update(array(
                            'enrollment_year_level' => $new_level
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
        public function subject_offers($return_html = FALSE, $return_type = 'object', $current_subject = TRUE)
        {
                $status_return = function ($_status, $return_html, $row)
                {
                        $tmp     = ($_status) ? 'done' : 'pending';
                        $_status = ($_status) ? 'Enrolled' : 'Pending';
                        if ($return_html)
                        {
                                return $_status;
                        }
                        return array('data' => '<span class="' . $tmp . '">' . $_status . '</span>', 'class' => 'taskStatus', 'rowspan' => $row);
                };
                $this->load->helper(array('day', 'school', 'time'));
                $s_o_           = $this->__students_subjects($current_subject);
                $subject_offers = array();
                if ($s_o_)
                {
                        $tmp_compare = '';
                        foreach ($s_o_ as $stud_sub)
                        {
                                if ( ! $current_subject)
                                {
                                        $tmp_sem_year = $stud_sub->student_subject_school_year . $stud_sub->student_subject_semester;

                                        if ($tmp_compare != $tmp_sem_year)
                                        {
                                                $tmp_compare = $tmp_sem_year;
                                                $current_    = '';
                                                if (current_school_semester(TRUE) == $stud_sub->student_subject_semester && current_school_year() == $stud_sub->student_subject_school_year)
                                                {
                                                        $current_ = ' [Current]';
                                                }
                                                $temp_            = heading($stud_sub->student_subject_school_year . ', ' . semesters($stud_sub->student_subject_semester) . $current_, 4);
                                                $subject_offers[] = array(array('data' => $temp_, 'colspan' => 9));
                                        }
                                }

                                $sub_of = $this->Subject_offer_model->
                                        fields('subject_offer_id')->
                                        with_faculty('fields:last_name,first_name')->
                                        with_subject('fields:subject_code,subject_description'/* ,subject_rate' */)->
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

                                $sched1    = NULL;
                                $sched2    = NULL;
                                $row_count = 0;

                                foreach ($sub_of->subject_line as $line)
                                {
                                        ++ $row_count;
                                        ${'sched' . $row_count} = array(
                                            subject_offers_days($line),
                                            convert_24_to_12hrs($line->subject_offer_line_start),
                                            convert_24_to_12hrs($line->subject_offer_line_end),
                                            $line->room->room_number,
                                        );
                                }

                                $unit       = $this->Curriculum_subject_model->get_unit(NULL, $stud_sub->curriculum_id, $sub_of->subject->subject_id);
                                $row_output = array(
                                    $this->_row($sub_of->subject->subject_code, $row_count),
                                    $this->_row($sub_of->subject->subject_description, $row_count),
                                    $this->_row($unit, $row_count)
                                );

                                foreach ($sched1 as $v)
                                {
                                        $row_output[] = $v;
                                }
                                $row_output[]  = $this->_row((($return_html) ? ($sub_of->faculty->last_name . ', ' . $sub_of->faculty->first_name) : $this->User_model->button_link($sub_of->faculty->id, $sub_of->faculty->last_name, $sub_of->faculty->first_name)), $row_count);
//                                $row_output [] = $this->_row($sub_of->subject->subject_rate . ' / ' . ($sub_of->subject->subject_rate * $unit), $row_count);
                                $row_output [] = $status_return($stud_sub->student_subject_enroll_status, $return_html, $row_count);


                                $subject_offers[] = $row_output;
                                if ($row_count === 2)// if there a second sched
                                {
                                        $tmp = array();
                                        foreach ($sched2 as $v)
                                        {
                                                $tmp[] = $v;
                                        }
                                        $subject_offers[] = $tmp;
                                }
                        }
                        if ($return_type === 'object')
                        {
                                return (object) $subject_offers;
                        }
                        if ($return_type === 'array')
                        {
                                return $subject_offers;
                        }
                }
//                $col_count = 14;
//                if ($sort_)
//                {
//                        $col_count = count($sort_);
//                }
                return array(array(array('data' => 'no data', 'colspan' => '14', 'class' => 'taskStatus')));
        }

        private function _row($data, $row_span, $attrib = FALSE)
        {
                if ($attrib)
                {
                        if ($row_span > 1)
                        {
                                return array_merge(array('data' => $data, 'rowspan' => "$row_span"), $attrib);
                        }
                        return array_merge(array('data' => $data), $attrib);
                }
                if ($row_span > 1)
                {
                        return array('data' => $data, 'rowspan' => "$row_span");
                }
                return $data;
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

        private function _get_registered_subject_offers()
        {
                $tmp    = $this->Students_subjects_model->
                        fields('subject_offer_id')->
                        where(array(
                            'enrollment_id' => $this->__enrollment->enrollment_id
                        ))->
                        //set_cache()->
                        get_all();
                $return = array();
                if ($tmp)
                {
                        foreach ($tmp as $v)
                        {
                                $return[] = $v->subject_offer_id;
                        }
                }
                return $return;
        }

        /**
         * 
         * @return type
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function get_all_subject_available_to_enroll()
        {

                $subject_offer_ids = $this->_get_registered_subject_offers();
                // return $this->__curriculum_subjects();
                $obj               = $this->Curriculum_subject_model->
                        fields('subject_id')->
                        order_by('curriculum_subject_semester,curriculum_subject_year_level')->
                        where(array(
                            'curriculum_id' => $this->__curriculum->curriculum_id
                        ))->
                        //set_cache()->
                        get_all();
                $return            = array();
                if ($obj)
                {
                        foreach ($obj as $s)
                        {
                                $tmp = $this->Subject_offer_model->
                                        with_subject('fields:subject_code,subject_description'/* ,subject_rate' */)->
                                        with_faculty('fields:first_name,last_name')->
                                        with_subject_line(array(
                                            'fields' =>
                                            'subject_offer_line_start,' .
                                            'subject_offer_line_end,' .
                                            'subject_offer_line_monday,' .
                                            'subject_offer_line_tuesday,' .
                                            'subject_offer_line_wednesday,' .
                                            'subject_offer_line_thursday,' .
                                            'subject_offer_line_friday,' .
                                            'subject_offer_line_saturday,' .
                                            'subject_offer_line_sunday',
                                            'with'   => array(//sub query of sub query
                                                'relation' => 'room',
                                                'fields'   => 'room_number,room_capacity'
                                            )
                                        ))->
                                        where(array(
                                            'subject_id'                => $s->subject_id,
                                            'subject_offer_semester'    => current_school_semester(TRUE),
                                            'subject_offer_school_year' => current_school_year()
                                        ))->
                                        // set_cache()->
                                        get_all();
                                if ($tmp)
                                {
                                        foreach ($tmp as $v)
                                        {
                                                if ( ! in_array($v->subject_offer_id, $subject_offer_ids))
                                                {
                                                        if ($this->_check_requisite($v->subject_offer_id))
                                                        {
                                                                $return[] = $v;
                                                        }
                                                }
                                        }
                                }
                        }
                }
                return $return;
        }

        private function _check_requisite($subj_offr_id)
        {

                //get all pre-requsite of $subj_offr_id
                //-
                //check the requsite if done then return TRUE [pre]
                //
                return TRUE;
        }

        public function get_all_term_units()
        {
                $cur_subj_obj = $this->Curriculum_subject_model->curriculum_subjects($this->__curriculum->curriculum_id);
                $return       = array();
                if ($cur_subj_obj)
                {
                        $tmp_compare = '';
                        foreach ($cur_subj_obj as $cur_subj)
                        {
                                $tmp_sem_year = $cur_subj->curriculum_subject_year_level . $cur_subj->curriculum_subject_semester;
                                if ($tmp_compare != $tmp_sem_year)
                                {
                                        $tmp_compare = $tmp_sem_year;
                                        $sem         = $cur_subj->curriculum_subject_semester;
                                        $level       = $cur_subj->curriculum_subject_year_level;
                                        $total_units = $this->Curriculum_subject_model->total_units_per_term($cur_subj->curriculum_id, $sem, $level);
                                        $return[]    = (object) array(
                                                    'sem'   => $sem,
                                                    'level' => $level,
                                                    'unit'  => $total_units
                                        );
                                }
                        }
                }
                return (object) $return;
        }

        public function enrolled_units($int = FALSE, $enroll_only = TRUE)
        {
                $obj = $this->Students_subjects_model->
                        fields('curriculum_subject_id')->
                        with_curriculum_subject()->
                        where(array(
                    'student_subject_semester'    => current_school_semester(TRUE),
                    'student_subject_school_year' => current_school_year(),
                    'enrollment_id'               => $this->__enrollment->enrollment_id
                ));
                if ($enroll_only)
                {
                        $obj->where(array(
                            'student_subject_enroll_status' => TRUE
                        ));
                }
                $obj   = $obj->
                        //set_cache()->
                        get_all();
                $units = 0;
                if ($obj)
                {
                        foreach ($obj as $v)
                        {
                                $units += (int) $this->Curriculum_subject_model->get_unit(NULL, $v->curriculum_subject->curriculum_id, $v->curriculum_subject->subject_id);
                        }
                }
                if ($int)
                {
                        return $units;
                }

                $this->load->helper('inflector');
                $tmp = 'Unit';
                return $units . ' ' . (($units > 1) ? plural($tmp) : $tmp);
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
        protected $__curriculum;

        // private $_curriculum_subjects__subject_offers;

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
                $this->__course = $this->__enrollment->course;
                /**
                 * set curriculum_id
                 */
                // $this->_curriculum_subjects__subject_offers = $this->Subject_offer_model->all(TRUE, $this->__enrollment->curriculum_id, $this->__enrollment->enrollment_id); //parameter is set to current semester and year
        }

        protected function __load_education()
        {
                $this->__education = $this->Education_model->
                        set_cache('student_library_load_education_' . $this->__course->education_id)->
                        get(array(
                    'education_id' => $this->__course->education_id
                ));
        }

        protected function __load_curriculum()
        {
                $this->__curriculum = $this->Enrollment_model->with_curriculum()->get($this->__enrollment->enrollment_id)->curriculum;
        }

        protected function __students_subjects($current_term_year = TRUE)
        {
                $obj = $this->Students_subjects_model->
                        where(array(
                            'enrollment_id' => $this->__enrollment->enrollment_id
                        ))->
                        //set_cache('student_library_students_subjects_' . $this->__enrollment->enrollment_id . '_limit_' . $limit . '_offset_' . $offset)->
                        set_cache('student_library_students_subjects_' . $this->__enrollment->enrollment_id);


                if ($current_term_year)
                {
                        $obj->where(array(
                            'student_subject_semester'    => current_school_semester(TRUE),
                            'student_subject_school_year' => current_school_year()
                        ));
                }
                return $obj->order_by('student_subject_school_year,student_subject_semester')->get_all();
        }

        /**
         * filter with level of current student
         * 
         * @return array
         */
//        protected function __curriculum_subjects($add_level = 0)//parameter will use in recursive call
//        {
//                $level  = (int) $this->__enrollment->enrollment_year_level;
//                $level  += $add_level;
//                $return = array();
//                if ($this->_curriculum_subjects__subject_offers)
//                {
//                        foreach ($this->_curriculum_subjects__subject_offers as $s)
//                        {
//
//                                if (isset($s->student_subjects->enrollment_id))
//                                {
//                                        // i made an issue for this
//                                        //https://github.com/avenirer/CodeIgniter-MY_Model/issues/231
//                                        //this is temporary,(if fixed will refactor)
//                                        if ($s->student_subjects->enrollment_id == $this->__enrollment->enrollment_id)//i set to not != so check if exist then skip
//                                        {
//
//                                                continue;
//                                        }
//                                }
//
//
//                                // if ($level == $s->curriculum_subject->curriculum_subject_year_level)
//                                // {
//                                $return[] = $s;
//                                // }
//                        }
//                }
//                return $return;
//        }
}
