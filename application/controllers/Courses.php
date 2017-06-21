<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load(array('ci_capstone/ci_courses', 'ci_capstone/ci_educations'));
                $this->load->model(array('Course_model', 'Education_model'));
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
                $this->breadcrumbs->unshift(2, lang('index_utility_label'), '#');
                $this->breadcrumbs->unshift(3, lang('index_course_heading'), 'courses');
        }

        /**
         * Function to display the index
         * @author Jinkee Po <pojinkee1@gmail.com>
         * @version 2017-2-4
         */
        public function index()
        {

                //list the Courses
                $course_obj = $this->Course_model->
                        with_user_created('fields:first_name,last_name')->
                        with_user_updated('fields:first_name,last_name')->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        set_cache('courses_withusercreated_withuserupdated_page_' . $this->page_)->
                        get_all();


                $table_data = array();
                if ($course_obj)
                {

                        foreach ($course_obj as $course)
                        {

                                $tmp   = array();
                                $tmp[] = my_htmlspecialchars($course->course_code);
                                $tmp[] = my_htmlspecialchars($course->course_description);
                                if ($this->config->item('version_id_generator') == 2)
                                {
                                        $tmp[] = my_htmlspecialchars($course->course_code_id);
                                }
//                                $tmp[] = my_htmlspecialchars($this->Education_model->get($course->education_id)->education_code);


                                if ($this->ion_auth->is_admin())
                                {
                                        $tmp[] = $this->User_model->modidy($course, 'created');
                                        $tmp[] = $this->User_model->modidy($course, 'updated');
                                }
                                $table_data[] = $tmp;
                        }
                }



                /*
                 * Table headers
                 */

                $header[] = lang('index_course_code_th');
                $header[] = lang('index_course_desc_th');
                if ($this->config->item('version_id_generator') == 2)
                {
                        $header[] = lang('index_course_code_id_th');
                }
//                $header[] = lang('index_education_code_th');

                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }
                $pagination = $this->pagination->generate_bootstrap_link('courses/index', $this->Course_model->count_rows() / $this->limit);

                $template['table_courses'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_course_heading', $pagination, TRUE);
                $template['message']       = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']     = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/courses', $template);
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
