<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_room extends CI_Capstone_Controller
{


        private $data;

        function __construct()
        {
                parent::__construct();
                $this->load->model('Room_model');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
                $this->breadcrumbs->unshift(2, lang('index_utility_label'), '#');
                $this->breadcrumbs->unshift(3, lang('create_room_heading'), 'create-room');
        }

        public function index()
        {
                /**
                 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                 *         
                 */
                if ($this->input->post('submit'))
                {
                        $id = $this->Room_model->from_form(NULL, array(
                                    'created_user_id' => $this->session->userdata('user_id')
                                ))->insert();
                        if ($id)
                        {
                                $this->session->set_flashdata('message', lang('create_room_succesfully_added_message'));
                                redirect(site_url('rooms'), 'refresh');
                        }
                }

                $this->_form_view();
        }

        private function _form_view()
        {

                $inputs['room_number'] = array(
                    'name'  => 'number',
                    'value' => $this->form_validation->set_value('number'),
                    'type'  => 'text',
                    'lang'  => 'create_room_number_label'
                );

                $this->data['room_form'] = $this->form_boostrap('create-room', $inputs, 'create_room_heading', 'create_room_submit_button_label', 'info-sign', NULL, TRUE);
                $this->data['bootstrap'] = $this->_bootstrap();
                $this->render('admin/create_room', $this->data);
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
                $header = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/colorpicker.css',
                        'css/datepicker.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'css/bootstrap-wysihtml5.css',
                        'font-awesome/css/font-awesome.css" rel="stylesheet',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    /**
                     * wizard
                     */
//                        'css/bootstrap.min.css',
//                        'css/bootstrap-responsive.min.css',
//                        'css/matrix-style.css',
//                        'css/matrix-media.css',
//                        'font-awesome/css/font-awesome.css',
//                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    /**
                     * addition for form
                     */
//                        'css/colorpicker.css',
//                        'css/datepicker.css',
//                        'css/uniform.css',
//                        'css/select2.css',
//                        'css/bootstrap-wysihtml5.css',
                    ),
                    'js'  => array(
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
                        /**
                         * wizard
                         * 
                         */
//                        'js/jquery.min.js',
//                        'js/jquery.ui.custom.js',
//                        'js/bootstrap.min.js',
//                        'js/jquery.validate.js',
//                        'js/jquery.wizard.js',
//                        'js/matrix.js',
                        /*
                         * for frontend validation
                         */
                        site_url('assets/framework/bootstrap/admin/matrixwizard.js'),
                    /**
                     * addition for form
                     */
//                        'js/bootstrap-colorpicker.js',
//                        'js/bootstrap-datepicker.js',
//                        'js/jquery.toggle.buttons.js',
//                        'js/masked.js',
//                        'js/jquery.uniform.js',
//                        'js/select2.min.js',
//                        'js/matrix.form_common.js',
//                        'js/wysihtml5-0.3.0.js',
//                        'js/jquery.peity.min.js',
//                        'js/bootstrap-wysihtml5.js',
                    ),
                );
                /**
                 * footer extra
                 */
                /**
                 * addition for form
                 */
//                $footer_extra = "<script>
//                        $('.textarea_editor').wysihtml5();
//                </script>";

                $footer_extra = "<script>
	$('.textarea_editor').wysihtml5();
</script>";
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
