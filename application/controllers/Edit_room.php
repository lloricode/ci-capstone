<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_room extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->load->model('Room_model');
                $this->breadcrumbs->unshift(2, lang('index_utility_label'), '#');
                $this->breadcrumbs->unshift(3, lang('index_room_heading'), 'rooms');
        }

        public function index()
        {
                $room_obj = check_id_from_url('room_id', 'Room_model', 'room-id');
                $this->breadcrumbs->unshift(4, lang('edit_editroom_label') . ' [ ' . $room_obj->room_number . ' ]', 'edit-room?room-id=' . $room_obj->room_id);



                if ($this->input->post('submit'))
                {
                        $id = $this->Room_model->from_form(NULL, NULL, array('room_id' => $room_obj->room_id))->update();
                        if ($id)
                        {
                                $this->session->set_flashdata('message', bootstrap_success('room_succesfully_update_message'));
                                redirect(site_url('rooms'), 'refresh');
                        }
                }

                $this->_form_view($room_obj);
        }

        public function check_unique()
        {
                if ( ! (bool) $this->input->post('submit'))
                {
                        show_404();
                }
                $input_number = (int) $this->input->post('number', TRUE);
                $db_number    = (int) check_id_from_url('room_id', 'Room_model', 'room-id')->room_number;

                if ($input_number === $db_number)
                {
                        return TRUE;
                }
                $row = $this->Room_model->where(array(
                            'room_number' => $this->input->post('number', TRUE)
                        ))->count_rows();
                $this->form_validation->set_message('check_unique', 'Alredddady in exist.');
                return (bool) ($row == 0);
        }

        private function _form_view($room_obj)
        {
                $inputs['number'] = array(
                    'name'  => 'number',
                    'value' => $this->form_validation->set_value('number', $room_obj->room_number),
                    'type'  => 'text',
                    'lang'  => 'create_room_number_label'
                );

                $inputs['capacity'] = array(
                    'name'  => 'capacity',
                    'value' => $this->form_validation->set_value('capacity', $room_obj->room_capacity),
                    'type'  => 'text',
                    'lang'  => 'create_room_capacity_label'
                );

                $data['edit_room_form'] = $this->form_boostrap('edit-room?room-id=' . $room_obj->room_id, $inputs, 'edit_editroom_label', 'edit_editroom_label', 'info-sign', NULL, TRUE, FALSE);



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
