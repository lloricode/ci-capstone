<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_subjects');
                $this->load->model('Subject_model');
                $this->load->library('pagination');

                /**
                 * pagination limit
                 */
                $this->limit = 10;

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
                $this->breadcrumbs->unshift(2, lang('index_subject_heading_th'), 'subjects');
        }

        public function index()
        {


                $subject_obj = $this->Subject_model->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('updated_at', 'DESC')->
                        order_by('created_at', 'DESC')->
                        set_cache('subjects_page_' . $this->page_)->
                        get_all();


                $table_data = array();

                if ($subject_obj)
                {

                        foreach ($subject_obj as $subject)
                        {

                                array_push($table_data, array(
                                    my_htmlspecialchars($subject->subject_code),
                                    my_htmlspecialchars($subject->subject_description),
                                        //my_htmlspecialchars($subject->subject_unit),
                                ));
                        }
                }

                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_subject_code_th'),
                    lang('index_subject_description_th'),
                        //lang('index_subject_unit_th'),
                );

                $pagination = $this->pagination->generate_bootstrap_link('subjects/index', $this->Subject_model->count_rows() / $this->limit);

                $this->template['table_subjects'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_subject_heading', $pagination, TRUE);
                $this->template['message']        = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']      = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/subjects', $this->template);
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
