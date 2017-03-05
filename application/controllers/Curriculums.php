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
                $this->load->helper('school');
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
                        set_cache('curriculum_page_' . $this->page_)->
                        get_all();


                $table_data = array();

                if ($curriculum_obj)
                {

                        foreach ($curriculum_obj as $curriculum)
                        {
                                $view = anchor(site_url('curriculums/view?curriculum-id=' . $curriculum->curriculum_id), lang('curriculumn_view'));
                                array_push($table_data, array(
                                    my_htmlspecialchars($curriculum->curriculum_description),
                                    my_htmlspecialchars($curriculum->curriculum_effective_school_year),
                                    my_htmlspecialchars(semesters($curriculum->curriculum_effective_semester)),
                                    my_htmlspecialchars($this->Course_model->get($curriculum->course_id)->course_code),
                                    my_htmlspecialchars($curriculum->curriculum_status),
                                    $view
                                ));
                        }
                }

                /*
                 * Table headers
                 */
                $header     = array(
                    lang('curriculumn_description'),
                    lang('curriculumn_effective_year'),
                    lang('curriculumn_effective_semester'),
                    lang('curriculumn_course'),
                    lang('curriculumn_status'),
                    lang('curriculumn_option')
                );
                $pagination = $this->pagination->generate_bootstrap_link('curriculums/index', $this->Curriculum_model->set_cache('curriculum_count_rows')->count_rows() / $this->limit);

                $this->template['table_curriculm'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'curriculum_label', $pagination, TRUE);
                $this->template['message']         = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']       = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/curriculums', $this->template);
        }

        public function view()
        {
                $curriculum_obj = check_id_from_url('curriculum_id', 'Curriculum_model', $this->input->get('curriculum-id'));
                $this->breadcrumbs->unshift(3, lang('curriculum_subject_label'), 'curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id);


                $this->load->model(array('Curriculum_subject_model', 'Subject_model'));

                $cur_subj_obj = $this->Curriculum_subject_model->
                        where(array('curriculum_id' => $curriculum_obj->curriculum_id))->
                        order_by('curriculum_subject_year_level', 'ASC')->
                        order_by('curriculum_subject_semester', 'ASC')->
                        set_cache('curriculum_subject_' . $curriculum_obj->curriculum_id)->
                        get_all();

                $table_data = array();

                if ($cur_subj_obj)
                {
                        foreach ($cur_subj_obj as $cs)
                        {
                                $subj_pre = '';
                                $subj_co  = '';
                                if ($cs->subject_id_pre)
                                {
                                        $subj_pre = $this->Subject_model->get($cs->subject_id_pre)->subject_code;
                                }
                                if ($cs->subject_id_co)
                                {
                                        $subj_co = $this->Subject_model->get($cs->subject_id_co)->subject_code;
                                }
                                $table_data[] = array(
                                    my_htmlspecialchars($cs->curriculum_subject_year_level),
                                    my_htmlspecialchars($this->Subject_model->get($cs->subject_id)->subject_code . $cs->subject_id),
                                    my_htmlspecialchars($cs->curriculum_subject_units),
                                    my_htmlspecialchars($cs->curriculum_subject_lecture_hours . ' Hours'),
                                    my_htmlspecialchars($cs->curriculum_subject_laboratory_hours . ' Hours'),
                                    my_htmlspecialchars(semesters($cs->curriculum_subject_semester)),
                                    my_htmlspecialchars($subj_pre),
                                    my_htmlspecialchars($subj_co),
                                );
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
                    lang('curriculum_subject_year_level_label'),
                    lang('curriculum_subject_subject_label'),
                    lang('curriculum_subject_units_label'),
                    lang('curriculum_subject_lecture_hours_label'),
                    lang('curriculum_subject_laboratory_hours_label'),
                    lang('curriculum_subject_semester_label'),
                    lang('curriculum_subject_pre_subject_label'),
                    lang('curriculum_subject_co_subject_label')
                );

                $this->template['table_corriculum_subjects'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'curriculum_subject_label', FALSE, TRUE);
                $this->template['message']                   = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']                 = $this->_bootstrap();
                $this->_render('admin/curriculums', $this->template);
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
