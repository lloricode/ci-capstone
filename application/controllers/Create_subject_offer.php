<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject_offer extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_subject_offers');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, 'Subject Offers', 'subject-offers');
                $this->breadcrumbs->unshift(3, 'Create Subject Offers', 'create-subject-offer');
                /**
                 * for check box, in days
                 */
                $this->load->library('table');
                $this->load->helper('time');
        }

        public function subject_offer_check_check_conflict()
        {
                $this->load->helper('day');
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->library('subject_offer');
                $this->subject_offer->init('post');
                $conflic = $this->subject_offer->subject_offer_check_check_conflict();
                $data    = $this->subject_offer->conflict();
                if ($data)
                {
                        $inc        = 1;
                        $header     = array(
                            '#', 'id',
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
                                    $subject_offer->subject_offer_id,
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_start)),
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_end)),
                                    my_htmlspecialchars(subject_offers_days($subject_offer)),
                                    my_htmlspecialchars($user->last_name . ', ' . $user->first_name),
                                    my_htmlspecialchars($this->Subject_model->get($subject_offer->subject_id)->subject_code),
                                    my_htmlspecialchars($this->Room_model->get($subject_offer->room_id)->room_number),
                                ));
                        }
                        $this->data['data_conflict'] = $this->my_table_view($header, $table_data, 'table_open_bordered');
                }
                return $conflic;
        }

        /**
         * @Contributor: Jinkee Po <pojinkee1@gmail.com>
         *         
         */
        public function index()
        {

                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('create_subject_offer_start_label'),
                        'field' => 'subject_offer_start',
                        'rules' => 'required|trim|min_length[3]|max_length[5]|time_24hr|time_24hr|time_lessthan[' . $this->input->post('subject_offer_end', TRUE) . ']',
                    ),
                    array(
                        'label' => lang('create_subject_offer_end_label'),
                        'field' => 'subject_offer_end',
                        'rules' => 'required|trim|min_length[3]|max_length[5]',
                    ),
                    array(
                        'label' => lang('create_user_id_label'),
                        'field' => 'user_id',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    array(
                        'label' => lang('create_subject_id_label'),
                        'field' => 'subject_id',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    array(
                        'label' => lang('create_room_id_label'),
                        'field' => 'room_id',
                        'rules' => 'trim|required|is_natural_no_zero',
                    ),
                    array(
                        'label' => 'Subject Offer',
                        'field' => 'subject_offer_check_check_conflict',
                        'rules' => 'callback_subject_offer_check_check_conflict',
                    ),
                ));
                $days = array(
                    'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
                );
                if ($this->form_validation->run())
                {
                        $subject_offer = array(
                            /**
                             * time
                             */
                            'subject_offer_start' => $this->input->post('subject_offer_start', TRUE),
                            'subject_offer_end'   => $this->input->post('subject_offer_end', TRUE),
                            /**
                             * foreign
                             */
                            'user_id'             => $this->input->post('user_id', TRUE),
                            'subject_id'          => $this->input->post('subject_id', TRUE),
                            'room_id'             => $this->input->post('room_id', TRUE),
                            /**
                             * 
                             */
                            'created_user_id'     => $this->ion_auth->user()->row()->id
                        );
                        $days          = array(
                            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
                        );
                        /**
                         * get input from check box, days
                         */
                        foreach ($days as $d)
                        {
                                $subject_offer['subject_offer_' . $d] = ($this->input->post('subject_offer_' . $d, TRUE) == $d) ? TRUE : FALSE;
                        }
                        $this->load->model('Subject_offer_model');
                        if ($this->Subject_offer_model->insert($subject_offer))
                        {
                                $this->session->set_flashdata('message', $this->config->item('message_start_delimiter', 'ion_auth') . lang('create_subject_offer_succesfully_added_message') . $this->config->item('message_end_delimiter', 'ion_auth'));
                                redirect(current_url(), 'refresh');
                        }
                }

                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->helper('combobox');
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->data['subject_offer_start'] = array(
                    'name'  => 'subject_offer_start',
                    'type'  => 'time',
                    'value' => $this->form_validation->set_value('subject_offer_start'),
                );


                $this->data['subject_offer_end'] = array(
                    'name'  => 'subject_offer_end',
                    'type'  => 'time',
                    'value' => $this->form_validation->set_value('subject_offer_end'),
                );

                /**
                 * get all user that has faculty group
                 */
                $faculties_obj = $this->ion_auth->users('faculty')->result();

                /**
                 * create dropdown for <select></select>'s <option>
                 */
                $faculty_drop_down = array();
                /**
                 * convert to array with specific value id|fullname
                 */
                foreach ($faculties_obj as $f)
                {
                        $faculty_drop_down[$f->id] = $f->last_name . ', ' . $f->first_name;
                }
                $this->data['user_id_value']    = $faculty_drop_down;
                $this->data['subject_id_value'] = $this->Subject_model->as_dropdown('subject_code')->get_all();
                $this->data['room_id_value']    = $this->Room_model->as_dropdown('room_number')->get_all();


                /**
                 * for check box
                 */
                $this->data['days'] = $days;

                $this->data['bootstrap']     = $this->bootstrap();
                $this->data['conflict_data'] = $this->_render_page('admin/_templates/create_subject_offer/conflict_data', $this->data, TRUE);
                $this->_render_admin_page('admin/create_subject_offer', $this->data);
        }

        private function bootstrap()
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
