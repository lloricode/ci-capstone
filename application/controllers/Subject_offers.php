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
                $this->load->model(array('Room_model', 'Subject_offer_model', 'Subject_offer_line_model', 'User_model', 'Subject_model', 'Room_model'));
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
                $this->breadcrumbs->unshift(3, lang('index_subject_offer_heading'), 'subject-offers');
                $this->load->helper(array('day', 'time', 'school'));
        }

        /**
         * @contributor Jinkee Po <pojinkee1@gmail.com>
         */
        public function index()
        {
                $subl        = $this->Subject_offer_model->all(TRUE); //parameter is set to current semester and year
                //  echo print_r($subl);
                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
//list students

                $table_data = array();
                if ($subl)
                {

                        foreach ($subl as $s)
                        {
                                if ( ! isset($s->subject_line))
                                {
                                        continue;
                                }
                                $output = array(
                                    $s->subject->subject_code,
                                    $s->faculty->first_name
                                );

                                $line = array();
                                $inc  = 0;
                                foreach ($s->subject_line as $su_l)
                                {
                                        $inc ++;
                                        $schd = array(
                                            subject_offers_days($su_l),
                                            convert_24_to_12hrs($su_l->subject_offer_line_start),
                                            convert_24_to_12hrs($su_l->subject_offer_line_end),
                                            $su_l->room->room_number
                                        );
                                        $line = array_merge($line, $schd);
                                }
                                if ($inc === 1)
                                {
                                        $line = array_merge($line, array('--', '--', '--', '--'));
                                }
                                if ($this->ion_auth->is_admin())
                                {

                                        $line[] = $this->User_model->modidy($s, 'created');
                                        $line[] = $this->User_model->modidy($s, 'updated');
                                }
                                $table_data[] = array_merge($output, $line);
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
                    //'id',
//                    lang('index_subject_id_th'),
//                    lang('index_subject_offer_start_th'),
//                    lang('index_subject_offer_end_th'),
//                    lang('index_subject_offer_days_th'),
//                    lang('index_room_id_th'),
//                    lang('index_user_id_th'),
                    'Subject',
                    'Faculty',
                    'Days1',
                    'Start1',
                    'End1',
                    'Room1',
                    'Days2',
                    'Start2',
                    'End2',
                    'Room2'
                );

                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }
                $pagination = $this->pagination->generate_bootstrap_link('subject-offers/index', $this->Subject_offer_model->count_rows() / $this->limit);

                $this->template['table_subject_offers'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_subject_offer_heading', $pagination, TRUE);
                $this->template['message']              = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']            = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/subject_offers', $this->template);
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
