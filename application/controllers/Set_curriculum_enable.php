<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Set_curriculum_enable extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model('Curriculum_subject_model');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('curriculum_label'), 'curriculums');
        }

        public function index()
        {
                $curriculum_obj = check_id_from_url('curriculum_id', 'Curriculum_model', 'curriculum-id', 'course');

                if ($curriculum_obj->curriculum_status)
                {
                        show_error('Already Enabled');
                }
//                if ($curriculum_obj->curriculum_already_used)
//                {
//                        show_error('Edit is not allowed, Already been used by other data.');
//                }

                $this->breadcrumbs->unshift(3, lang('enable_curriculum_label'), 'set-curriculum-enable?curriculum-id=' . $curriculum_obj->curriculum_id);
                $this->form_validation->set_rules('confirm', lang('enable_curriculum_confirm_label'), 'required');

                if ($this->form_validation->run())
                {
                        // do we really want to enable?
                        if ($this->input->post('confirm', TRUE) == 'yes')
                        {
                                $this->config->load('admin/curriculum_subject', TRUE);
                                /**
                                 * start the DB transaction
                                 */
                                $this->db->trans_begin();


                                /**
                                 * disable with same course_id
                                 */
                                $data_disable = array(
                                    'curriculum_status' => '0', //FALSE
                                    'course_id'         => $curriculum_obj->course->course_id
                                );
                                $updated2     = $this->Curriculum_model->update($data_disable, 'course_id');

                                $data        = array(
                                    'curriculum_id'           => $curriculum_obj->curriculum_id,
                                    'curriculum_status'       => TRUE,
                                    'curriculum_already_used' => TRUE
                                );
                                $updated     = $this->Curriculum_model->update($data, 'curriculum_id');
                                $is_has_subj = $this->Curriculum_subject_model->is_has_subject($curriculum_obj->curriculum_id);

                                $min_unit = $this->_check_minimum_units();
                                $gen_ed_minimum = $this->_check_all_gen_ed_minimum_unit();
                                if ( ! $gen_ed_minimum OR ! $min_unit OR ! $updated OR ! $updated2 OR ! $is_has_subj)
                                {
                                        /**
                                         * rollback database
                                         */
                                        $this->db->trans_rollback();
                                        if ( ! $gen_ed_minimum)
                                        {
                                                $this->session->set_flashdata('message', bootstrap_error('Minimum Gen Ed exceed.'));
                                        }
                                        elseif ( ! $min_unit)
                                        {
                                                $this->session->set_flashdata('message', bootstrap_error('Below Minimum Unit is not allowed.'));
                                        }
                                        elseif ( ! $is_has_subj)
                                        {

                                                $this->session->set_flashdata('message', bootstrap_error('no_subjects_in_curriculum'));
                                        }
                                }
                                else
                                {
                                        if ($this->db->trans_commit())
                                        {
                                                $this->session->set_flashdata('message', bootstrap_success('enable_curriculum_confirm_success'));
                                        }
                                }
                        }
                        redirect('curriculums?view=all', 'refresh');
                }
                $this->_form_view($curriculum_obj);
        }

        //TRUE on success/valid
        private function _check_all_gen_ed_minimum_unit()
        {
                //get unit limit config
                $config_min = $this->config->item('minimum_total_gen_ed_units', 'admin/curriculum_subject');

                $total_unit = $this->Curriculum_model->get_total_units_all_gen_eds($this->input->get('curriculum-id'));
                return (bool) ($config_min <= $total_unit);
        }
        //TRUE on success/valid
        private function _check_minimum_units()
        {

                //get unit limit config
                $first_min   = $this->config->item('first_semester_min_unit_limit', 'admin/curriculum_subject');
                $second_min = $this->config->item('second_semester_min_unit_limit', 'admin/curriculum_subject');
                $summer_min  = $this->config->item('summer_semester_min_unit_limit', 'admin/curriculum_subject');



                $unit_obj = $this->Curriculum_model->get_all_term_units($this->input->get('curriculum-id', TRUE));

                $first_ok  = FALSE;
                $second_ok = FALSE;
                $summer_ok = FALSE;
                
                if ($unit_obj)
                {
                        foreach ($unit_obj as $row)
                        {
                                ${$row->sem . '_ok'} = TRUE;
                                if (${$row->sem . '_min'} < $row->unit)
                                {
                                        return FALSE;
                                }
                        }
                        //double check if all term checked
                        return (bool) ($first_ok && $second_ok && $summer_ok);
                }
                return FALSE;
        }

        private function _form_view($curriculum_obj)
        {
                $inputs['tmp'] = array(
                    'name'   => 'confirm',
                    'fields' => array(
                        'yes' => 'enable_curriculum_confirm_y_label',
                        'no'  => 'enable_curriculum_confirm_n_label'
                    ),
                    'value'  => $this->form_validation->set_value('confirm'),
                    'type'   => 'radio',
                    'lang'   => array(
                        'main_lang' => 'enabling_curriculum_subheading',
                        'sprintf'   => $curriculum_obj->course->course_code . ' ' . $curriculum_obj->curriculum_effective_school_year
                    )
                );

                $data['deactivate_form'] = $this->form_boostrap('set-curriculum-enable?curriculum-id=' . $curriculum_obj->curriculum_id, $inputs, 'enable_curriculum_label', 'enable_curriculum_label', 'info-sign', NULL, TRUE);
                $data['bootstrap']       = $this->_bootstrap();
                $this->render('admin/deactivate_user', $data);
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
