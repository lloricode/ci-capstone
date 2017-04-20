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
        private $permission_ids;
        private $controller_ids;
        //---
        private $user_count;
        private $student_count;
        //private $educaton_count;
        private $subject_offer_count;
        private $room_count;
        private $subject_count;
        //private $courses_count;
        private $enable;

        public function __construct($config = array())
        {
                parent::__construct($config);
                /**
                 * set this TRU if you want to enable
                 */
                $this->enable              = TRUE;
                /**
                 * set counts
                 */
                /**
                 * this will be use if you set enable for migration sample data  |>>>> $this->enable = FALSE;
                 */
                $this->user_count          = 5;
                $this->student_count       = 0;
                //$this->educaton_count      = 1000;
                $this->subject_offer_count = 0;
                $this->room_count          = 0;
                $this->subject_count       = 0;
                //$this->courses_count       = 1000;

                /**
                 * loading needed files
                 */
                $this->load->library(array('school_id', 'subject_offer_validation'));
                $this->load->helper(array('array', 'string', 'navigation', 'time', 'day'));
                $this->load->model(array(
                    'Student_model',
                    'Enrollment_model',
                    'Course_model',
                    'Education_model',
                    'Students_subjects_model',
                    'Subject_offer_model',
                    'Subject_model',
                    'Room_model',
                    'User_model',
                    'Permission_model',
                    'Controller_model'
                ));
                $this->user_ids = array();
                if ( ! $this->user_count)
                {
                        $this->user_ids[] = 1;
                }
        }

        public function up()
        {

                if ($this->enable)
                {
                        $this->randnum        = array(
                            1, 2, 3, 4, 5
                        );
                        $this->users();
                        $this->enrollment_ids = array();
                        $this->education();
                        $this->course();
                        $this->subjects();
                        $this->rooms();
                        $this->subject_offer();
                        for ($i = 1; $i <= $this->student_count; $i ++ )
                        {

                                $this->school_id->initialize();
                                $this->enrollment_ids[] = $this->student($this->school_id->generate(), $i);
                        }

                        $this->student_subjects();
                }
                $this->controllers();
                $this->permission();
        }

        private function controllers()
        {
                $data_con_arr = array();

                foreach (controllers__() as $k => $v)
                {
                        $tmp = array(
                            'controller_name'        => $k,
                            'controller_description' => ucwords(str_replace('-', ' ', $k)) . ' Description',
                        );
                        if (isset($v['admin']))
                        {
                                if ((bool) $v['admin'])
                                {
                                        $tmp['controller_admin_only'] = TRUE;
                                }
                        }
                        if (isset($v['enrollment']))
                        {
                                if ((bool) $v['enrollment'])
                                {
                                        $tmp['controller_enrollment_open'] = TRUE;
                                }
                        }

                        $data_con_arr[] = $tmp;
                }
                $data_con_arr[] = array(
                    'controller_name'        => '',
                    'controller_description' => 'Default Controller Description',
                );
                if ($data_con_arr)
                {
                        $this->controller_ids = $this->Controller_model->insert($data_con_arr);
                }
        }

        private function permission()
        {
                $per_arr = array();
                foreach ($this->controller_ids as $v)
                {
                        $per_arr[] = array(
                            'controller_id' => $v,
                            'group_id'      => 1,
                        );
                }
                if ($per_arr)
                {
                        $this->permission_ids = $this->Permission_model->insert($per_arr);
                }
        }

        private function users()
        {
                for ($i = 1; $i <= $this->user_count; $i ++ )
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
                        if ( ! $u_id OR $u_id < 1)
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
                 * add subject all enroll ids
                 */
                foreach ($this->enrollment_ids as $e_id)
                {
                        /**
                         * lets make random enroll subject in all student with dynamically subject count
                         */
                        $how_many_subject = random_string('numeric', 2);
                        /**
                         * select subject offer first with how many
                         */
                        $subjects_ofr_ids = array();
                        for ($i = 1; $i <= $how_many_subject; $i ++ )
                        {
                                $s_offr = random_element($this->subject_offer_ids);
                                if ( ! in_array($s_offr, $subjects_ofr_ids))
                                {
                                        $subjects_ofr_ids[] = $s_offr;
                                }
                                else
                                {
                                        /**
                                         * repeat
                                         * then minus loop
                                         */
                                        $i --;
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
                if ($students_subjects_model_arr)
                {
                        if ( ! $this->Students_subjects_model->insert($students_subjects_model_arr))
                        {
                                show_error('failed add student subjects');
                        }
                }
        }

        private function subject_offer()
        {
                $subj_offr_arr = array();

                for ($i = 1; $i <= $this->subject_offer_count; $i ++ )
                {
                        $start  = random_element(time_list(FALSE));
                        $t_list = time_list(FALSE, convert_12_to_24hrs($start));
                        /**
                         * remove 1st element (start)
                         */
                        unset($t_list[0]);
                        $end    = convert_12_to_24hrs(random_element($t_list));

                        $sub_ofrr = array(
                            'subject_offer_start'     => convert_12_to_24hrs($start),
                            'subject_offer_end'       => $end,
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

                        /**
                         * check atleast one day
                         */
                        if ($this->atleast_one_day($sub_ofrr))
                        {
                                $i --;
                                continue;
                        }

                        /**
                         * check conflict
                         */
                        if ( ! $this->check_conflict($sub_ofrr))
                        {
                                $i --;
                                continue;
                        }

                        $subj_offr_arr[] = $sub_ofrr;
                }
                if ($subj_offr_arr)
                {
                        $this->subject_offer_ids = $this->Subject_offer_model->insert($subj_offr_arr);
                }
        }

        private function check_conflict($sub_offr)
        {
                $this->subject_offer_validation->init('migrate');
                $this->subject_offer_validation->migrate_test($sub_offr);
                return $this->subject_offer_validation->subject_offer_check_check_conflict();
        }

        private function atleast_one_day($sub_offr)
        {
                foreach (days_for_db() as $d)
                {
                        if ($sub_offr['subject_offer_' . $d])
                        {
                                return TRUE;
                        }
                }
                return FALSE;
        }

        private function rooms()
        {
                $room_arr = array();

                $dplicate1 = 1;
                $dplicate2 = 'A';
                for ($i = 1; $i <= $this->room_count; $i ++ )
                {
                        $room_arr[] = array(
                            'room_number'      => 'Room' . $dplicate1 ++,
                            'room_description' => 'Roomdesc' . $dplicate2 ++,
                            'created_user_id'  => random_element($this->user_ids)
                        );
                }
                if ($room_arr)
                {
                        $this->room_ids = $this->Room_model->insert($room_arr);
                }
        }

        private function subjects()
        {
                $subject_arr = array();

                $dplicate1 = 1;
                $dplicate2 = 'A';
                for ($i = 1; $i <= $this->subject_count; $i ++ )
                {
                        $subject_arr[] = array(
                            'subject_code'        => 'Subjcode' . $dplicate1 ++,
                            'subject_description' => 'Subdesc' . $dplicate2 ++,
                            'subject_unit'        => random_element(array(1, 2, 3, 4)),
                            'course_id'           => random_element($this->course_ids),
                            'created_user_id'     => random_element($this->user_ids)
                        );
                }
                if ($subject_arr)
                {
                        $this->subject_ids = $this->Subject_model->insert($subject_arr);
                }
        }

        private function education()
        {
                $_data = array(
                    array(
                        'code' => 'collge',
                        'desc' => 'College'
                    ),
                    array(
                        'code' => 'high school',
                        'desc' => 'High School'
                    )
                );

                // $education_arr = array();
//                $dplicate1 = 1;
//                $dplicate2 = 'A';
                // for ($i = 1; $i <= $this->educaton_count; $i++)
                $idss = array();
                foreach ($_data as $v)
                {
                        $education_arr = array(
                            'education_code'        => $v ['code'],
                            'education_description' => $v ['desc'],
                            'created_user_id'       => random_element($this->user_ids)
                        );

                        $this->db->insert($this->Education_model->table, $education_arr);
                        $idss[] = $this->db->insert_id();
                }
                if ($_data)
                {
                        $this->education_ids = $idss;
                }
        }

        private function course()
        {
                $educ_collge_id     = $this->Education_model->get(array('education_code' => 'collge'))->education_id;
                $educ_highschool_id = $this->Education_model->get(array('education_code' => 'high school'))->education_id;
                $_data              = array(
                    array(
                        'code'    => 'BEED',
                        'icon'    => 'book',
                        'color'   => 'ly',
                        'desc'    => 'BEED description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '20'
                    ),
                    array(
                        'code'    => 'HRM',
                        'icon'    => 'fire',
                        'color'   => 'ls',
                        'desc'    => 'HRM description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '30'
                    ),
                    array(
                        'code'    => 'Paramedical',
                        'icon'    => 'user-md',
                        'color'   => 'lg',
                        'desc'    => 'Paramedical  description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '40'
                    ),
                    array(
                        'code'    => 'ICT',
                        'icon'    => 'tasks',
                        'color'   => 'lo',
                        'desc'    => 'ICT description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '50'
                    ),
                    array(
                        'code'    => 'High School',
                        'icon'    => 'briefcase',
                        'color'   => 'lb',
                        'desc'    => 'High School Department',
                        'educ'    => $educ_highschool_id,
                        'code_id' => '60'
                    ),
                    array(
                        'code'    => 'AMT',
                        'icon'    => 'beaker',
                        'color'   => 'lv',
                        'desc'    => 'AMT description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '70'
                    ),
                    array(
                        'code'    => 'TESDA',
                        'icon'    => 'group',
                        'color'   => 'ly',
                        'desc'    => 'Tesda Courses',
                        'educ'    => $educ_collge_id,
                        'code_id' => '80'
                    ),
                    array(
                        'code'    => 'CME',
                        'icon'    => 'tint',
                        'color'   => 'ls',
                        'desc'    => 'CME description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '90'
                    ),
                    array(
                        'code'    => 'Cross Enroll',
                        'icon'    => 'move',
                        'color'   => 'lg',
                        'desc'    => 'Cross Enroll description',
                        'educ'    => $educ_collge_id,
                        'code_id' => '01'
                    )
                );
                //   $course_arr         = array();
//                $dplicate1  = 1;
//                $dplicate2  = 'A';
                //for ($i = 1; $i <= $this->courses_count; $i++)
                $idss               = array();
                foreach ($_data AS $v)
                {
                        $course_arr = array(
                            'course_code'        => $v ['code'],
                            'course_icon'        => $v ['icon'],
                            'course_color'       => $v ['color'],
                            'course_description' => $v ['desc'],
                            'education_id'       => $v ['educ'],
                            'course_code_id'     => $v ['code_id'],
                            'created_user_id'    => random_element($this->user_ids)
                        );



                        $this->db->insert($this->Course_model->table, $course_arr);
                        $idss[] = $this->db->insert_id();
                }
                if ($_data)
                {
                        $this->course_ids = $idss;
                }
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
                for ($i = 1; $i <= 12; $i ++ )
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
                for ($i = 1; $i <= 31; $i ++ )
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
                for ($i = 1985; $i <= 1998; $i ++ )
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
                            'enrollment_semester'    => random_element(array('first', 'second', 'summer')),
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
                        if ( ! $enrollment_id)
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
