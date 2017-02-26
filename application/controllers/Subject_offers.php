<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_offers extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_subject_offers');
                $this->load->model(array('Subject_offer_model', 'User_model', 'Subject_model', 'Room_model'));
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
                $this->breadcrumbs->unshift(2, 'Subject Offers', 'subject-offers');
                $this->load->helper(array('day', 'time'));

// echo print_r(time_list(FALSE,'10:30'));
        }

        /**
         * @contributor Jinkee Po <pojinkee1@gmail.com>
         */
        public function index()
        {
                /**
                 * get the page from url
                 * 
                 */
                $this->page_       = get_page_in_url();
//list students
                $subject_offer_obj = $this->Subject_offer_model;
                $subject_offer_obj = $subject_offer_obj->limit($this->limit, $this->limit * $this->page_ - $this->limit);


                foreach (days_for_db() as $d)
                {
                        $subject_offer_obj = $subject_offer_obj->order_by('subject_offer_' . $d, 'ASC');
                }
                $subject_offer_obj = $subject_offer_obj->order_by('subject_offer_start', 'ASC');
                $subject_offer_obj = $subject_offer_obj->get_all();

                $table_data = array();
                if ($subject_offer_obj)
                {

                        foreach ($subject_offer_obj as $subject_offer)
                        {
                                $user = $this->User_model->get($subject_offer->user_id);
                                array_push($table_data, array(
                                    $subject_offer->subject_offer_id,
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_start)),
                                    my_htmlspecialchars(convert_24_to_12hrs($subject_offer->subject_offer_end)),
                                    my_htmlspecialchars(subject_offers_days($subject_offer)),
                                    my_htmlspecialchars($user->last_name . ', ' . $user->first_name),
                                    my_htmlspecialchars($this->Subject_model->get($subject_offer->subject_id)->subject_code),
                                    my_htmlspecialchars($this->Room_model->get($subject_offer->room_id)->room_number),
                                ));
                        }
                }
                /*
                 * Table headers
                 */
                $header                   = array(
                    'id',
                    lang('index_subject_offer_start_th'),
                    lang('index_subject_offer_end_th'),
                    lang('index_subject_offer_days_th'),
                    lang('index_user_id_th'),
                    lang('index_subject_id_th'),
                    lang('index_room_id_th'),
                );
                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('subject-offers/index', $this->Subject_offer_model->count_rows() / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_subject_offer_heading');

                $this->template['table_data_groups'] = MY_Controller::_render('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']        = 'table';

                $this->template['bootstrap'] = $this->bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/subject_offers', $this->template);
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
                    'js'  => array(),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(),
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
                    'js'  => array(),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(),
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
