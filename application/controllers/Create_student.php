<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_student extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();

                $this->load->library(array('form_validation', 'school_id'));
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
                $this->lang->load('ci_capstone/ci_students');
                $this->load->helper('school');
                $this->load->model(array('Student_model', 'Enrollment_model'));
                $this->_get_school_id_code();

                $this->breadcrumbs->unshift(2, 'Students', 'students');
                $this->breadcrumbs->unshift(3, 'Enroll Student', 'create-student');


                /**
                 * preparing configuration for image upload
                 *
                 * load upload library including configuration for upload
                 */
                $this->load->library('upload', $this->Student_model->image_config());
        }

        public function index()
        {

                $__post_button    = (bool) $this->input->post('submit');
                $_post_image_name = 'image';

                $image_error_message = '';

                /**
                 * check if the button in POST is triggered
                 */
                if ($__post_button)
                {
                        /**
                         * preparing image
                         */
                        $upload_return       = $this->upload->_preparing_image($_post_image_name);
                        $uploaded            = $upload_return['uploaded'];
                        $image_error_message = $upload_return['error_message'];

                        /**
                         * start the submittion
                         */
                        $this->_input_ready($uploaded);
                }

                /**
                 * no need use else, because when submit success is redirecting to other controller,
                 */
                $this->_form_view($image_error_message, $_post_image_name);
        }

        private function _get_school_id_code($course_id = NULL)
        {
                if (!is_null($course_id))
                {
                        $this->load->model('Course_model');
                        $tmp = $this->Course_model->get($course_id)->course_code_id;

                        $this->school_id->initialize($tmp);
                }
                else
                {
                        $this->school_id->initialize();
                }
        }

        private function _input_ready($uploaded)
        {
                /**
                 * preparing the image name from uploading image
                 */
                $img_name = (string) $this->upload->data('file_name');
                /**
                 * 
                 */
                /**
                 * generating id including code from course
                 */
                $this->_get_school_id_code($this->input->post('courseid', TRUE));


                /**
                 * start the DB transaction
                 */
                $this->db->trans_start();

                /**
                 * insert directly from forms
                 */
                //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::start
                $s_id = $this->Student_model->from_form(NULL, array(
                            /**
                             * so users cant override the valid value
                             * not recommended hidden inputs
                             * --Lloric
                             */
                            'student_school_id' => (string) $this->school_id->generate(),
                            //--
                            'student_image'     => $img_name,
                            'created_user_id'   => $this->session->userdata('user_id')
                        ))->insert();

                $id = $this->Enrollment_model->from_form(NULL, array(
                            /**
                             * so users cant override the valid value
                             * not recommended hidden inputs
                             * --Lloric
                             */
                            'enrollment_semester'    => current_school_semester(),
                            'enrollment_school_year' => current_school_year(),
                            //--
                            'student_id'             => $s_id,
                            'created_user_id'        => $this->session->userdata('user_id')
                        ))->insert();
                //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::end

                /**
                 * checking if one of the insert is failed, either in [form validation] or in [syntax error] or [upload]
                 */
                if (!$s_id || !$id || !$uploaded)
                {
                        /**
                         * rollback database
                         */
                        $this->db->trans_rollback();
                        if ($uploaded)
                        {
                                /**
                                 * remove the uploaded image
                                 */
                                unlink($this->config->item('student_image_dir') . $img_name);
                        }
                }
                else
                {
                        if ($this->db->trans_commit())
                        {
                                redirect(base_url('students/view?student-id=' . $s_id), 'refresh');
                        }
                }
        }

        private function _form_view($image_error_message, $_post_image_name)
        {
                /**
                 * if reach here, load the model, etc...
                 */
                $this->load->model('Course_model');
                $this->load->helper('combobox');


                $this->data['message'] = $image_error_message;

                $this->data['student_image'] = array(
                    'name' => $_post_image_name,
                );

                $this->data['student_firstname']  = array(
                    'name'  => 'firstname',
                    'value' => $this->form_validation->set_value('firstname'),
                );
                $this->data['student_middlename'] = array(
                    'name'  => 'middlename',
                    'value' => $this->form_validation->set_value('middlename'),
                );

                $this->data['student_lastname'] = array(
                    'name'  => 'lastname',
                    'value' => $this->form_validation->set_value('lastname'),
                );

                $this->data['student_gender']    = array(
                    'name'  => 'gender',
                    'value' => $this->form_validation->set_value('gender'),
                );
                $this->data['student_birthdate'] = array(
                    'name'             => 'birthdate',
                    'data-date-format' => 'mm-dd-yyyy',
                    'class'            => 'zpicker',
                    'value'            => $this->form_validation->set_value('birthdate'),
                );



                $this->data['student_birthplace'] = array(
                    'name'  => 'birthplace',
                    'id'    => 'birthplace',
                    'value' => $this->form_validation->set_value('birthplace'),
                );

                $this->data['student_civil_status'] = array(
                    'name'  => 'status',
                    'value' => $this->form_validation->set_value('status'),
                );

                $this->data['student_nationality'] = array(
                    'name'  => 'nationality',
                    'value' => $this->form_validation->set_value('nationality'),
                );



                $this->data['student_permanent_address'] = array(
                    'name'  => 'address',
                    'id'    => 'address',
                    'value' => $this->form_validation->set_value('address'),
                );

                /**
                 * i used temp, because, when form submmited,
                 *  i will use freshly from helper, just to make sure client cant override value
                 * --Lloric
                 */
                $this->data['student_school_id_temp'] = array(
                    'name'     => 'id_temp',
                    'disabled' => '',
                    'value'    => $this->school_id->temporary_id(),
                );



                //++++++++++++++++++++++++++++++++++++++=
                $this->data['student_guardian_fullname'] = array(
                    'name'  => 'guardian_fullname',
                    'value' => $this->form_validation->set_value('guardian_fullname'),
                );


                $this->data['student_address_town'] = array(
                    'name'  => 'town',
                    'value' => $this->form_validation->set_value('town'),
                );



                $this->data['student_address_region'] = array(
                    'name'  => 'region',
                    'value' => $this->form_validation->set_value('region'),
                );



                $this->data['student_guardian_address'] = array(
                    'name'  => 'guardian_address',
                    'value' => $this->form_validation->set_value('guardian_address'),
                );



                $this->data['student_personal_contact_number'] = array(
                    'name'  => 'ontact_number',
                    'value' => $this->form_validation->set_value('ontact_number'),
                );



                $this->data['student_guardian_contact_number'] = array(
                    'name'  => 'guardian_contact_number',
                    'value' => $this->form_validation->set_value('guardian_contact_number'),
                );



                $this->data['student_personal_email'] = array(
                    'name'  => 'personal_email',
                    'value' => $this->form_validation->set_value('personal_email'),
                );


                $this->data['student_guardian_email'] = array(
                    'name'  => 'guardian_email',
                    'value' => $this->form_validation->set_value('guardian_email'),
                );

                /**
                 * enrollment inputs
                 */
                $this->data['course_id']             = array(
                    'name'  => 'courseid',
                    'value' => $this->Course_model->set_cache('dropdown_course_code')->as_dropdown('course_code')->get_all(),
                );
                $this->data['enrollment_year_level'] = array(
                    'name'  => 'level',
                    'value' => _numbers_for_drop_down(0, $this->config->item('max_year_level')),
                );

                /**
                 * i used temp, because, when form submmited,
                 *  i will use freshly from helper, just to make sure client cant override value
                 * --Lloric
                 */
                $this->data['enrollment_semester']    = array(
                    'name'     => 'semester_temp',
                    'disabled' => '',
                    'value'    => current_school_semester(),
                );
                $this->data['enrollment_school_year'] = array(
                    'name'     => 'school_year_temp',
                    'disabled' => '',
                    'value'    => current_school_year(),
                );
                /**
                 * redering
                 */
                $this->data['bootstrap']              = $this->bootstrap();
                $this->_render('admin/create_student', $this->data);
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function bootstrap()
        {
                /**
                 * for header
                 */
                $header = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/colorpicker.css',
                        'css/datepicker.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'css/bootstrap-wysihtml5.css',
                        'font-awesome/css/font-awesome.css" rel="stylesheet',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    /**
                     * wizard
                     */
//                        'css/bootstrap.min.css',
//                        'css/bootstrap-responsive.min.css',
//                        'css/matrix-style.css',
//                        'css/matrix-media.css',
//                        'font-awesome/css/font-awesome.css',
//                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    /**
                     * addition for form
                     */
//                        'css/colorpicker.css',
//                        'css/datepicker.css',
//                        'css/uniform.css',
//                        'css/select2.css',
//                        'css/bootstrap-wysihtml5.css',
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 */
                $footer = array(
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
                        /**
                         * wizard
                         * 
                         */
//                        'js/jquery.min.js',
//                        'js/jquery.ui.custom.js',
//                        'js/bootstrap.min.js',
//                        'js/jquery.validate.js',
//                        'js/jquery.wizard.js',
//                        'js/matrix.js',
                        /*
                         * for frontend validation
                         */
                        base_url('assets/framework/bootstrap/admin/matrixwizard.js'),
                    /**
                     * addition for form
                     */
//                        'js/bootstrap-colorpicker.js',
//                        'js/bootstrap-datepicker.js',
//                        'js/jquery.toggle.buttons.js',
//                        'js/masked.js',
//                        'js/jquery.uniform.js',
//                        'js/select2.min.js',
//                        'js/matrix.form_common.js',
//                        'js/wysihtml5-0.3.0.js',
//                        'js/jquery.peity.min.js',
//                        'js/bootstrap-wysihtml5.js',
                    ),
                );
                /**
                 * footer extra
                 */
                /**
                 * addition for form
                 */
//                $footer_extra = "<script>
//                        $('.textarea_editor').wysihtml5();
//                </script>";

                $footer_extra = "<script>
	$('.textarea_editor').wysihtml5();
</script>";
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
