<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_user extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                /**
                 * just to make sure
                 */
                if ( ! $this->ion_auth->is_admin())
                {
                        show_error(lang('access_denied_of_current_user_group'));
                }
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->breadcrumbs->unshift(2, lang('administrators_label'), '#');
                $this->breadcrumbs->unshift(3, lang('index_heading'), 'users');
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

                if ( ! ($user_id = $this->input->get('user-id')))
                {
                        show_error('Invalid request.');
                }

                $data['title'] = $this->lang->line('edit_user_heading');



                $user = $this->ion_auth->user($user_id)->row();

                $this->set_hook($user->id);
                if ( ! $user)
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
                        /**
                         * start the DB transaction
                         */
                        $this->db->trans_start();

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
                                        $group_ids = $this->input->post('groups', TRUE);

                                        /**
                                         * if current user has admin group,then remove in edit,
                                         * show error for do not remove admin if current user is admin
                                         */
                                        if ( ! $group_ids)
                                        {
                                                /**
                                                 * make sure atleast one selected 
                                                 */
                                                show_error('empty user_group not allowed.');
                                        }

                                        /**
                                         * if current user
                                         */
                                        if ($this->session->userdata('user_id') == $user->id)
                                        {
                                                //get id of admin from db
                                                $this->load->model('Group_model');
                                                $admin_id = $this->Group_model->where(array('name' => $this->config->item('admin_group', 'ion_auth')))->get()->id;
                                                /**
                                                 * check admin_id if has in post
                                                 */
                                                if ( ! in_array($admin_id, $group_ids))
                                                {
                                                        show_error('cannot remove from admin a current user');
                                                }
                                        }

                                        if (isset($group_ids) && ! empty($group_ids))
                                        {

                                                $this->ion_auth->remove_from_group('', $user_id);

                                                foreach ($group_ids as $grp)
                                                {
                                                        $this->ion_auth->add_to_group($grp, $user_id);
                                                }
                                        }
                                }

                                // check to see if we are updating the user
                                if ($this->ion_auth->update($user->id, $data))
                                {
                                        if ($this->db->trans_commit())
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
                                                if ($this->session->userdata('user_id') == $user->id)
                                                {
                                                        /**
                                                         * refreshing session data of current user
                                                         */
                                                        $this->set_session_data_session(); //from my_controlerr
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
                                }
                                else
                                {
                                        /**
                                         * rollback database
                                         */
                                        $this->db->trans_rollback();

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



                // pass the user to the view
                $data['user']          = $user;
                $data['groups']        = $groups;
                $data['currentGroups'] = $currentGroups;

                $data['first_name']       = array(
                    'name'  => 'first_name',
                    'id'    => 'first_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('first_name', $user->first_name),
                );
                $data['last_name']        = array(
                    'name'  => 'last_name',
                    'id'    => 'last_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('last_name', $user->last_name),
                );
                $data['company']          = array(
                    'name'  => 'company',
                    'id'    => 'company',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('company', $user->company),
                );
                $data['phone']            = array(
                    'name'  => 'phone',
                    'id'    => 'phone',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('phone', $user->phone),
                );
                $data['password']         = array(
                    'name' => 'password',
                    'id'   => 'password',
                    'type' => 'password'
                );
                $data['password_confirm'] = array(
                    'name' => 'password_confirm',
                    'id'   => 'password_confirm',
                    'type' => 'password'
                );
                $data['bootstrap']        = $this->_bootstrap();
                $this->render('admin/edit_user', $data);
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
