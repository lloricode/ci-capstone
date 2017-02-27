<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_user extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('index_heading'), 'users');
        }

        private function set_hook($user_id)
        {
                /**
                 * set hook for add data in update_at, after success updating data
                 */
                $this->ion_auth->set_hook(
                        'post_update_user_successful', 'update_at', $this/* $this because the class already extended */, 'add_update_at_data_user_column', array($this->ion_auth_model->tables['users'], $user_id)
                );
        }

        public function index()
        {

                if (!($user_id = $this->input->get('user-id')))
                {
                        show_error('Invalid request.');
                }

                $this->data['title'] = $this->lang->line('edit_user_heading');



                $user = $this->ion_auth->user($user_id)->row();

                $this->set_hook($user->id);
                if (!$user)
                {
                        show_error('Invalid request.');
                }

                $this->breadcrumbs->unshift(3, 'Edit User [ ' . $user->last_name . ', ' . $user->first_name . ' ]', 'edit-user?user-id=' . $user->id);

                $groups        = $this->ion_auth->groups()->result_array();
                $currentGroups = $this->ion_auth->get_users_groups($user->id)->result();

                //just 
                // validate form input
                $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required|human_name');
                $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required|human_name');
                $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
                $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

                if ($this->form_validation->run())
                {


                        // update the password if it was posted
                        if ($this->input->post('password', TRUE))
                        {
                                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|no_space|password_level[3]');
                                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'trim|required');
                        }

                        if ($this->form_validation->run() === TRUE)
                        {
                                $data = array(
                                    'first_name' => $this->input->post('first_name', TRUE),
                                    'last_name'  => $this->input->post('last_name', TRUE),
                                    'company'    => $this->input->post('company', TRUE),
                                    'phone'      => $this->input->post('phone', TRUE),
                                );

                                // update the password if it was posted
                                if ($this->input->post('password', TRUE))
                                {
                                        $data['password'] = $this->input->post('password', TRUE);
                                }



                                // Only allow updating groups if user is admin
                                if ($this->ion_auth->is_admin())
                                {
                                        //Update the groups user belongs to
                                        $groupData = $this->input->post('groups', TRUE);

                                        if (isset($groupData) && !empty($groupData))
                                        {

                                                $this->ion_auth->remove_from_group('', $user_id);

                                                foreach ($groupData as $grp)
                                                {
                                                        $this->ion_auth->add_to_group($grp, $user_id);
                                                }
                                        }
                                }

                                // check to see if we are updating the user
                                if ($this->ion_auth->update($user->id, $data))
                                {
                                        /**
                                         * delete all query cache 
                                         */
                                        $this->load->model('User_model');
                                        $this->User_model->delete_cache();
                                        /**
                                         * refresh session data
                                         * if edit from current user
                                         */
                                        $user_obj = $this->ion_auth->user()->row();
                                        if ($user_obj->id == $user->id)
                                        {
                                                $this->session->set_userdata(array(
                                                    'user_first_name' => $user_obj->first_name,
                                                    'user_last_name'  => $user_obj->last_name
                                                ));
                                        }
                                        // redirect them back to the admin page if admin, or to the base url if non admin
                                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                                        if ($this->ion_auth->is_admin())
                                        {
                                                redirect(site_url('users'), 'refresh');
                                        }
                                        else
                                        {
                                                redirect('/', 'refresh');
                                        }
                                }
                                else
                                {
                                        // redirect them back to the admin page if admin, or to the base url if non admin
                                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                                        if ($this->ion_auth->is_admin())
                                        {
                                                redirect('auth', 'refresh');
                                        }
                                        else
                                        {
                                                redirect('/', 'refresh');
                                        }
                                }
                        }
                }


                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                // pass the user to the view
                $this->data['user']          = $user;
                $this->data['groups']        = $groups;
                $this->data['currentGroups'] = $currentGroups;

                $this->data['first_name']       = array(
                    'name'  => 'first_name',
                    'id'    => 'first_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('first_name', $user->first_name),
                );
                $this->data['last_name']        = array(
                    'name'  => 'last_name',
                    'id'    => 'last_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('last_name', $user->last_name),
                );
                $this->data['company']          = array(
                    'name'  => 'company',
                    'id'    => 'company',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('company', $user->company),
                );
                $this->data['phone']            = array(
                    'name'  => 'phone',
                    'id'    => 'phone',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('phone', $user->phone),
                );
                $this->data['password']         = array(
                    'name' => 'password',
                    'id'   => 'password',
                    'type' => 'password'
                );
                $this->data['password_confirm'] = array(
                    'name' => 'password_confirm',
                    'id'   => 'password_confirm',
                    'type' => 'password'
                );
                $this->data['bootstrap']        = $this->bootstrap();
                $this->_render('admin/edit_user', $this->data);
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
