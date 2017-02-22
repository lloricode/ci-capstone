<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rooms extends CI_Capstone_Controller
{

        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_rooms');
                $this->load->model('Room_model');
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
                $this->breadcrumbs->unshift(2, 'Rooms', 'rooms');
        }

        /**
         * @author Jinkee Po 
         *         pojinkee1@gmail.com
         */
        public function index()
        {


                $this->page_ = get_page_in_url();


                $room_obj = $this->Room_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();


                $table_data = array();

                if ($room_obj)
                {

                        foreach ($room_obj as $room)
                        {
                                array_push($table_data, array(
                                    my_htmlspecialchars($room->room_number),
                                    my_htmlspecialchars($room->room_description),
                                ));
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_room_number_th'),
                    lang('index_room_description_th')
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('rooms/index', $this->Room_model->count_rows() / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_room_heading');


                /**
                 * templates for group controller
                 */
                $this->template['table_data_groups'] = $this->_render_page('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']        = 'table';
                $this->template['message']           = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


                $this->template['bootstrap'] = $this->bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render_admin_page('admin/rooms', $this->template);
        }

        /**
         * 
         * @return array
         *  @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function bootstrap_for_view()
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
        private function bootstrap()
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
