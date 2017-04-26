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
                $this->load->model(array('Subject_model', 'Course_model'));
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
                        with_user_created('fields:first_name,last_name')->
                        with_user_updated('fields:first_name,last_name')->
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

                                $tmp = array(
                                    my_htmlspecialchars($subject->subject_code),
                                    my_htmlspecialchars($subject->subject_description),
                                    $this->_subject_course($subject->course_id),
                                );

                                if (in_array('edit-subject', permission_controllers()))
                                {
                                        $tmp[] = table_row_button_link('edit-subject?subject-id=' . $subject->subject_id, 'Edit');
                                }
                                if ($this->ion_auth->is_admin())
                                {

                                        $tmp[] = $this->User_model->modidy($subject, 'created');
                                        $tmp[] = $this->User_model->modidy($subject, 'updated');
                                }
                                $table_data[] = $tmp;
                        }
                }

                /*
                 * Table headers
                 */
                $header = array(
                    lang('index_subject_code_th'),
                    lang('index_subject_description_th'),
                    lang('index_course_heading'),
                );
                if (in_array('edit-subject', permission_controllers()))
                {
                        $header[] = 'Edit';
                }
                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }
                $pagination = $this->pagination->generate_bootstrap_link('subjects/index', $this->Subject_model->count_rows() / $this->limit);

                if (in_array('create-subject', permission_controllers()))
                {
                        $template['create_subject_button'] = MY_Controller::render('admin/_templates/button_view', array(
                                    'href'         => 'create-subject',
                                    'button_label' => lang('create_subject_heading'),
                                    'extra'        => array('class' => 'btn btn-success icon-edit'),
                                        ), TRUE);
                }

                $template['table_subjects'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'index_subject_heading_th', $pagination, TRUE);
                $template['message']        = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']      = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/subjects', $template);
        }

        private function _subject_course($course_id)
        {
                if (is_null($course_id) OR $course_id == 0)
                {
                        return 'GEN ED';
                }
                return $this->Course_model->get($course_id)->course_code;
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
