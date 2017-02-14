<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deactivate extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->breadcrumbs->unshift(2, 'Users', 'users');
        }

        public function index()
        {
                if (!($id = (int) $this->input->get('user-id')))
                {

                        show_error('Invalid request.');
                }

                $this->breadcrumbs->unshift(3, 'Deactivate User', 'deactivate?user-id=74?user-id=' . $id);
                $this->load->library('form_validation');
                $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
                $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

                if ($this->form_validation->run() == FALSE)
                {
                        $this->data['user'] = $this->ion_auth->user($id)->row();
                        if (!$this->data['user'])
                        {
                                show_error('Invalid request.');
                        }
                        $this->session->set_flashdata('message', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->ion_auth->messages())));
                        $this->data['bootstrap'] = $this->bootstrap();
                        $this->_render_admin_page('admin/deactivate_user', $this->data);
                }
                else
                {

                        // do we really want to deactivate?
                        if ($this->input->post('confirm', TRUE) == 'yes')
                        {

                                // do we have the right userlevel?
                                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
                                {
                                        $this->ion_auth->deactivate($id);
                                }
                        }
                        $this->session->set_flashdata('message', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->ion_auth->messages())));
                        // redirect them back to the auth page
                        redirect('users', 'refresh');
                }
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
