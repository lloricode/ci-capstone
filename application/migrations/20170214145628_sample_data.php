<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
class Migration_Sample_data extends CI_Migration
{


        private $user_ids;
        private $education_ids;
        private $course_ids;
        private $subject_ids;
        private $enrollment_ids;
        private $room_ids;
        private $subject_offer_ids;
        private $randnum;

        public function __construct($config = array())
        {
                parent::__construct($config);
                $this->load->helper(array('array', 'string'));
                $this->load->model(array(
                    'Student_model',
                    'Enrollment_model',
                    'Course_model',
                    'Education_model',
                    'Students_subjects_model',
                    'Subject_offer_model',
                    'Subject_model',
                    'Room_model',
                    'User_model'
                ));
                $this->load->library('school_id');
        }

        public function up()
        {
                $this->randnum = array(
                    1, 2, 3, 4, 5
                );

                $this->users();
                $this->enrollment_ids = array();
                $this->education();
                $this->course();
                $this->subjects();
                $this->rooms();
                $this->subject_offer();
                for ($i = 1; $i <= 90; $i++)
                {

                        $this->school_id->initialize();
                        $this->enrollment_ids[] = $this->student($this->school_id->generate(), $i);
                }

                $this->student_subjects();
        }

        private function users()
        {
                for ($i = 1; $i <= 80; $i++)
                {
                        $identity = 'username' . $i;
                        $password = 'password';
                        $email    = strtolower('email' . random_string('alpha', random_element(array(3, 4, 5)))) . $i . '@gmail.com';

                        $additional_data = array(
                            'first_name' => ucwords(strtolower('first' . random_string('alpha', random_element($this->randnum)))),
                            'last_name'  => ucwords(strtolower('last' . random_string('alpha', random_element($this->randnum)))),
                            'company'    => ucwords(strtolower('company' . random_string('alpha', random_element($this->randnum)))),
                            'phone'      => '+639' . random_string('numeric', 2) . '-' . random_string('numeric', 3) . '-' . random_string('numeric', 4),
                        );
                        $u_id            = $this->ion_auth->register($identity, $password, $email, $additional_data);
                        if (!$u_id)
                        {
                                show_error('failed insert user in (' . $i . ') times error:' . $this->ion_auth->errors());
                        }
                        $this->user_ids[] = $u_id;
                }
        }

        private function student_subjects()
        {
                $students_subjects_model_arr = array();

                /**
                 * lets make random enroll subject in all student with dynamically subject count
                 */
                $how_many_subject = array(2, 4, 6, 8, 23, 34, 56);

                /**
                 * add subject all enroll ids
                 */
                foreach ($this->enrollment_ids as $e_id)
                {
                        /**
                         * select subject offer first with how many
                         */
                        $subjects_ofr_ids = array();
                        for ($i = 1; $i <= random_element($how_many_subject); $i++)
                        {
                                $s_offr = random_element($this->subject_offer_ids);
                                if (!in_array($s_offr, $subjects_ofr_ids))
                                {
                                        $subjects_ofr_ids[] = $s_offr;
                                }
                                else
                                {
                                        /**
                                         * repeat
                                         * then minus loop
                                         */
                                        $i--;
                                }
                        }
                        /**
                         * then add subject 
                         */
                        foreach ($subjects_ofr_ids as $s_o_id)
                        {
                                $students_subjects_model_arr[] = array(
                                    'enrollment_id'    => $e_id,
                                    'subject_offer_id' => $s_o_id,
                                    'created_user_id'  => random_element($this->user_ids)
                                );
                        }
                }

                if (!$this->Students_subjects_model->insert($students_subjects_model_arr))
                {
                        show_error('failed add student subjects');
                }
        }

