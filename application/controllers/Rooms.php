<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rooms extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->load->model('Room_model');
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
                $this->breadcrumbs->unshift(2, lang('index_utility_label'), '#');
                $this->breadcrumbs->unshift(3, lang('index_room_heading'), 'rooms');
        }

        /**
         * @author Jinkee Po 
         *         pojinkee1@gmail.com
         */
        public function index()
        {


                $this->page_ = get_page_in_url();


                $room_obj = $this->Room_model->
                        with_user_created('fields:first_name,last_name')->
                        with_user_updated('fields:first_name,last_name')->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('updated_at', 'DESC')->
                        order_by('created_at', 'DESC')->
                        set_cache('rooms_page_' . $this->page_)->
                        get_all();


                $table_data = array();

                if ($room_obj)
                {

                        foreach ($room_obj as $room)
                        {
                                $tmp = array(
                                    my_htmlspecialchars($room->room_number),
                                    my_htmlspecialchars($room->room_capacity)
                                );
                                if (in_array('edit-room', permission_controllers()))
                                {
                                        $tmp[] = table_row_button_link('edit-room?room-id=' . $room->room_id, lang('edit_room_label'));
                                }
                                if ($this->ion_auth->is_admin())
                                {

                                        $tmp[] = $this->User_model->modidy($room, 'created');
                                        $tmp[] = $this->User_model->modidy($room, 'updated');
                                }
                                array_push($table_data, $tmp);
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_room_number_th'),
                    lang('index_room_capacity_th')
                );
                if (in_array('edit-room', permission_controllers()))
                {
                        $header[] = lang('index_action_th');
                }
                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }
                $pagination = $this->pagination->generate_bootstrap_link('rooms/index', $this->Room_model->count_rows() / $this->limit);

                $template['table_rooms'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_room_heading', $pagination, TRUE);
                $template['message']     = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']   = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/rooms', $template);
        }

        /**
         * 
         * @return array
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap_for_view()
        {
                /**
                 * for header
                 *
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/matrix.js'
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

        /**
         * 
         * @return array
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap()
        {
                /**
                 * for header
                 * 
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/jquery.dataTables.min.js',
                        'js/matrix.js',
                        'js/matrix.tables.js',
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
