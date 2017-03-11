<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject_offer extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model('Subject_offer_model');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
                $this->breadcrumbs->unshift(3, lang('index_subject_offer_heading'), 'subject-offers');
                $this->breadcrumbs->unshift(4, lang('create_subject_offer_heading'), 'create-subject-offer');
                /**
                 * for check box, in days
                 */
                $this->load->library('table');
                $this->load->helper('time');
        }

        /**
         * @Contributor: Jinkee Po <pojinkee1@gmail.com>
         *         
         */
        public function index()
        {
                if ($this->input->post('submit'))
                {
                        $this->load->helper('school');
                        $id = $this->Subject_offer_model->from_form(NULL, array(
                                    'subject_offer_semester'    => current_school_semester(TRUE),
                                    'subject_offer_school_year' => current_school_year(),
                                    'created_user_id'           => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                $this->session->set_flashdata('message', lang('create_subject_offer_succesfully_added_message'));
                                redirect(site_url('create-subject-offer'), 'refresh');
                        }
                }
                $this->_form_view();
        }

        public function subject_offer_check_check_conflict()
        {
                if (!$this->input->post('submit'))
                {
                        show_404();
                }
                $this->load->helper('day');
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->library('subject_offer_validation');
                $this->subject_offer_validation->init('post');
                $conflic = $this->subject_offer_validation->subject_offer_check_check_conflict();
                $data    = $this->subject_offer_validation->conflict();
                if ($data)
                {
                        $inc        = 1;
                        $header     = array(
                            '#',
                            lang('index_subject_offer_start_th'),
                            lang('index_subject_offer_end_th'),
                            lang('index_subject_offer_days_th'),
                            lang('index_user_id_th'),
                            lang('index_subject_id_th'),
                            lang('index_room_id_th'),
                        );
                        $table_data = array();
                        foreach ($data as $subject_offer)
                        {
                                $user = $this->User_model->get($subject_offer->user_id);
                                array_push($table_data, array(
                                    $inc++,
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_start)),
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_end)),
                                    my_htmlspecialchars(subject_offers_days($subject_offer)),
                                    my_htmlspecialchars($user->last_name . ', ' . $user->first_name),
                                    my_htmlspecialchars($this->Subject_model->get($subject_offer->subject_id)->subject_code),
                                    my_htmlspecialchars($this->Room_model->get($subject_offer->room_id)->room_number),
                                ));
                        }
                        $this->data['conflict_data'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'subject_offer_conflict_data', FALSE, TRUE);
                }
                return $conflic;
        }

        private function _form_view()
        {
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->helper(array('combobox', 'day'));


                $this->data['subject_offer_start'] = array(
                    'name'  => 'start',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_start_label'
                );

                $this->data['subject_offer_end'] = array(
                    'name'  => 'end',
                    'value' => time_list(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_offer_end_label'
                );

                /**
                 * foreign
                 */
                $this->data['user_id'] = array(
                    'name'  => 'faculty',
                    'value' => $this->_faculties(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_user_id_label'
                );

                $this->data['subject_id'] = array(
                    'name'  => 'subject',
                    'value' => $this->Subject_model->
                            as_dropdown('subject_code')->
                            set_cache('as_dropdown_subject_code')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_subject_id_label'
                );

                $this->data['room_id'] = array(
                    'name'  => 'room',
                    'value' => $this->Room_model->
                            as_dropdown('room_number')->
                            set_cache('as_dropdown_room_number')->
                            get_all(),
                    'type'  => 'dropdown',
                    'lang'  => 'create_room_id_label'
                );

                /**
                 * for check box
                 */
                $this->data['days'] = days_for_db();

                $this->data['bootstrap'] = $this->_bootstrap();
                $this->_render('admin/create_subject_offer', $this->data);
        }

        /**
         * 
         * @return array
         */
        private function _faculties()
        {
                /**
                 * create drop_down for <select></select>'s <option>
                 */
                $faculty_drop_down = array();

                /**
                 * get all user that has faculty group
                 */
                $faculties_obj = $this->ion_auth->users('faculty')->result();

                /**
                 * convert to array with specific value id|full_name
                 */
                foreach ($faculties_obj as $f)
                {
                        $faculty_drop_down[$f->id] = $f->last_name . ', ' . $f->first_name;
                }
                return $faculty_drop_down;
        }

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