        private function subject_offer()
        {
                $subj_offr_arr = array();


                for ($i = 1; $i <= 80; $i++)
                {
                        $subj_offr_arr[] = array(
                            'subject_offer_start'     => 'starttest' . $i,
                            'subject_offer_end'       => 'endtest' . $i,
                            //days
                            'subject_offer_monday'    => random_element(array(TRUE, FALSE)),
                            'subject_offer_tuesday'   => random_element(array(TRUE, FALSE)),
                            'subject_offer_wednesday' => random_element(array(TRUE, FALSE)),
                            'subject_offer_thursday'  => random_element(array(TRUE, FALSE)),
                            'subject_offer_friday'    => random_element(array(TRUE, FALSE)),
                            'subject_offer_saturday'  => random_element(array(TRUE, FALSE)),
                            'subject_offer_sunday'    => random_element(array(TRUE, FALSE)),
                            //==
                            'user_id'                 => random_element($this->user_ids),
                            'subject_id'              => random_element($this->subject_ids),
                            'room_id'                 => random_element($this->room_ids),
                            //--
                            'created_user_id'         => random_element($this->user_ids)
                        );
                }

                $this->subject_offer_ids = $this->Subject_offer_model->insert($subj_offr_arr);
        }

        private function rooms()
        {
                $room_arr = array();

                $dplicate1 = 1;
                $dplicate2 = 'A';
                for ($i = 1; $i <= 80; $i++)
                {
                        $room_arr[] = array(
                            'room_number'      => 'Room' . $dplicate1++,
                            'room_description' => 'Roomdesc' . $dplicate2++,
                            'created_user_id'  => random_element($this->user_ids)
                        );
                }

                $this->room_ids = $this->Room_model->insert($room_arr);
        }

        private function subjects()
        {
                $subject_arr = array();

                $dplicate1 = 1;
                $dplicate2 = 'A';
                for ($i = 1; $i <= 80; $i++)
                {
                        $subject_arr[] = array(
                            'subject_code'        => 'Subjcode' . $dplicate1++,
                            'subject_description' => 'Subdesc' . $dplicate2++,
                            'subject_unit'        => random_element(array(1, 2, 3, 4)),
                            'course_id'           => random_element($this->course_ids),
                            'created_user_id'     => random_element($this->user_ids)
                        );
                }

                $this->subject_ids = $this->Subject_model->insert($subject_arr);
        }

        private function education()
        {
                $education_arr = array();

                $dplicate1 = 1;
                $dplicate2 = 'A';
                for ($i = 1; $i <= 7; $i++)
                {
                        $education_arr[] = array(
                            'education_code'        => 'Educode' . $dplicate1++,
                            'education_description' => 'Edudesc' . $dplicate2++,
                            'created_user_id'       => random_element($this->user_ids)
                        );
                }
                $this->education_ids = $this->Education_model->insert($education_arr);
        }

        private function course()
        {
                $course_arr = array();
                $dplicate1  = 1;
                $dplicate2  = 'A';
                for ($i = 1; $i <= 15; $i++)
                {
                        $course_arr[] = array(
                            'course_code'        => 'Coursecode' . $dplicate1++,
                            'course_description' => 'Cousedesc' . $dplicate2++,
                            'education_id'       => random_element($this->education_ids),
                            'created_user_id'    => random_element($this->user_ids)
                        );
                }

                $this->course_ids = $this->Course_model->insert($course_arr);
        }

