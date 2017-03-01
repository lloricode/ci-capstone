<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curriculums extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_educations');
                $this->load->model(array('Curriculum_model', 'Course_model'));
                $this->load->library('pagination');
                /**
                 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                 *         
                 */
                /**
                 * pagination limit
                 */
                $this->limit = 10;

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
        }

        public function index()
        {


                $curriculum_obj = $this->Curriculum_model->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('updated_at', 'DESC')->
                        order_by('created_at', 'DESC')->
                        set_cache('educations_page_' . $this->page_)->
                        get_all();


                $table_data = array();

                if ($curriculum_obj)
                {

                        foreach ($curriculum_obj as $curriculum)
                        {

                                array_push($table_data, array(
                                    my_htmlspecialchars($curriculum->curriculum_description),
                                    my_htmlspecialchars($curriculum->curriculum_effective_school_year),
                                    my_htmlspecialchars($curriculum->curriculum_effective_semester),
                                    my_htmlspecialchars($this->Course_model->get($curriculum->course_id)->course_code),
                                    my_htmlspecialchars($curriculum->curriculum_status),
                                ));
                        }
                }



                /*
                 * Table headers
                 */
                $header = array(
                    lang('curriculumn_description'),
                    lang('curriculumn_effective_year'),
                    lang('curriculumn_effective_semester'),
                    lang('curriculumn_course'),
                    lang('curriculumn_status'),
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination->generate_link('curriculums/index', $this->Curriculum_model->count_rows() / $this->limit);

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('curriculum_label');



                /**
                 * templates for group controller
                 */
                $this->template['table_data_groups'] = MY_Controller::_render('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']        = 'table';
                $this->template['message']           = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->template['bootstrap'] = $this->bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/educations', $this->template);
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
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
