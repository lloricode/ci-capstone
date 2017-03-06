<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deactivate extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                /**
                 * just to make sure
                 */
                if (!$this->ion_auth->is_admin())
                {
                        show_error(lang('access_denied_of_current_user_group'));
                }
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('administrators_label'), '#');
                $this->breadcrumbs->unshift(3, lang('index_heading'), 'users');
        }

        public function index()
        {
                if (!($id = (int) $this->input->get('user-id')))
                {

                        show_error('Invalid request.');
                }

                $this->breadcrumbs->unshift(3, lang('deactivate_heading'), 'deactivate?user-id=' . $id);
                $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
                $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

                if ($this->form_validation->run() == FALSE)
                {
                        $_user = $this->ion_auth->user($id)->row();
                        if (!$_user)
                        {
                                show_error('Invalid request.');
                        }
                        $this->_form_view($_user);
                }
                else
                {

                        // do we really want to deactivate?
                        if ($this->input->post('confirm', TRUE) == 'yes')
                        {

                                // do we have the right userlevel?
                                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
                                {
                                        if ($this->ion_auth->deactivate($id))
                                        {
                                                /**
                                                 * delete all query cache 
                                                 */
                                                $this->delete_all_query_cache();
                                        }
                                }
                        }
                        $this->session->set_flashdata('message', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->ion_auth->messages())));
                        // redirect them back to the auth page
                        redirect('users', 'refresh');
                }
        }

        private function _form_view($_user)
        {
                $inputs['tmp'] = array(
                    'name'   => 'confirm',
                    'fields' => array(
                        'yes' => 'deactivate_confirm_y_label',
                        'no'  => 'deactivate_confirm_n_label'
                    ),
                    'value'  => $this->form_validation->set_value('confirm'),
                    'type'   => 'radio',
                    'lang'   => array(
                        'main_lang' => 'deactivate_subheading',
                        'sprintf'   => $_user->username
                    )
                );

                $message                       = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->ion_auth->messages()));
                $this->data['deactivate_form'] = $this->form_boostrap('deactivate/?user-id=' . $_user->id, $inputs, $message, 'deactivate_heading', 'deactivate_submit_btn', 'info-sign', array('id' => $_user->id), TRUE);
                $this->data['bootstrap']       = $this->_bootstrap();
                $this->_render('admin/deactivate_user', $this->data);
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
