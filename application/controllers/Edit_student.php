<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_student extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_students');
                $this->load->library(array('form_validation', 'student'));
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
                $this->breadcrumbs->unshift(2, lang('index_student_heading'), 'students');
                $this->load->model(array('Student_model', 'Enrollment_model'));
                /**
                 * preparing configuration for image upload
                 *
                 * load upload library including configuration for upload
                 */
                $this->load->library('upload', $this->Student_model->image_config());
        }

        public function index()
        {
                $this->student->get($this->input->get('student-id'));
                $this->breadcrumbs->unshift(3, 'Edit Student [ ' . $this->student->school_id . ' ]', 'edit-student?student-id=' . $this->student->id);


                $__post_button    = (bool) $this->input->post('submit');
                $_post_image_name = 'image';

                $image_error_message = '';

                if ($__post_button)
                {
                        /**
                         * preparing image
                         */
                        $upload_return       = $this->upload->_preparing_image($_post_image_name, FALSE);
                        $uploaded            = $upload_return['uploaded'];
                        $image_error_message = $upload_return['error_message'];
                        $this->_input_ready($this->student->id, $uploaded);
                }

                /**
                 * no need use else, because when submit success is redirecting to other controller,
                 */
                $this->_form_view($image_error_message, $_post_image_name);
        }

        public function email_personal()
        {
                if (!(bool) $this->input->post('submit'))
                {
                        show_error('Invalid request.');
                }
                $row = 0;
                if ($this->student->email != $this->input->post('personal_email', TRUE))
                {
                        $row = $this->Student_model->where(array(
                                    'student_personal_email' => $this->input->post('personal_email', TRUE)
                                ))->count_rows();
                }
                $this->form_validation->set_message('email_personal', 'Already in used.');
                return (bool) ($row == 0);
        }

        public function email_guardian()
        {
                if (!(bool) $this->input->post('submit'))
                {
                        show_error('Invalid request.');
                }
                $row = 0;
                if ($this->student->email != $this->input->post('personal_email', TRUE))
                {
                        $row = $this->Student_model->where(array(
                                    'student_guardian_email' => $this->input->post('guardian_email', TRUE)
                                ))->count_rows();
                }
                $this->form_validation->set_message('email_guardian', 'Already in used.');
                return (bool) ($row == 0);
        }

        private function _input_ready($student_id, $uploaded)
        {
                /**
                 * preparing the image name from uploading image
                 */
                $img_name = (string) $this->upload->data('file_name');


                /**
                 * include image if has (because it is not required in update)
                 */
                $additional_values_in_student = array(
                    'updated_user_id' => $this->session->userdata('user_id')
                );
                if ($img_name)
                {
                        $additional_values_in_student['student_image'] = $img_name;
                }
                /**
                 * start the DB transaction
                 */
                $this->db->trans_start();

                /**
                 * update directly from forms
                 */
                //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::start

                $s_affected_rows = $this->Student_model->from_form(NULL, $additional_values_in_student, array(
                            'student_id' => $this->student->id
                        ))->update();

                $e_affected_rows = $this->Enrollment_model->from_form(NULL, array(
                            'updated_user_id' => $this->session->userdata('user_id')
                                ), array(
                            'enrollment_id' => $this->student->enrollment_id
                        ))->update();
                //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::end

                /**
                 * checking if one of the update is failed, either in [form validation] or in [syntax error] or [upload]
                 */
                if (!$s_affected_rows || !$e_affected_rows || !$uploaded)
                {
                        /**
                         * rollback database
                         */
                        $this->db->trans_rollback();
                        if ($uploaded)
                        {/**
                         * check if user has new image, then remove the old image
                         */
                                if ($img_name)
                                {

                                        /**
                                         * remove the uploaded image
                                         */
                                        unlink($this->config->item('student_image_dir') . $img_name);
                                }
                        }
                }
                else
                {
                        if ($this->db->trans_commit())
                        {
                                /**
                                 * check if user has new image, then remove the old image
                                 */
                                if ($img_name)
                                {
                                        /**
                                         * prepare the image directory,then check file if exist
                                         */
                                        $old_img = $this->config->item('student_image_dir') . $this->student->image;

                                        if (file_exists($old_img))
                                        {
                                                /**
                                                 * remove the old image
                                                 */
                                                unlink($old_img);
                                        }
                                }
                                redirect(site_url('students/view?student-id=' . $this->student->id), 'refresh');
                        }
                }
        }

        private function _form_view($image_error_message, $_post_image_name)
        {
                /**
                 * if reach here, load the model, etc...
                 */
                $this->load->model('Course_model');
                $this->load->helper(array('combobox', 'school'));


                $this->data['message'] = $image_error_message;

                $this->data['student_image'] = array(
                    'name' => $_post_image_name,
                    'type' => 'file',
                    'lang' => 'create_student_image_label'
                );

                $this->data['student_firstname']  = array(
                    'name'  => 'firstname',
                    'value' => $this->form_validation->set_value('firstname', $this->student->firstname),
                    'type'  => 'text',
                    'lang'  => 'create_student_firstname_label'
                );
                $this->data['student_middlename'] = array(
                    'name'  => 'middlename',
                    'value' => $this->form_validation->set_value('middlename', $this->student->middlename),
                    'type'  => 'text',
                    'lang'  => 'create_student_middlename_label'
                );

                $this->data['student_lastname'] = array(
                    'name'  => 'lastname',
                    'value' => $this->form_validation->set_value('lastname', $this->student->lastname),
                    'type'  => 'text',
                    'lang'  => 'create_student_lastname_label'
                );
//
//                $this->data['student_school_id'] = array(
//                    'student_school_id' => $this->school_id->generate()
//                );


                $this->data['student_gender'] = array(
                    'name'   => 'gender',
                    'fields' => array(//we used radio here 
                        'female' => lang('gender_female_label'),
                        'male'   => lang('gender_male_label')
                    ),
                    'value'  => $this->form_validation->set_value('gender', $this->student->gender),
                    'type'   => 'radio',
                    'lang'   => 'create_student_gender_label'
                );


                $this->data['student_birthdate'] = array(
                    'name'             => 'birthdate',
                    'data-date-format' => 'mm-dd-yyyy',
                    'class'            => 'zpicker',
                    'value'            => $this->form_validation->set_value('birthdate', $this->student->birthdate),
                    'type'             => 'text',
                    'lang'             => 'create_student_birthdate_label'
                );



                $this->data['student_birthplace'] = array(
                    'name'  => 'birthplace',
                    'value' => $this->form_validation->set_value('birthplace', $this->student->birthplace),
                    'type'  => 'text',
                    'lang'  => 'create_student_birthplace_label'
                );

                $this->data['student_civil_status'] = array(
                    'name'  => 'status',
                    'value' => $this->form_validation->set_value('status', $this->student->civil_status),
                    'type'  => 'text',
                    'lang'  => 'create_student_civil_status_label'
                );

                $this->data['student_nationality'] = array(
                    'name'  => 'nationality',
                    'value' => $this->form_validation->set_value('nationality', $this->student->nationality),
                    'type'  => 'text',
                    'lang'  => 'create_student_nationality_label'
                );



                $this->data['student_permanent_address'] = array(
                    'name'  => 'address',
                    'value' => $this->form_validation->set_value('address', $this->student->address),
                    'type'  => 'textarea',
                    'lang'  => 'create_group_name_label'
                );
                $this->data['student_school_id_temp']    = array(
                    'name'     => 'id_temp',
                    'disabled' => '',
                    'value'    => $this->student->school_id,
                    'type'     => 'text',
                    'lang'     => 'create_student_school_id_label'
                );



                //++++++++++++++++++++++++++++++++++++++=
                $this->data['student_guardian_fullname'] = array(
                    'name'  => 'guardian_fullname',
                    'value' => $this->form_validation->set_value('guardian_fullname', $this->student->guardian_fullname),
                    'type'  => 'text',
                    'lang'  => 'create_student_guardian_fullname_label'
                );


                $this->data['student_address_town'] = array(
                    'name'  => 'town',
                    'value' => $this->form_validation->set_value('town', $this->student->town),
                    'type'  => 'text',
                    'lang'  => 'create_student_town_label'
                );



                $this->data['student_address_region'] = array(
                    'name'  => 'region',
                    'value' => $this->form_validation->set_value('region', $this->student->region),
                    'type'  => 'text',
                    'lang'  => 'create_student_region_label'
                );



                $this->data['student_guardian_address'] = array(
                    'name'  => 'guardian_address',
                    'value' => $this->form_validation->set_value('guardian_address', $this->student->guardian_adrress),
                    'type'  => 'textarea',
                    'lang'  => 'create_student_guardian_address_label'
                );



                $this->data['student_personal_contact_number'] = array(
                    'name'  => 'ontact_number',
                    'value' => $this->form_validation->set_value('ontact_number', $this->student->contact),
                    'type'  => 'text',
                    'lang'  => 'create_student_personal_contact_label'
                );



                $this->data['student_guardian_contact_number'] = array(
                    'name'  => 'guardian_contact_number',
                    'value' => $this->form_validation->set_value('guardian_contact_number', $this->student->guardian_contact),
                    'type'  => 'text',
                    'lang'  => 'create_student_guardian_contact_label'
                );



                $this->data['student_personal_email'] = array(
                    'name'  => 'personal_email',
                    'value' => $this->form_validation->set_value('personal_email', $this->student->email),
                    'type'  => 'text',
                    'lang'  => 'create_student_personal_email_label'
                );


                $this->data['student_guardian_email'] = array(
                    'name'  => 'guardian_email',
                    'value' => $this->form_validation->set_value('guardian_email', $this->student->guardian_email),
                    'type'  => 'text',
                    'lang'  => 'create_student_guardian_email_label'
                );

                /**
                 * enrollment inputs
                 */
                $this->data['course_id']              = array(
                    'name'    => 'courseid',
                    'default' => $this->student->course_id,
                    'value'   => $this->Course_model->
                            as_dropdown('course_code')->
                            set_cache('as_dropdown_course_code')->
                            get_all(),
                    'type'    => 'dropdown',
                    'lang'    => 'create_course_label'
                );
                $this->data['enrollment_year_level']  = array(
                    'name'    => 'level',
                    'default' => $this->student->level,
                    'value'   => _numbers_for_drop_down(0, $this->config->item('max_year_level')),
                    'type'    => 'dropdown',
                    'lang'    => 'create_student_year_level_label'
                );
                $this->data['enrollment_semester']    = array(
                    'name'    => 'semester',
                    'default' => $this->student->semester,
                    'value'   => semesters(),
                    'type'    => 'dropdown',
                    'lang'    => 'create_student_semester_label'
                );
                $this->data['enrollment_school_year'] = array(
                    'name'    => 'school_year',
                    'default' => $this->student->school_year,
                    'value'   => school_years($this->student->school_year),
                    'type'    => 'dropdown',
                    'lang'    => 'create_student_school_year_label'
                );
                /**
                 * redering
                 */
                $this->data['bootstrap']              = $this->_bootstrap();
                $this->_render('admin/edit_student', $this->data);
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap()
        {
                /**
                 * for header
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/fullcalendar.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'css/jquery.gritter.css',
                        'css/jquery.gritter.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/bootstrap-colorpicker.js',
                        'js/bootstrap-datepicker.js',
                        'js/jquery.toggle.buttons.js',
                        'js/masked.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/matrix.js',
                        'js/matrix.form_common.js',
                        'js/wysihtml5-0.3.0.js',
                        'js/jquery.peity.min.js',
                        'js/bootstrap-wysihtml5.js',
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '<script type="text/javascript">
        // This function is called from the pop-up menus to transfer to
        // a different page. Ignore if the value returned is a null string:
        function goPage(newURL) {

            // if url is empty, skip the menu dividers and reset the menu selection to default
            if (newURL != "") {

                // if url is "-", it is this page -- reset the menu:
                if (newURL == "-") {
                    resetMenu();
                }
                // else, send page to designated URL            
                else {
                    document.location.href = newURL;
                }
            }
        }

        // resets the menu selection upon entry to this page:
        function resetMenu() {
            document.gomenu.selector.selectedIndex = 2;
        }
</script>';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
