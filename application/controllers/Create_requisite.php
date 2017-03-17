<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_requisite extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->load->model('Requisites_model');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
        }

        public function index()
        {
                /**
                 * check either exist or has value given id in url
                 */
                $curriculum_obj         = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id', 'course');
                $curriculum_subject_obj = check_id_from_url('curriculum_subject_id', 'Curriculum_subject_model', 'curriculum-subject-id');

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
                        $id = $this->Requisites_model->from_form(NULL, array(
                                    'created_user_id' => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                echo 'done';
                                // $this->session->set_flashdata('message', lang('create_room_succesfully_added_message'));
                                //redirect(site_url('rooms'), 'refresh');
                        }
                }

                $this->_form_view($curriculum_obj);
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
                if (!((bool) ( $this->Curriculum_subject_model->where(array(
                            'curriculum_id'         => $cur,
                            'curriculum_subject_id' => $cur_subj,
                        ))->count_rows() === 1)))
                {
                        show_error('ids not related');
                }
        }

        /**
         * check if adding Requisite is the same year level
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function is_co_requisite_same_level()
        {
                if (!$this->input->post('submit'))
                {
                        show_404();
                }


                $input_year_level = $this->input->post('level', TRUE);
                $co_requisite     = $this->input->post('co_requisite', TRUE);
                $curriculum_id    = $this->input->post('curriculum', TRUE);
                $semester         = $this->input->post('semester', TRUE);

                /**
                 * required first all the other field to be filled, it will validate first
                 */
                if ($input_year_level && $co_requisite && $semester)
                {
                        /**
                         * get row in $co_requisite in current curriculum
                         */
                        $cur_sub_obj = $this->Curriculum_subject_model->where(array(
                                    //main subject search by co-requisite , to get the year level of input co requsite using the exist subject in curiculum
                                    'subject_id'    => $co_requisite,
                                    'curriculum_id' => $curriculum_id // search in curiculum input
                                ))->set_cache("curriculum_subject_validation_{$co_requisite}_{$curriculum_id}")->get();

                        /**
                         * if has, check the year level of $pre_requisite
                         */
                        if ($cur_sub_obj)
                        {
                                /**
                                 * check if same year level, with input and the result OBJ->year level in model
                                 */
                                if ($cur_sub_obj->curriculum_subject_year_level == $input_year_level)
                                {
                                        /**
                                         * validation pass, so lets also check semester
                                         */
                                        if ($cur_sub_obj->curriculum_subject_semester == $semester)
                                        {
                                                /**
                                                 * accepted
                                                 */
                                                return TRUE;
                                        }
                                        /**
                                         * return FALSE, because, because is not at same semester
                                         */
                                        $this->form_validation->set_message('is_co_requisite_same_level', 'Adding "{field}" must also in same semester.');
                                        return FALSE;
                                }
                                /**
                                 * return FALSE, because, it detect that has a subject BUT not same level
                                 */
                                $this->form_validation->set_message('is_co_requisite_same_level', 'Adding "{field}" must same in current year level.');
                                return FALSE;
                        }
                        /**
                         * no result so no conflict
                         */
                        return TRUE;
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
        public function is_pre_requisite_low_level()
        {
                if (!$this->input->post('submit'))
                {
                        show_404();
                }


                $input_year_level = $this->input->post('level', TRUE);
                $pre_requisite    = $this->input->post('pre_requisite', TRUE);
                $curriculum_id    = $this->input->post('curriculum', TRUE);
                $semester         = $this->input->post('semester', TRUE);

                /**
                 * required first all the other field to be filled, it will validate first
                 */
                if ($input_year_level && $pre_requisite && $semester)
                {
                        /**
                         * check if  $pre_requisite exist in current curriculum
                         */
                        $cur_sub_obj = $this->Curriculum_subject_model->where(array(
                                    //main subject search by $pre_requisite , to get the year level of input co requsite using the exist subject in curiculum
                                    'subject_id'    => $pre_requisite,
                                    'curriculum_id' => $curriculum_id
                                ))->get();

                        /**
                         * if has, check the yeal level of $pre_requisite
                         */
                        if ($cur_sub_obj)
                        {
                                /**
                                 * check lower year, i use <= to include semester, 
                                 */
                                if ($cur_sub_obj->curriculum_subject_year_level <= $input_year_level)
                                {

                                        $int_semester_db    = $this->_numeric_semester($cur_sub_obj->curriculum_subject_semester);
                                        $int_semester_input = $this->_numeric_semester($semester);

                                        if ($int_semester_db < $int_semester_input)
                                        {
                                                /**
                                                 * accepted
                                                 */
                                                return TRUE;
                                        }
                                        /**
                                         * return FALSE, because,not lower in semester
                                         */
                                        $this->form_validation->set_message('is_pre_requisite_low_level', 'Adding "{field}"\'s year must in lower in semester.');
                                        return FALSE;
                                }
                                /**
                                 * return FALSE, because, it detect that has a subject BUT not lower/equal level
                                 */
                                $this->form_validation->set_message('is_pre_requisite_low_level', 'Adding "{field}"\'s year must in lower/equal in current year level.');
                                return FALSE;
                        }
                        /**
                         * no result so no conflict
                         */
                        return TRUE;
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

        private function _form_view($curriculum_obj)
        {
                //load here, not needed in first run
                $this->load->model('Curriculum_subject_model');

                $inputs['requisite_curriculum_subject_id'] = array(
                    'name'  => 'requisite_subject[]',
                    //select subject that belong in current curriculum using curriculum_id
                    'value' => $this->Curriculum_subject_model->subjects_dropdown($curriculum_obj->curriculum_id), //array for dropdown
                    'type'  => 'multiselect',
                    'lang'  => 'requisite_subject_label',
                );

                $inputs['requisite_type'] = array(
                    'name'   => 'type',
                    'fields' => array(
                        'co'  => 'requisite_co_type_label',
                        'pre' => 'requisite_pre_type_label'
                    ),
                    'value'  => $this->form_validation->set_value('type'),
                    'type'   => 'radio',
                    'lang'   => 'requisite_type_label'
                );


                $this->template['info']           = MY_Controller::_render('admin/_templates/curriculums/info', array('curriculum_obj' => $curriculum_obj), TRUE);
                $this->template['requisite_form'] = $this->form_boostrap('create-requisite?curriculum-id=1&curriculum-subject-id=1', $inputs, 'create_requisite_label', 'create_requisite_label', 'info-sign', NULL, TRUE);
                $this->template['bootstrap']      = $this->_bootstrap();
                $this->_render('admin/create_requisite', $this->template);
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
