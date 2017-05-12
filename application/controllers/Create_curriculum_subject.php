<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
 *         
 */
class Create_curriculum_subject extends CI_Capstone_Controller
{


        private $type;

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Curriculum_subject_model', 'Curriculum_model', 'Subject_model', 'Course_model', 'Unit_model'));
                $this->load->library('form_validation');
                $this->load->helper(array('school', 'combobox'));
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
        }

        public function index()
        {
                if ($key = $this->input->get('type'))
                {
                        if ($key != 'major' && $key != 'minor')
                        {
                                show_error('invalid type');
                        }
                        $this->type = $key;
                }
                else
                {
                        show_error('missing paramter');
                }

                $curriculum_obj = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id', 'course');

                if ($curriculum_obj->curriculum_status)
                {
                        show_error('Already Enabled');
                }
                if ($curriculum_obj->curriculum_already_used)
                {
                        show_error('Edit is not allowed, Already been used by other data.');
                }

                $this->breadcrumbs->unshift(3, lang('curriculum_subject_label'), 'curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id);
                $this->breadcrumbs->unshift(4, lang('create_curriculum_subject_label') . ' [ ' . $curriculum_obj->course->course_code . ' ]', 'create-curriculum-subject?curriculum-id=' . $curriculum_obj->curriculum_id . '&type=' . $this->type);


                if ($this->input->post('submit', TRUE))
                {
                        /**
                         * start the DB transaction
                         */
                        $this->db->trans_begin();

                        if ( ! $this->_is_subject_course($curriculum_obj->curriculum_id) OR ! $this->_insert_batch_($this->input->post('data'), $curriculum_obj->curriculum_id))
                        {
                                /**
                                 * rollback database
                                 */
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('message', bootstrap_error('curriculum_subject_add_unsuccessfull'));
                        }
                        else
                        {
                                if ($this->db->trans_commit())
                                {

                                        $this->session->set_flashdata('message', bootstrap_success('curriculum_subject_add_successfull'));
                                        redirect(site_url('curriculums/view?curriculum-id=' . $curriculum_obj->curriculum_id), 'refresh');
                                }
                        }
                }
                $this->_form_view($curriculum_obj);
        }

        private function _insert_batch_($datas, $curriculum_id)
        {
                if ($datas)
                {
                        $ok    = TRUE;
                        $index = 0;
                        foreach ($datas as $row)
                        {
                                if ($this->type == 'major')
                                {
                                        $this->form_validation->set_rules($this->Unit_model->insert_validation($index ++ ));
                                }
                                $ok = $this->_insert_one_data((object) $row, $curriculum_id);
                                if ( ! $ok)
                                {
                                        break;
                                }
                                /**
                                 * to not affect next validation
                                 */
                                $this->form_validation->reset_validation();
                        }
                        return $ok;
                }
                return FALSE;
        }

        private function _insert_one_data($row, $curriculum_id)
        {
                if ($this->type == 'major')
                {
                        $unit_ok = $this->form_validation->run();

                        $unit_id = $this->Unit_model->insert(array(
                            'unit_value' => $row->units,
                            'lec_value'  => $row->lecture,
                            'lab_value'  => $row->laboratory
                        ));
                }
                else
                {
                        $unit_ok = TRUE;
                        $unit_id = NULL;
                }
                $id = $this->Curriculum_subject_model->from_form(NULL, array(
                            'curriculum_id' => $curriculum_id,
                            'unit_id'       => $unit_id
                        ))->insert();
                if ($this->type == 'minor')
                {
                        $unit_id = TRUE;
                }

                return (bool) ($unit_ok && $unit_id & $id);
        }

        /**
         * 
         * @return boolean
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function _is_subject_course($curriculum_id)
        {

                $subject_id = $this->input->post('subject', TRUE);

                //select what course_id from subject ELSE GEN-ED
                $subj_obj = $this->Subject_model->get($subject_id);

                // if (is_null($subj_obj->course_id))
                if ($subj_obj->course_id == 0)
                {
//                        $this->session->set_flashdata('message', bootstrap_success(' well done! GEN ED '));
//                        return FALSE; //test return

                        return TRUE;
                }
                $course_id_1 = $subj_obj->course_id;

                //selest what course_id from curriculum
                $course_id_2 = $this->Curriculum_model->get($curriculum_id)->course_id;

                if ($course_id_1 != $course_id_2)
                {
                        $this->session->set_flashdata('message', bootstrap_error('Not the same course.'));
                        return FALSE;
                }
                return TRUE;
//                $this->session->set_flashdata('message', bootstrap_success(' well done! COURSE'));
//                return FALSE; //test return
        }

        /**
         * check if subject is exist in curriculum
         * 
         * @return bool
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function check_subject_in_curiculum()
        {
                if ( ! $this->input->post('submit'))
                {
                        show_404();
                }
                $this->form_validation->set_message('check_subject_in_curiculum', 'Subject Already Added in this Curriculum.');
                return (bool) $this->Curriculum_subject_model->where(array(
                            'subject_id'    => $this->input->post('subject'),
                            'curriculum_id' => $this->input->get('curriculum-id')
                        ))->count_rows() == 0;
        }

        private function _dropdown_for_subjects()
        {

                $subject_ids_obj  = $this->Curriculum_subject_model->
                                fields('subject_id')->
                                where(array(
                                    'curriculum_id' => $this->input->get('curriculum-id')
                                ))->get_all();
                $subject_ids_arry = array();
                if ($subject_ids_obj)
                {
                        foreach ($subject_ids_obj as $v)
                        {
                                $subject_ids_arry[] = $v->subject_id;
                        }
                }


                $return       = array();
                $return[NULL] = 'no subject';
                $subjects_obj = NULL;

                switch ($this->type)
                {
                        case 'major':
                                $where_course = NULL;
                                $string_query = FALSE;
                                if ($curr_id      = $this->input->get('curriculum-id'))
                                {
                                        $course_id    = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id')->course_id;
                                        $where_course = "`course_id` = '$course_id' "; //OR `course_id` = '0' ";
                                        $string_query = TRUE;
                                }

                                $subjects_obj = $this->Subject_model->
                                        where($where_course, NULL, NULL, FALSE, FALSE, $string_query)->
                                        as_dropdown('subject_code')->
                                        order_by('course_id', 'DESC')->
                                        set_cache('as_dropdown_subject_code')->
                                        get_all();
                                break;
                        case 'minor':
                                $subjects_obj = $this->Subject_model->
                                        where(' `unit_id` != \'NULL\'', NULL, NULL, FALSE, FALSE, TRUE/* query string */)->
                                        as_dropdown('subject_code')->
                                        order_by('course_id', 'DESC')->
                                        set_cache('as_dropdown_subject_code')->
                                        get_all();
                                break;
                }


                if ($subjects_obj)
                {
                        foreach ($subjects_obj as $k => $v)
                        {
                                if ( ! in_array($k, $subject_ids_arry))
                                {
                                        $return[$k] = $v;
                                }
                        }
                }

                return $return; // array_merge(array('' => 'no subject'), (array) $subjects_obj);
        }

        private function _form_view($curriculum_obj)
        {


                $inputs['_dropdown_for_subjects']   = $this->_dropdown_for_subjects();
                $inputs['curriculum_id']            = $curriculum_obj->curriculum_id;
                $inputs['type']                     = $this->type;
                $template['curriculum_information'] = MY_Controller::render('admin/_templates/curriculums/curriculum_information', array('curriculum_obj' => $curriculum_obj), TRUE);
//                $template['curriculum_subject_form'] = $this->form_boostrap('create-curriculum-subject?curriculum-id=' . $curriculum_obj->curriculum_id . '&type=' . $this->type, $inputs, 'create_curriculum_subject_label', 'create_curriculum_subject_label', 'info-sign', NULL, TRUE);
                $template['bootstrap']              = $this->_bootstrap();
                $this->render('admin/create_curriculum_subject', array_merge($template, $inputs));
        }

        private function _bootstrap()
        {
                /**
                 * for header
                 */
                $header = array(
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
                        'https://code.jquery.com/jquery-3.2.1.min.js'
                    ),
                );
                /**
                 * for footer
                 */
                $footer = array(
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
                $search = array(
                    '/\>[^\S ]+/s',
                    '/[^\S ]+\</s',
                    '/(\s)+/s',
                    '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s',
                    '/\>(\s)+\</'
                );

                $replace      = array(
                    '>',
                    '<',
                    '\\1',
                    "//&lt;![CDATA[\n" . '\1' . "\n//]]>",
                    '><'
                );
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
</script>
<script type="text/javascript">

function loaddata()
{
     $(\'#newformplease\').html("' . preg_replace($search, $replace, str_replace('"', '\"', $this->load->view('admin/_templates/form_view', array(
                                            'index_iputs'            => 1,
                                            'type'                   => $this->type,
                                            '_dropdown_for_subjects' => $this->_dropdown_for_subjects()
                                                ), TRUE))) . '");
   // alert("hey");
}

</script>
';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
