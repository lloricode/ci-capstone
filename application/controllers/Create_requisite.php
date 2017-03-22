<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_requisite extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
        }

        public function index()
        {
                /**
                 * check either exist or has value given id in url
                 */
                $curriculum_obj         = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id', 'course');
                $curriculum_subject_obj = check_id_from_url('curriculum_subject_id', 'Curriculum_subject_model', 'curriculum-subject-id', array('subject', 'requisite', 'curriculum'));
                //  print_r($curriculum_obj);
                // print_r($curriculum_subject_obj);
                /**
                 * verify id relation
                 */
                $this->_is_ids_related($curriculum_obj->curriculum_id, $curriculum_subject_obj->curriculum_subject_id);

                /**
                 * add breadcrumbs with verified ids
                 */
                $this->breadcrumbs->unshift(3, lang('curriculum_subject_label'), 'curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id);
                $this->breadcrumbs->unshift(4, lang('create_requisite_label'), 'create-requisite?curriculum-id=' . $curriculum_obj->curriculum_id . '&curriculum-subject-id=' . $curriculum_subject_obj->curriculum_subject_id);



                if ($this->input->post('submit'))
                {
                        $this->_submit($curriculum_obj->curriculum_id, $curriculum_subject_obj->curriculum_subject_id);
                }

                $this->_form_view($curriculum_obj, $curriculum_subject_obj);
        }

        private function _form_view($curriculum_obj, $curriculum_subject_obj)
        {
                //load here, to exclude in success run validation
                $this->load->model('Curriculum_subject_model');

                $sub_arr = $this->Curriculum_subject_model->
                        subjects_dropdown_for_add_requisite($curriculum_obj->curriculum_id, $curriculum_subject_obj->subject_id); //array for dropdown

                $inputs[] = array(
                    'name'  => 'pre[]',
                    //select subject that belong in current curriculum using curriculum_id
                    'value' => $sub_arr,
                    'type'  => 'multiselect',
                    'lang'  => 'requisite_pre_type_label',
                );

                $inputs[] = array(
                    'name'  => 'co[]',
                    //select subject that belong in current curriculum using curriculum_id
                    'value' => $sub_arr,
                    'type'  => 'multiselect',
                    'lang'  => 'requisite_co_type_label',
                );


                $this->template['curriculum_information']         = MY_Controller::_render('admin/_templates/curriculums/curriculum_information', array('curriculum_obj' => $curriculum_obj), TRUE);
                $this->template['curriculum_subject_information'] = $this->_current_curriculum_subject($curriculum_subject_obj->curriculum_subject_id);
                $this->template['requisite_form']                 = $this->form_boostrap('create-requisite?curriculum-id=' . $curriculum_obj->curriculum_id . '&curriculum-subject-id=' . $curriculum_subject_obj->curriculum_subject_id, $inputs, 'create_requisite_label', 'create_requisite_label', 'info-sign', NULL, TRUE, form_error('tmp_is_atleast_one')); //see requisite_model
                $this->template['bootstrap']                      = $this->_bootstrap();
                $this->_render('admin/create_requisite', $this->template);
        }

        private function _submit($curriculum_id, $curriculum_subject_id)
        {
                $this->load->model('Requisites_model');
                $this->form_validation->set_rules($this->Requisites_model->validations());


                if ($this->form_validation->run())
                {
                        $co_array        = $this->input->post('co', TRUE);
                        $pre_array       = $this->input->post('pre', TRUE);
                        $data_           = array();
                        /**
                         * collect multiple selected
                         */
                        /**
                         * use db transaction, just to make sure all data inserted
                         */
                        $this->db->trans_start();
                        $co_all_inserted = TRUE;
                        if ($co_array)
                        {
                                foreach ($co_array as $value)
                                {
                                        $data_[] = array(
                                            'subject_id'            => $value,
                                            'requisite_type'        => 'co',
                                            'curriculum_subject_id' => $curriculum_subject_id,
                                            'created_user_id'       => $this->session->userdata('user_id')
                                        );
                                }
                                //insert also in reverse subjects
                                $co_all_inserted = $this->_insert_also_revesre_as_co_requisite($co_array, $curriculum_subject_id, $curriculum_id);
                        }
                        if ($pre_array)
                        {
                                foreach ($pre_array as $value)
                                {
                                        $data_[] = array(
                                            'subject_id'            => $value,
                                            'requisite_type'        => 'pre',
                                            'curriculum_subject_id' => $curriculum_subject_id,
                                            'created_user_id'       => $this->session->userdata('user_id')
                                        );
                                }
                        }
                        // $ids = $this->Requisites_model->insert($data_);
                        $all_inserted = TRUE;
                        foreach ($data_ as $in)
                        {
                                /**
                                 * just to make sure all inserted, else database will rollback
                                 */
                                $id = $this->Requisites_model->insert($in);
                                if ( ! $id)
                                {
                                        $all_inserted = FALSE;
                                        break;
                                }
                        }

                        if ( ! $all_inserted OR ! $co_all_inserted)
                        {
                                /**
                                 * rollback database
                                 */
                                $this->db->trans_rollback();
                        }
                        else
                        {
                                if ($this->db->trans_commit())
                                {
                                        $this->session->set_flashdata('message', lang('requisite_success_added'));
                                        redirect(site_url('curriculums/view?curriculum-id=' . $curriculum_id), 'refresh');
                                }
                        }
                }
        }

        /**
         * this will automatically insert also a reverse co of inserted current curriculum subject
         * 
         * @param int $co_subject_ids
         * @param int $curriculum_subject_id
         * @param int $curriculum_id
         * @return boolean FALSE if one of insert is failed.
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>  
         */
        private function _insert_also_revesre_as_co_requisite($co_subject_ids, $curriculum_subject_id, $curriculum_id)
        {
                $all_ok             = TRUE;
                /**
                 * get subject_if from $curriculum_subject_id
                 */
                $current_subject_id = $this->Curriculum_subject_model->
                                fields('subject_id')->
                                // set_cache()->
                                get($curriculum_subject_id)->subject_id;
                foreach ($co_subject_ids as $subject_id)
                {
                        /**
                         * get curriculum_subject_id of subject_id where $curriculum_id
                         */
                        $__curriculum_subject_id = $this->Curriculum_subject_model->
                                        fields('curriculum_subject_id')->
                                        where(array(
                                            'subject_id'    => $subject_id,
                                            'curriculum_id' => $curriculum_id,
                                        ))->
                                        // set_cache()->
                                        get()->curriculum_subject_id;
                        $id                      = $this->Requisites_model->insert(array(
                            'subject_id'            => $current_subject_id,
                            'requisite_type'        => 'co',
                            'curriculum_subject_id' => $__curriculum_subject_id,
                            'created_user_id'       => $this->session->userdata('user_id')
                        ));
                        if ( ! $id)
                        {
                                $all_ok = FALSE;
                                break;
                        }
                }
                return $all_ok;
        }

        public function is_atleast_one()
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }
                $this->form_validation->set_message('is_atleast_one', 'Required atleat one {field} field.');
                return ($this->input->post('co', TRUE) OR $this->input->post('pre', TRUE) );
        }

        private function _current_curriculum_subject($curriculum_subject_id)
        {

                /*
                 * Table headers
                 */
                $header     = array(
                    'year level',
                    lang('curriculum_subject_semester_label'),
                    lang('curriculum_subject_subject_label'),
                    lang('curriculum_subject_units_label'),
                    lang('curriculum_subject_lecture_hours_label'),
                    lang('curriculum_subject_laboratory_hours_label'),
                    lang('curriculum_subject_pre_subject_label'),
                    lang('curriculum_subject_co_subject_label')
                );
                $cur_subj   = $this->Curriculum_subject_model->curriculum_subject($curriculum_subject_id);
                $table_data = array();
                if ($cur_subj)
                {
                        $this->load->model('Requisites_model');
                        $requisite    = $this->Requisites_model->subjects(isset($cur_subj->requisites) ? $cur_subj->requisites : NULL);
                        $table_data[] = array(
                            my_htmlspecialchars($cur_subj->curriculum_subject_year_level),
                            my_htmlspecialchars(semesters($cur_subj->curriculum_subject_semester)),
                            my_htmlspecialchars($cur_subj->subject->subject_code),
                            my_htmlspecialchars($cur_subj->curriculum_subject_units),
                            my_htmlspecialchars($cur_subj->curriculum_subject_lecture_hours . ' Hours'),
                            my_htmlspecialchars($cur_subj->curriculum_subject_laboratory_hours . ' Hours'),
                            $requisite->pre,
                            $requisite->co
                        );
                }
                else
                {
                        /**
                         * no reason to reach here, show_error just to make sure.
                         */
                        show_error('no current subject for curriculum: ' . get_class() . ' ' . __FILE__);
                }

                return $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'curriculum_subject_label', FALSE, TRUE);
        }

        /**
         * lets check if ids is really related in relation in database
         * 
         * @param int $cur
         * @param int $cur_subj
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _is_ids_related($cur, $cur_subj)
        {
                if ( ! ((bool) ( $this->Curriculum_subject_model->where(array(
                            'curriculum_id'         => $cur,
                            'curriculum_subject_id' => $cur_subj,
                        ))->count_rows() === 1)))
                {
                        show_error('ids not related');
                }
        }

        /**
         * check if adding Requisite is the same year level and semester
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function is_co_requisite_same_level_and_semester()
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }


                $co = $this->input->post('co[]', TRUE);


                if ($co)
                {
                        $cur_sub_obj        = check_id_from_url('curriculum_subject_id', 'Curriculum_subject_model', 'curriculum-subject-id');
                        $cur_sub_obj_inputs = array();

                        foreach ($co as $subject_id)
                        {
                                $cur_sub_obj_inputs[] = $this->Curriculum_subject_model->
                                        where(array(
                                            'curriculum_id' => $cur_sub_obj->curriculum_id,
                                            'subject_id'    => $subject_id
                                        ))->
                                        with_subject()->
                                        //set_cache()->
                                        get();
                        }

                        /**
                         * check semester and year
                         */
                        $subject_codes = array(); //i used array, its countable
                        foreach ($cur_sub_obj_inputs as $c)
                        {
                                if ( ! ($cur_sub_obj->curriculum_subject_semester == $c->curriculum_subject_semester &&
                                        $cur_sub_obj->curriculum_subject_year_level == $c->curriculum_subject_year_level))
                                {
                                        $subject_codes[] = $c->subject->subject_code; //collect invalid subjects
                                }
                        }

                        if (count($subject_codes) != 0)//there is a invalid?
                        {
                                $subjecs = '';
                                foreach ($subject_codes as $s)
                                {
                                        $subjecs .= $s . ', ';
                                }
                                $msg = '(' . trim($subjecs, ', ') . ') is not in same level or semester in current subject.';
                                $this->form_validation->set_message('is_co_requisite_same_level_and_semester', $msg);

                                return FALSE;
                        }
                }

                /**
                 * not required, just pass the validation
                 */
                return TRUE;
        }

        /**
         * check if adding Requisite is in low year level
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function is_pre_requisite_low_level_and_semester()
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }

                $pre = $this->input->post('pre[]', TRUE);

                if ($pre)
                {
                        $cur_sub_obj        = check_id_from_url('curriculum_subject_id', 'Curriculum_subject_model', 'curriculum-subject-id');
                        $cur_sub_obj_inputs = array();

                        foreach ($pre as $subject_id)
                        {
                                $cur_sub_obj_inputs[] = $this->Curriculum_subject_model->
                                        where(array(
                                            'curriculum_id' => $cur_sub_obj->curriculum_id,
                                            'subject_id'    => $subject_id
                                        ))->
                                        with_subject()->
                                        //set_cache()->
                                        get();
                        }

                        /**
                         * check semester and year
                         */
                        $subject_codes = array(); //i used array, its countable
                        foreach ($cur_sub_obj_inputs as $c)
                        {

                                if ($c->curriculum_subject_year_level < $cur_sub_obj->curriculum_subject_year_level)
                                {
                                        /**
                                         * input is lower level with current subject
                                         */
                                        continue;
                                }
                                if ((int) $c->curriculum_subject_year_level === (int) $cur_sub_obj->curriculum_subject_year_level)
                                {
                                        /**
                                         * same level, so check the semester
                                         */
                                        if ($this->_numeric_semester($c->curriculum_subject_semester) <
                                                $this->_numeric_semester($cur_sub_obj->curriculum_subject_semester))
                                        {
                                                /**
                                                 * input is lower semester with current subject
                                                 */
                                                continue;
                                        }
                                }
                                $subject_codes[] = $c->subject->subject_code; //collect invalid subjects
                        }

                        if (count($subject_codes) != 0)//there is a invalid?
                        {
                                $subjecs = '';
                                foreach ($subject_codes as $s)
                                {
                                        $subjecs .= $s . ', ';
                                }
                                $msg = '(' . trim($subjecs, ', ') . ') is not in lower level or semester in current subject.';
                                $this->form_validation->set_message('is_pre_requisite_low_level_and_semester', $msg);

                                return FALSE;
                        }
                }
                /**
                 * not required
                 */
                return TRUE;
        }

        private function _numeric_semester($tmp)
        {
                $int_semester = NULL;
                switch ($tmp)
                {
                        case 'first':
                                $int_semester = 1;
                                break;
                        case 'second':
                                $int_semester = 2;
                                break;
                        case 'summer':
                                $int_semester = 3;
                                break;
                        default: break;
                }
                return $int_semester;
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
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/fullcalendar.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'css/jquery.gritter.css',
                        'css/jquery.gritter.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/bootstrap-colorpicker.js',
                        'js/bootstrap-datepicker.js',
                        'js/jquery.toggle.buttons.js',
                        'js/masked.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/matrix.js',
                        'js/matrix.form_common.js',
                        'js/wysihtml5-0.3.0.js',
                        'js/jquery.peity.min.js',
                        'js/bootstrap-wysihtml5.js',
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '<script type="text/javascript">
        // This function is called from the pop-up menus to transfer to
        // a different page. Ignore if the value returned is a null string:
        function goPage(newURL) {

            // if url is empty, skip the menu dividers and reset the menu selection to default
            if (newURL != "") {

                // if url is "-", it is this page -- reset the menu:
                if (newURL == "-") {
                    resetMenu();
                }
                // else, send page to designated URL            
                else {
                    document.location.href = newURL;
                }
            }
        }

        // resets the menu selection upon entry to this page:
        function resetMenu() {
            document.gomenu.selector.selectedIndex = 2;
        }
</script>';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
