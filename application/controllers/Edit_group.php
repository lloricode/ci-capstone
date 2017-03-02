<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_group extends CI_Capstone_Controller
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
                $this->breadcrumbs->unshift(3, lang('index_groups_th'), 'groups');
        }

        public function index($id = NULL)
        {


                if (!($id = $this->input->get('group-id')))
                {
                        show_error('Invalid request.');
                }

                $this->breadcrumbs->unshift(3, 'Edit Groups', 'edit-group?group-id=' . $id);
                $this->data['title'] = $this->lang->line('edit_group_title');

                $group = $this->ion_auth->group($id)->row();

                if (!$group)
                {
                        show_error('Invalid request.');
                }
                // validate form input
                $this->form_validation->set_rules(
                        'group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash'
                );

                if ($this->form_validation->run())
                {
                        if ($this->form_validation->run() === TRUE)
                        {
                                $group_update = $this->ion_auth->update_group(
                                        $id, $this->input->post('group_name', TRUE), $this->input->post('group_description', TRUE)
                                );

                                if ($group_update)
                                {
                                        /**
                                         * delete all query cache 
                                         */
                                        $this->delete_all_query_cache();

                                        $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                                }
                                redirect(site_url('users'), 'refresh');
                        }
                }

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                // pass the user to the view
                $this->data['group'] = $group;

                $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

                $this->data['group_name'] = array(
                    'name'  => 'group_name',
                    'id'    => 'group_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('group_name', $group->name),
                );
                if ($readonly != '')
                {
                        $this->data['group_name'] [$readonly] = $readonly;
                }
                $this->data['group_description'] = array(
                    'name'  => 'group_description',
                    'id'    => 'group_description',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('group_description', $group->description),
                );
                $this->data['bootstrap']         = $this->bootstrap();
                $this->_render('admin/edit_group', $this->data);
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
