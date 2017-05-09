<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_subject extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
        }

        public function index()
        {
                $subject_obj = check_id_from_url('subject_id', 'Subject_model', 'subject-id', 'course');
                $this->breadcrumbs->unshift(3, lang('edit_subject_label') . ' [ ' . $subject_obj->subject_code . ' ]', 'edit-subject?subject-id=' . $subject_obj->subject_id);


                if ($this->input->post('submit'))
                {
                        $this->load->model('Subject_model');
                        $id = $this->Subject_model->from_form(NULL, NULL, array('subject_id' => $subject_obj->subject_id))->update();

                        if ($id)
                        {
                                $this->session->set_flashdata('message', bootstrap_success('create_subject_succesfully_update_message'));
                                redirect(site_url('subjects'), 'refresh');
                        }
                        else
                        {
                                $this->session->set_flashdata('message', bootstrap_error("failed"));
                        }
                }

                $this->_form_view($subject_obj);
        }

        public function check_unique()
        {
                if (!(bool) $this->input->post('submit'))
                {
                        show_404();
                }
                $code_input = (string) $this->input->post('code', TRUE);
                $code_db    = (string) check_id_from_url('subject_id', 'Subject_model', 'subject-id')->subject_code;

                if ($code_input === $code_db)
                {
                        return TRUE;
                }
                $row = $this->Subject_model->where(array(
                            'subject_code' => $code_input
                        ))->count_rows();
                $this->form_validation->set_message('check_unique', 'Already in exist.');
                return (bool) ($row == 0);
        }

        private function _form_view($subject_obj)
        {
                $inputs['code'] = array(
                    'name'  => 'code',
                    'value' => $this->form_validation->set_value('code', $subject_obj->subject_code),
                    'type'  => 'text',
                    'lang'  => 'index_subject_code_th'
                );

                $inputs['description'] = array(
                    'name'  => 'description',
                    'value' => $this->form_validation->set_value('description', $subject_obj->subject_description),
                    'type'  => 'text',
                    'lang'  => 'index_subject_description_th'
                );

                $inputs['rate'] = array(
                    'name'  => 'rate',
                    'value' => $this->form_validation->set_value('rate', $subject_obj->subject_rate),
                    'type'  => 'text',
                    'lang'  => 'curriculum_subject_rate_label'
                );

//                $this->load->model('Course_model');
//                $inputs['course_id'] = array(
//                    'name'      => 'course',
//                    'value'     => $this->Course_model->drpdown_with_gen_ed(),
//                    'type'      => 'dropdown',
//                    'lang'      => 'index_course_heading',
//                    'default' => $subject_obj->course_id
//                );

                $data['edit_room_form'] = $this->form_boostrap('edit-subject?subject-id=' . $subject_obj->subject_id, $inputs, 'edit_subject_label', 'edit_subject_label', 'info-sign', NULL, TRUE, FALSE);



                $data['bootstrap'] = $this->_bootstrap();
                $this->render('admin/edit_room', $data);
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
                    'js'  => array(),
                );
                /**
                 * for footer
                 */
                $footer       = array(
                    'css' => array(),
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