        /**
         * 
         * @param type $school_id
         * @param type $inc
         * @return int enrollment_id
         */
        private function student($school_id, $inc)
        {
                $enrollment_id = NULL;

                $image = array(
                    'one.jpg',
                    'two.jpg',
                    'three.jpeg',
                    'four.jpg'
                );
                $mm    = array();
                $dd    = array();
                $yyyy  = array();
                for ($i = 1; $i <= 12; $i++)
                {

                        if ($i < 10)
                        {
                                $mm[] = '0' . $i;
                        }
                        else
                        {
                                $mm[] = $i;
                        }
                }
                for ($i = 1; $i <= 31; $i++)
                {
                        if ($i < 10)
                        {
                                $dd[] = '0' . $i;
                        }
                        else
                        {
                                $dd[] = $i;
                        }
                }
                for ($i = 1985; $i <= 1998; $i++)
                {
                        $yyyy[] = $i;
                }
                $student__ = array(
                    'student_image'                   => 'test/' . random_element($image),
                    'student_firstname'               => ucwords(strtolower('first' . random_string('alpha', random_element($this->randnum)))),
                    'student_middlename'              => ucwords(strtolower('middle' . random_string('alpha', random_element($this->randnum)))),
                    'student_lastname'                => ucwords(strtolower('last' . random_string('alpha', random_element($this->randnum)))),
                    'student_school_id'               => $school_id,
                    'student_gender'                  => random_element(array('Male', 'Female')),
                    'student_permanent_address'       => ucwords(strtolower('address' . random_string('alpha', random_element($this->randnum)))),
                    'student_birthdate'               => random_element($mm) . '-' . random_element($dd) . '-' . random_element($yyyy),
                    'student_birthplace'              => ucwords(strtolower('birthplace' . random_string('alpha', random_element($this->randnum)))),
                    'student_civil_status'            => random_element(array('Single', 'Meriagge')),
                    'student_nationality'             => random_element(array('Filipino', 'Americano')),
                    //==
                    'student_guardian_fullname'       => ucwords(strtolower('guarfullname' . random_string('alpha', random_element($this->randnum)))),
                    'student_address_town'            => ucwords(strtolower('town' . random_string('alpha', random_element($this->randnum)))),
                    'student_address_region'          => ucwords(strtolower('region' . random_string('alpha', random_element($this->randnum)))),
                    'student_guardian_address'        => ucwords(strtolower('guaraddrr' . random_string('alpha', random_element($this->randnum)))),
                    'student_personal_contact_number' => '+639' . random_string('numeric', 2) . '-' . random_string('numeric', 3) . '-' . random_string('numeric', 4),
                    'student_guardian_contact_number' => '+639' . random_string('numeric', 2) . '-' . random_string('numeric', 3) . '-' . random_string('numeric', 4),
                    'student_personal_email'          => strtolower(random_string('alpha', random_element($this->randnum))) . $inc . '@gmail.com',
                    'student_guardian_email'          => strtolower(random_string('alpha', random_element($this->randnum))) . $inc . '@gmail.com',
                    /**
                     * who add the data
                     */
                    'created_user_id'                 => random_element($this->user_ids)
                );


                /**
                 * inserting to student to database, then will return a primary if on success
                 */
                $returned_student_id = $this->Student_model->insert($student__);

                /**
                 * check if id is ready
                 * else nothing to do
                 */
                if ($returned_student_id)
                {
                        /**
                         * preparing data into array
                         */
                        $enrollmet__ = array(
                            'student_id'             => $returned_student_id,
                            'course_id'              => random_element($this->course_ids),
                            'enrollment_school_year' => random_element(array('2015-2017', '2016-2017', '2017-2018')),
                            'enrollment_semester'    => random_element(array('First', 'Second', 'Summer')),
                            'enrollment_year_level'  => random_element(array(1, 2, 3, 4)),
                            'enrollment_status'      => random_element(array(TRUE, FALSE)),
                            /**
                             * who add the data
                             */
                            'created_user_id'        => random_element($this->user_ids)
                        );

                        /**
                         * get education by course id
                         */
                        /**
                         * on success will redirect in current page, to clear input
                         * 
                         * else on failed
                         * exist student id will delete from student table to rollback data
                         */
                        $enrollment_id = $this->Enrollment_model->insert($enrollmet__);
                        if (!$enrollment_id)
                        {
                                /**
                                 * deleting student
                                 */
                                if ($this->Student_model->delete($returned_student_id))
                                {

                                        //repeat /recursive
                                        $this->student($school_id, $inc);
                                }
                                else
                                {
                                        show_error('migration failed, in (' . $inc . ') times, kindly fix me, -Lloric');
                                }
                        }
                }
                return $enrollment_id;
        }

        public function down()
        {
                
        }

}
