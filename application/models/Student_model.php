<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'students';
                $this->primary_key = 'student_id';

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
                $this->has_one['user_created']       = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'created_user_id'
                );
                $this->has_one['user_updated']       = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'updated_user_id'
                );
                $this->has_many['students_subjects'] = array(
                    'foreign_model' => 'Students_subjects_model',
                    'foreign_table' => 'students_subjects',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
                $this->has_one['enrollment']         = array(
                    'foreign_model' => 'Enrollment_model',
                    'foreign_table' => 'enrollments',
                    'foreign_key'   => 'student_id',
                    'local_key'     => 'student_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => array_merge($this->_common(), $this->_insert()),
                    'update' => array_merge($this->_common(), $this->_update())
                );
        }

        private function _common()
        {
                return array(
                    'student_firstname'               => array(
                        'label' => lang('index_student_firstname_th'),
                        'field' => 'firstname',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    'student_middlename'              => array(
                        'label' => lang('index_student_middlename_th'),
                        'field' => 'middlename',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    'student_lastname'                => array(
                        'label' => lang('index_student_lastname_th'),
                        'field' => 'lastname',
                        'rules' => 'trim|required|human_name|min_length[1]|max_length[30]',
                    ),
                    'student_gender'                  => array(
                        'label'  => lang('index_student_gender_th'),
                        'field'  => 'gender',
                        'rules'  => 'trim|required|min_length[4]|in_list[male,female]',
                        'errors' => array(
                            'in_list' => 'Invalid value in {field}'
                        )
                    ),
                    'student_birthdate'               => array(
                        'label' => lang('index_student_birthdate_th'),
                        'field' => 'birthdate',
                        'rules' => 'trim|required|regex_match[/^\d{2}[-]\d{2}[-]\d{4}$/]|age_limit[5.90]',
                    ),
                    'student_permanent_address'       => array(
                        'label' => lang('index_student_permanent_address_th'),
                        'field' => 'address',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    'student_birthplace'              => array(
                        'label' => lang('index_student_birthplace_th'),
                        'field' => 'birthplace',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    'student_civil_status'            => array(
                        'label' => lang('index_student_civil_status_th'),
                        'field' => 'status',
                        'rules' => 'trim|required|min_length[3]|max_length[15]',
                    ),
                    'student_nationality'             => array(
                        'label' => lang('index_student_nationality_th'),
                        'field' => 'nationality',
                        'rules' => 'trim|required|min_length[4]|max_length[20]',
                    ),
                    //--
                    'student_guardian_fullname'       => array(
                        'label' => lang('index_student_guardian_fullname_th'),
                        'field' => 'guardian_fullname',
                        'rules' => 'trim|required|min_length[8]|max_length[100]',
                    ),
                    'student_address_town'            => array(
                        'label' => lang('index_student_town_th'),
                        'field' => 'town',
                        'rules' => 'trim|min_length[3]|max_length[30]',
                    ),
                    'student_address_region'          => array(
                        'label' => lang('index_student_region_th'),
                        'field' => 'region',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    'student_guardian_address'        => array(
                        'label' => lang('index_student_guardian_address_th'),
                        'field' => 'guardian_address',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    'student_personal_contact_number' => array(
                        'label' => lang('index_student_personal_contact_th'),
                        'field' => 'ontact_number',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                    'student_guardian_contact_number' => array(
                        'label' => lang('index_student_guardian_contact_th'),
                        'field' => 'guardian_contact_number',
                        'rules' => 'trim|min_length[8]|max_length[100]',
                    ),
                );
        }

        private function _insert()
        {
                return array(
                    //-----email
                    'student_personal_email' => array(
                        'label'  => lang('index_student_personal_email_th'),
                        'field'  => 'personal_email',
                        'rules'  => 'trim|max_length[50]|valid_email' .
                        (( $this->input->post('personal_email', TRUE)) ?
                        '|is_unique[' . $this->table . '.student_personal_email]' : ''),
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                    'student_guardian_email' => array(
                        'label'  => lang('index_student_guardian_email_th'),
                        'field'  => 'guardian_email',
                        'rules'  => 'trim|max_length[50]|valid_email' .
                        (( $this->input->post('guardian_email', TRUE)) ?
                        '|is_unique[' . $this->table . '.student_guardian_email]' : ''),
                        'errors' => array(
                            'is_unique' => 'The {field} already exist.'
                        )
                    ),
                );
        }

        private function _update()
        {
                return array(
                    'student_personal_email' => array(
                        'label' => lang('index_student_personal_email_th'),
                        'field' => 'personal_email',
                        'rules' => 'trim|max_length[50]|valid_email|callback_email_personal'
                    ),
                    'student_guardian_email' => array(
                        'label' => lang('index_student_guardian_email_th'),
                        'field' => 'guardian_email',
                        'rules' => 'trim|max_length[50]|valid_email|callback_email_guardian'
                    ),
                        /**
                         * needs improvement  -- Lloric 2/25/17 1:55am (mardags home)
                         */
//                    'student_personal_email' => array(
//                        'label' => lang('index_student_personal_email_th'),
//                        'field' => 'personal_email',
//                        'rules' => 'trim|max_length[50]|valid_email' .
//                        (($this->student->email != $this->input->post('personal_email', TRUE)) ?
//                        '|is_unique[students.student_personal_email]' : ''),
//                    ),
//                    'student_guardian_email' => array(
//                        'label' => lang('index_student_guardian_email_th'),
//                        'field' => 'guardian_email',
//                        'rules' => 'trim|max_length[50]|valid_email' .
//                        (($this->student->guardian_email != $this->input->post('guardian_email', TRUE)) ?
//                        '|is_unique[students.student_guardian_email]' : ''),
//                    ),
                );
        }

        public function image_config()
        {
                return array(
                    'encrypt_name'  => TRUE,
                    'upload_path'   => $this->config->item('student_image_dir'),
                    'allowed_types' => 'jpg|png|jpeg',
                    'max_size'      => "1000KB",
                    'max_height'    => "1000",
                    'max_width'     => "1000"
                );
        }

        /**
         * after set this, you can now use $this->student->{attributes|functions}
         * 
         * @param int $student_id
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function set_informations($student_id = NULL)
        {
                if ( ! $student_id)
                {
                        show_error('missing parameter in set student information.');
                }
                $this->load->library('student', array($student_id));
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
                $has_image = TRUE;
                if ($image_file_name)
                {
                        list($filename, $extension) = explode('.', $image_file_name);
                }
                else
                {
                        if ( ! $this->student)
                        {
                                /**
                                 * just to make sure student already loaded
                                 */
                                show_error('Student library not set for getting image data.');
                        }
                        $has_image = (bool) $this->student->image;
                        if ($has_image)
                        {
                                list($filename, $extension) = explode('.', $this->student->image);
                        }
                }
                if ($has_image)
                {
                        return (object) array(
                                    'profile' => $this->config->item('student_image_dir') . $this->config->item('student_image_size_profile') . $filename . '_thumb.' . $extension,
                                    'table'   => $this->config->item('student_image_dir') . $this->config->item('student_image_size_table') . $filename . '_thumb.' . $extension
                        );
                }
                else
                {
                        return (object) array(
                                    'profile' => NULL,
                                    'table'   => NULL
                        );
                }
        }

        public function all($limit = NULL, $offset = NULL, $course_id = NULL, $search = NULL, $report = FALSE, $enrolled_status_only = NULL, $is_dean = FALSE)
        {
                $this->_query_all($course_id, $search, $enrolled_status_only, $is_dean);
                $this->db->order_by('enrollment_year_level', 'ASC');
                $this->db->order_by('student_lastname', 'ASC');
                $this->db->order_by('created_at', 'DESC');
                $this->db->order_by('updated_at', 'DESC');
                if ( ! $report)
                {
                        $this->db->limit($limit, $offset);
                }
                $rs     = $this->db->get($this->table);
                $result = $rs->custom_result_object('Student_row');

                $this->db->reset_query();

                $this->_query_all($course_id, $search, $enrolled_status_only, $is_dean);
                $count = $this->db->count_all_results($this->table);

                return (object) array(
                            'result' => $result,
                            'count'  => $count
                );
        }

        private function _query_all($course_id = NULL, $search = NULL, $enrolled_status_only = NULL, $is_dean)
        {

                $this->load->model(array('Enrollment_model', 'Course_model', 'User_model'));

                $enrollment_table       = '`' . $this->Enrollment_model->table . '`';
                $enrollment_primary_key = '`' . $this->Enrollment_model->primary_key . '`';

                $course_table       = '`' . $this->Course_model->table . '`';
                $course_primary_key = '`' . $this->Course_model->primary_key . '`';

                $user_table       = '`' . $this->User_model->table . '`';
                $user_primary_key = '`' . $this->User_model->primary_key . '`';

                $primary_key = '`' . $this->primary_key . '`';
                $table       = '`' . $this->table . '`';

                $str_select_student = '';
                foreach (array('created_at', 'updated_at', 'created_user_id', 'updated_user_id', 'student_id', 'student_school_id', 'student_lastname', 'student_firstname', 'student_middlename', 'student_image') as $v)
                {
                        $str_select_student .= "$table.`$v`,";
                }

                $this->db->select("`u_c`.`id`,`u_c`.`first_name`,`u_c`.`last_name`," . $str_select_student . "$course_table.$course_primary_key,$course_table.`course_code`,$enrollment_table.`enrollment_year_level`,$enrollment_table.`enrollment_status`");
                $this->db->join($enrollment_table, "$enrollment_table.$primary_key=$table.$primary_key");
                $this->db->join($course_table, "$course_table.$course_primary_key=$enrollment_table.$course_primary_key");

                $this->db->join($user_table . ' AS `u_c`', "`u_c`.$user_primary_key=$table.`created_user_id`");
                //$this->db->join($user_table.' AS u_u', "u_u.$user_primary_key=$table.`updated_user_id`");
                if ($course_id)
                {
                        $this->db->where("$course_table.$course_primary_key=", $course_id);
                }
                if ($is_dean)
                {
                        $this->db->group_start();
                }
                if ( ! is_null($search))
                {

                        $this->db->or_like($table . '.`student_school_id`', $search);
                        $this->db->or_like($table . '.`student_lastname`', $search);
                        $this->db->or_like($table . '.`student_firstname`', $search);
                        $this->db->or_like($table . '.`student_middlename`', $search);
                }
                if ($is_dean)
                {
                        $this->db->group_end();
                }
                if ( ! is_null($enrolled_status_only))
                {
                        if ($enrolled_status_only == 'enrolled')
                        {
                                $this->db->where("$enrollment_table.`enrollment_status`=", '1');
                        }
                }
                return $this;
        }

        public function export_excel($course_id, $course_code)
        {
                if (0)//permission
                {
                        show_error('access denied');
                }
                $titles = array(
                    lang('index_student_school_id_th'),
                    lang('index_student_lastname_th'),
                    lang('index_student_firstname_th'),
                    lang('index_student_middlename_th'),
                    //  'course',
                    lang('index_student_year_level_th'),
                    lang('index_student_is_enrolled')
                );

                $student_obj = $this->all(NULL, NULL, $course_id, NULL, TRUE)->result;
                $table_data  = array();

                if ($student_obj)
                {

                        foreach ($student_obj as $student)
                        {
                                $tmp          = array(
                                    ($student->student_school_id == '') ? '--' : $student->student_school_id,
                                    $student->student_lastname,
                                    $student->student_firstname,
                                    $student->student_middlename,
                                    //  my_htmlspecialchars($student->course_code),
                                    my_htmlspecialchars(number_roman($student->enrollment_year_level)),
                                    my_htmlspecialchars(($student->enrollment_status) ? 'yes' : 'no')
                                );
                                $table_data[] = $tmp;
                        }
                }
                $this->load->library('excel');
                // echo print_r($data_);
                $this->excel->filename = 'Stundnts of ' . $course_code;
                $this->excel->make_from_array($titles, $table_data);
        }

}

class Student_row
{


        public $student_id;
        public $student_school_id;
        public $student_lastname;
        public $student_firstname;
        public $student_middlename;
        public $student_image;
        public $enrollment_statu;
        public $course_id;
        public $enrollment_year_level;
        public $course_code;
        public $created_at;
        public $updated_at;
        public $created_user_id;
        public $updated_user_id;

}
