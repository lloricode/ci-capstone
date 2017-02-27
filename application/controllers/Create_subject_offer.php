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
                $this->breadcrumbs->unshift(2, lang('index_subject_offer_heading'), 'subject-offers');
                $this->breadcrumbs->unshift(3, lang('create_subject_offer_heading'), 'create-subject-offer');
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
                        $id = $this->Subject_offer_model->from_form(NULL, array(
                                    'created_user_id' => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                $this->session->set_flashdata('message', $this->config->item('message_start_delimiter', 'ion_auth') . lang('create_subject_offer_succesfully_added_message') . $this->config->item('message_end_delimiter', 'ion_auth'));
                                redirect(site_url('create-subject-offer'), 'refresh');
                        }
                }
                $this->_form_view();
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

        private function _form_view()
        {
                $this->load->model(array('User_model', 'Subject_model', 'Room_model'));
                $this->load->helper(array('combobox', 'day'));

                $this->data['message'] = ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'));

                $this->data['subject_offer_start'] = array(
                    'name'  => 'start',
                    'value' => $this->form_validation->set_value('start'),
                );

                $this->data['subject_offer_end'] = array(
                    'name'  => 'end',
                    'value' => $this->form_validation->set_value('end'),
                );

                /**
                 * foreign
                 */
                $this->data['user_id'] = array(
                    'name'  => 'faculty',
                    'value' => $this->_faculties(),
                );

                $this->data['subject_id'] = array(
                    'name'  => 'subject',
                    'value' => $this->Subject_model->set_cache('dropdown_subject_code')->as_dropdown('subject_code')->get_all(),
                );

                $this->data['room_id'] = array(
                    'name'  => 'room',
                    'value' => $this->Room_model->set_cache('dropdown_room_number')->as_dropdown('room_number')->get_all(),
                );

                /**
                 * for check box
                 */
                $this->data['days'] = days_for_db();

                $this->data['bootstrap']     = $this->bootstrap();
                $this->data['conflict_data'] = MY_Controller::_render('admin/_templates/create_subject_offer/conflict_data', $this->data, TRUE);
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
