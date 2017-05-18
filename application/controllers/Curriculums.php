<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curriculums extends CI_Capstone_Controller
{

        private $page_;
        private $limit;
        private $curriculum_search;

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Curriculum_model', 'Course_model'));
                $this->load->library('pagination');
                $this->load->helper(array('school', 'text'));
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
                $this->page_ = get_page_in_url('page');
        }

        public function index()
        {
                $this->curriculum_search = $this->input->get('search-curriculum');


                $curriculum_obj = $this->Curriculum_model->
                        fields(array(
                    'curriculum_description',
                    'curriculum_effective_school_year',
                    'curriculum_status',
                    'curriculum_already_used',
                    'curriculum_id',
                    'created_at',
                    'updated_at'
                ));

                $bred_crumbs_label   = '';
                $bred_crumbs_link    = '';
                $bred_crumbs_unshift = 2;
                if ($this->curriculum_search)
                {
                        $this->session->set_userdata('search-curriculum', $this->curriculum_search);
                        $c_obj = $this->Course_model->
                                fields('course_id')->
                                or_like(array(
                                    'course_description' => $this->curriculum_search
                                ))->
                                //set_cache()->
                                get_all();

                        if ($c_obj)
                        {
                                foreach ($c_obj as $v)
                                {
                                        $curriculum_obj = $curriculum_obj->or_where(array(
                                            'course_id' => $v->course_id
                                        ));
                                }
                        }

                        $curriculum_obj = $curriculum_obj->or_like(array(
                            'curriculum_description'           => $this->curriculum_search,
                            'curriculum_effective_school_year' => $this->curriculum_search
                        ));

                        /**
                         * button
                         */
                        $bred_crumbs_label   = " [ Search: $this->curriculum_search ]";
                        $bred_crumbs_link    = '?search-curriculum=' . $this->curriculum_search;
                        $bred_crumbs_unshift = 3;
                        $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
                }

                $view_link = '';
                $key_view  = $this->input->get('view');
                $viewall   = TRUE;
                if ($key_view)
                {
                        if ($key_view == 'all')
                        {
                                $viewall = FALSE;
                        }
                }
                $linkkk               = '';
                $labelll              = '';
                $view_link_pagination = '';
                if ($viewall)
                {
                        $curriculum_obj       = $curriculum_obj->where(array(
                            'curriculum_status' => TRUE
                        ));
                        $linkkk               = '?view=all';
                        $view_link_pagination = '';
                        $labelll              = 'All';
                }
                else
                {
                        $linkkk               = '';
                        $view_link_pagination = '?view=all';
                        $labelll              = 'Only Active';
                }
                $template['curriculum_button_view_all'] = MY_Controller::render('admin/_templates/button_view', array(
                            'href'         => 'curriculums' . $linkkk,
                            'button_label' => 'View ' . $labelll,
                            'extra'        => array('class' => 'btn btn-primary icon-eye-open'),
                                ), TRUE);


                $this->breadcrumbs->unshift($bred_crumbs_unshift, lang('curriculum_label') . $bred_crumbs_label, 'curriculums' . $bred_crumbs_link);
                $curriculum_obj_for_count = $curriculum_obj;

                $curriculum_obj = $curriculum_obj->
                        with_course('fields:course_code')->
                        with_user_created('fields:first_name,last_name')->
                        with_user_updated('fields:first_name,last_name')->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('created_at', 'DESC')->
                        order_by('updated_at', 'DESC')->
                        // set_cache('curriculum_page_' . $this->page_)->
                        get_all();

                $table_data = array();

                if ($curriculum_obj)
                {
                        foreach ($curriculum_obj as $curriculum)
                        {
                                $view = table_row_button_link('curriculums/view?curriculum-id=' . $curriculum->curriculum_id, lang('curriculumn_view'), 'btn-info');

                                $tmp = array(
                                    highlight_phrase($curriculum->course->course_code, $this->curriculum_search),
                                    highlight_phrase($curriculum->curriculum_description, $this->curriculum_search),
                                    highlight_phrase($curriculum->curriculum_effective_school_year, $this->curriculum_search),
                                    $this->_enable_button($curriculum->curriculum_status, $curriculum->curriculum_id, $curriculum->curriculum_already_used),
                                    $view
                                );
                                if ($this->ion_auth->is_admin())
                                {

                                        $tmp[] = $this->User_model->modidy($curriculum, 'created');
                                        $tmp[] = $this->User_model->modidy($curriculum, 'updated');
                                }
                                array_push($table_data, $tmp);
                        }
                }

                /*
                 * Table headers
                 */
                $header = array(
                    lang('curriculumn_course'),
                    lang('curriculumn_description'),
                    lang('curriculumn_effective_year'),
                    lang('curriculumn_status'),
                    lang('curriculumn_option')
                );

                if ($this->ion_auth->is_admin())
                {
                        $header[] = 'Created By';
                        $header[] = 'Updated By';
                }
                $pagination = $this->pagination->generate_bootstrap_link('curriculums' . $view_link_pagination . $bred_crumbs_link . $view_link, $curriculum_obj_for_count->count_rows() / $this->limit, TRUE);


                $template['table_curriculm'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'curriculum_label', $pagination, TRUE);
                $template['message']         = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']       = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/curriculums', $template);
        }

        /**
         * generate link for enabling curriculum,
         * if curriculum is enabled already, it will just return a status "Enabled"
         * 
         * note: enabling curriculum will disable other with same course_id and also even disabled it cannot edit/add data (because it already used by enrollment),
         * then a current curriculum cannot add/edit subjects
         * 
         * @param type $current_status
         * @return string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _enable_button($current_status, $id, $already_used)
        {
                $addtional_data = array('class' => 'taskStatus');
                if ($current_status)
                {
                        $addtional_data['data'] = '<span class="done">Enabled</span>';
                        return $addtional_data;
                }
//                if ($already_used)
//                {
//                        $addtional_data['data'] = '<span class="pending">Disabled</span>';
//                        return $addtional_data;
//                }
                if (!in_array('set-curriculum-enable', permission_controllers()))
                {
                        $addtional_data['data'] = '<span class="pending">Disabled</span>';
                }
                else
                {
                        $addtional_data['data'] = table_row_button_link('set-curriculum-enable?curriculum-id=' . $id, lang('enable_curriculum_label'));
                }
                return $addtional_data;
        }

        public function view()
        {
                $all_current_semester = FALSE;

                if ($semster_value = $this->input->get('semester'))
                {
                        if ($semster_value == 'current')
                        {
                                $label    = 'All Semester';
                                $url_link = '';
                                $all_current_semester = TRUE;
                        }
                }
                $tmp_result     = $this->_curriculum_subjects($all_current_semester);
                $header         = $tmp_result['header'];
                $table_data     = $tmp_result['data'];
                $curriculum_obj = $tmp_result['curriculum_obj'];
                unset($tmp_result);

                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
                $this->breadcrumbs->unshift(3, lang('curriculum_subject_label'), 'curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id);

                $label    = 'Current Semester';
                $url_link = '&semester=current';

                if ( ! $curriculum_obj->curriculum_status && ! $curriculum_obj->curriculum_already_used)
                {
                        $header[] = 'Options';

                        $template['create_curriculum_subject_major_button'] = MY_Controller::render('admin/_templates/button_view', array(
                                    'href'         => 'create-curriculum-subject?curriculum-id=' . $curriculum_obj->curriculum_id . '&type=major',
                                    'button_label' => 'Add Major Subject', //lang('create_curriculum_subject_label'),
                                    'extra'        => array('class' => 'btn btn-success icon-edit'),
                                        ), TRUE);

                        $template['create_curriculum_subject_monor_button'] = MY_Controller::render('admin/_templates/button_view', array(
                                    'href'         => 'create-curriculum-subject?curriculum-id=' . $curriculum_obj->curriculum_id . '&type=minor',
                                    'button_label' => 'Add Service Subject', //lang('create_curriculum_subject_label'),
                                    'extra'        => array('class' => 'btn btn-success icon-edit'),
                                        ), TRUE);
                }

                $template['curriculum_information']    = MY_Controller::render('admin/_templates/curriculums/curriculum_information', array('curriculum_obj' => $curriculum_obj), TRUE);
                $template['curriculum_obj']            = $curriculum_obj;
                $template['table_corriculum_subjects'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'curriculum_subject_label', FALSE, TRUE);
                $template['message']                   = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $template['bootstrap']                 = $this->_bootstrap();



                $template['view_by_semester_btn'] = MY_Controller::render('admin/_templates/button_view', array(
                            'href'         => 'curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id . $url_link,
                            'button_label' => $label,
                            'extra'        => array('class' => 'btn btn-primary icon-eye-open'),
                                ), TRUE);
                $template['export_curriculum_btn'] = MY_Controller::render('admin/_templates/button_view', array(
                            'href'         => 'curriculums/export?curriculum-id=' . $curriculum_obj->curriculum_id,
                            'button_label' => 'Exprot Excel',
                            'extra'        => array('class' => 'btn btn-primary icon-print'),
                                ), TRUE);
                $this->render('admin/curriculums', $template);
        }

        public function export()
        {
                $tmp_result     = $this->_curriculum_subjects(FALSE, TRUE);
                $header         = $tmp_result['header'];
                $table_data     = $tmp_result['data'];
                $curriculum_obj = $tmp_result['curriculum_obj'];

                $this->load->library('excel');
                $this->excel->filename = 'Curriculum Export - ' . $curriculum_obj->curriculum_effective_school_year . ', ' .
                        $curriculum_obj->course->course_code . ', ' .
                        $curriculum_obj->curriculum_description;
                $this->excel->make_from_array($header, $table_data);
        }

        private function _curriculum_subjects($all_current_semester, $export_excel = FALSE)
        {
                $curriculum_obj   = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id', 'course');
                $this->load->model(array('Curriculum_subject_model', 'Subject_model', 'Requisites_model', 'Unit_model'));
                $this->load->helper(array('number', 'text'));
                $highlight_phrase = '';

                if ( ! $export_excel)
                {
                        if ($h = $this->input->get('highlight'))
                        {
                                $highlight_phrase = $h;
                        }
                }

                $cur_subj_obj = $this->Curriculum_subject_model->curriculum_subjects($curriculum_obj->curriculum_id, FALSE, $all_current_semester);

                $table_data = array();
                if ($cur_subj_obj)
                {
                        $tmp_compare = '';
                        foreach ($cur_subj_obj as $cur_subj)
                        {
                                $tmp_sem_year = $cur_subj->curriculum_subject_year_level . $cur_subj->curriculum_subject_semester;
                                if ($tmp_compare != $tmp_sem_year)
                                {
                                        $tmp_compare  = $tmp_sem_year;
                                        $total_units  = $this->Curriculum_subject_model->total_units_per_term($cur_subj->curriculum_id, $cur_subj->curriculum_subject_semester, $cur_subj->curriculum_subject_year_level);
                                       
                                        if ($export_excel)
                                        {
                                                $table_data[] = array(
                                                    'data' => strtoupper(number_place($cur_subj->curriculum_subject_year_level) . ' Year') . ' - ' .
                                                    semesters($cur_subj->curriculum_subject_semester)
                                                    . ' Total units: ' . $total_units
                                                );
                                        }
                                        else
                                        {
                                                $table_data[] = array(
                                                    array(
                                                        'data'    => heading(strtoupper(number_place($cur_subj->curriculum_subject_year_level) . ' Year') . ' - ' .
                                                                semesters($cur_subj->curriculum_subject_semester)
                                                                , 4) . ' Total units: ' . bold($total_units),
                                                        'colspan' => '9'
                                                    )
                                                );
                                        }
                                }
                                $id = NULL;
                                if ( ! is_null($cur_subj->unit_id) && ! empty($cur_subj->unit_id))
                                {
                                        $id = $cur_subj->unit_id;
                                }
                                else
                                {
                                        $id = $cur_subj->subject->unit_id;
                                }
                                $unit_obj  = $this->Unit_model->get($id);
                                $requisite = $this->Requisites_model->subjects(isset($cur_subj->requisites) ? $cur_subj->requisites : NULL);
                                $tmp       = array(
                                    //  my_htmlspecialchars(semesters($cur_subj->curriculum_subject_semester, FALSE, 'short')),
                                    highlight_phrase($cur_subj->subject->subject_code, $highlight_phrase, '<mark id="' . dash($cur_subj->subject->subject_code) . '">', '</mark>'),
                                    my_htmlspecialchars($cur_subj->subject->subject_description),
                                    my_htmlspecialchars($unit_obj->unit_value),
                                    my_htmlspecialchars($unit_obj->lec_value),
                                    my_htmlspecialchars($unit_obj->lab_value),
                                    str_replace(br(), ', ', $requisite->pre),
                                    str_replace(br(), ', ', $requisite->co)
                                );
                                if ( ! $curriculum_obj->curriculum_status && ! $curriculum_obj->curriculum_already_used && ! $export_excel)
                                {
                                        $tmp[] = table_row_button_link('create-requisite?curriculum-id=' . $curriculum_obj->curriculum_id . '&curriculum-subject-id=' . $cur_subj->curriculum_subject_id, lang('create_requisite_label'));
                                }
                                $table_data[] = $tmp;
                        }
                }
                /*
                 * Table headers
                 */
                $header = array(
                    lang('curriculum_subject_subject_label'),
                    'desc',
                    lang('curriculum_subject_units_label'),
                    lang('curriculum_subject_lecture_hours_label'),
                    lang('curriculum_subject_laboratory_hours_label'),
                    lang('curriculum_subject_pre_subject_label'),
                    lang('curriculum_subject_co_subject_label')
                );
                return array(
                    'header'       => $header,
                    'data'         => $table_data,
                    'curriculum_obj' => $curriculum_obj
                );
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
