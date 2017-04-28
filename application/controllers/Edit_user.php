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
                if ( ! $this->ion_auth->is_admin())
                {
                        show_error(lang('access_denied_of_current_user_group'));
                }
                if ( ! ($user_id = $this->input->get('user-id')))
                {
                        show_error('Invalid request.');
                }

                $user = $this->ion_auth->user($user_id)->row();

                $this->set_hook($user->id);
                if ( ! $user)
                {
                        show_error('Invalid request.');
                }

                $this->breadcrumbs->unshift(3, 'Edit User [ ' . $user->last_name . ', ' . $user->first_name . ' ]', 'edit-user?user-id=' . $user->id);

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
                                /**
                                 * start the DB transaction
                                 */
                                $this->db->trans_begin();
                                $ion_auth_updated  = FALSE;
                                $removed_all_group = FALSE;
                                $group_updated     = FALSE;

                                $empty_user_group                = FALSE;
                                $remove_as_admin_a_current_admin = FALSE;

                                $updated_dean_course = TRUE;

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
                                        // show_error('empty user_group not allowed.');
                                        $this->session->set_flashdata('message', bootstrap_error('Empty user_group not allowed.'));
                                        $empty_user_group = TRUE;
                                }

                                /**
                                 * if current user
                                 */
                                if ($this->ion_auth->get_user_id() == $user->id && ! $empty_user_group)
                                {
                                        //get id of admin from db
                                        $this->load->model('Group_model');
                                        $admin_id = $this->Group_model->where(array('name' => $this->config->item('admin_group', 'ion_auth')))->get()->id;
                                        /**
                                         * check admin_id if has in post
                                         */
                                        if ( ! in_array($admin_id, $group_ids))
                                        {
                                                //  show_error('cannot remove from admin a current user');
                                                $this->session->set_flashdata('message', bootstrap_error('Cannot remove from admin a current user'));

                                                $remove_as_admin_a_current_admin = TRUE;
                                        }
                                }

                                if ( ! $empty_user_group)
                                {

                                        $removed_all_group = $this->ion_auth->remove_from_group('', $user_id);
                                        if ($removed_all_group)
                                        {
                                                foreach ($group_ids as $grp)
                                                {
                                                        $group_updated = $this->ion_auth->add_to_group($grp, $user_id);
                                                        if ( ! $group_updated)
                                                        {
                                                                break;
                                                        }
                                                }
                                        }

                                        $updated_dean_course = $this->_dean_course_update($group_ids, $user->id);
                                }


                                $new_user_data = array(
                                    'first_name' => $this->input->post('first_name', TRUE),
                                    'last_name'  => $this->input->post('last_name', TRUE),
                                    'company'    => $this->input->post('company', TRUE),
                                    'phone'      => $this->input->post('phone', TRUE),
                                );
                                // update the password if it was posted
                                if ($this->input->post('password', TRUE))
                                {
                                        $new_user_data['password'] = $this->input->post('password', TRUE);
                                }

                                // check to see if we are updating the user
                                $ion_auth_updated = $this->ion_auth->update($user->id, $new_user_data);

                                if ( ! $updated_dean_course OR ! $ion_auth_updated OR ! $removed_all_group OR ! $group_updated OR $remove_as_admin_a_current_admin OR $empty_user_group)
                                {
                                        /**
                                         * rollback database
                                         */
                                        $this->db->trans_rollback();

                                        if ( ! $ion_auth_updated)
                                        {
                                                $this->session->set_flashdata('message', $this->ion_auth->errors());
                                        }
                                        // redirect(site_url('users'), 'refresh'); 
                                }
                                else
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
                                                if ($this->ion_auth->get_user_id() == $user->id)
                                                {
                                                        /**
                                                         * refreshing session data of current user
                                                         */
                                                        $this->set_session_data_session(); //from my_controlerr
                                                }
                                                // redirect them back to the admin page if admin, or to the base url if non admin
                                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                                //redirect(site_url('users'), 'refresh');
                                        }
                                }
                        }
                }
                $this->_form_view($user);
        }

        private function _dean_course_update($selected_group_ids, $user_id)
        {
                /**
                 * delete all first, no dean_id mean also remove all
                 */
                $this->load->model('Dean_course_model');
                $deleted = $this->Dean_course_model->where(array(
                            'user_id' => $user_id
                        ))->delete();
                if ( ! $deleted)
                {
                        $count = $this->Dean_course_model->where(array(
                                    'user_id' => $user_id
                                ))->count_rows();
                        if ($count != 0)
                        {
                                $this->session->set_flashdata('message', bootstrap_error('Failed delete all dean_course on current editing user.'));
                                return FALSE;
                        }
                }

                $this->load->model('Group_model');
                $dean_id = $this->Group_model->where(array('name' => $this->config->item('user_group_dean')))->get()->id;
                if (in_array($dean_id, $selected_group_ids) && count($this->input->post('dean_course[]', TRUE)) != 0)
                {

                        $gen_id = $this->Dean_course_model->insert(array(
                            'user_id'   => $user_id,
                            'course_id' => $this->input->post('dean_course', TRUE)
                        ));
                        if ( ! $gen_id)
                        {
                                $this->session->set_flashdata('message', bootstrap_error('Failed insert dean_course on current editing user.'));
                                return FALSE;
                        }

                        return TRUE;
                }
                else
                {
                        return TRUE; //dean not selected
                }
        }

        private function _form_view($user)
        {
                $groups        = $this->ion_auth->groups()->result_array();
                $currentGroups = $this->ion_auth->get_users_groups($user->id)->result();

                $all_group_id_name = array();
                $current_group_id  = array();

                foreach ($groups as $ag)
                {
                        $all_group_id_name[$ag['id']] = $ag['name'];
                }

                foreach ($currentGroups as $cg)
                {
                        $current_group_id[] = $cg->id;
                }

                $inputs['first_name'] = array(
                    'name'  => 'first_name',
                    'value' => $this->form_validation->set_value('first_name', $user->first_name),
                    'type'  => 'text',
                    'lang'  => 'create_user_fname_label'
                );

                $inputs['last_name'] = array(
                    'name'  => 'last_name',
                    'value' => $this->form_validation->set_value('last_name', $user->last_name),
                    'type'  => 'text',
                    'lang'  => 'create_user_lname_label'
                );

                $inputs['company'] = array(
                    'name'  => 'company',
                    'value' => $this->form_validation->set_value('company', $user->company),
                    'type'  => 'text',
                    'lang'  => 'create_user_company_label'
                );

                $inputs['phone'] = array(
                    'name'  => 'phone',
                    'value' => $this->form_validation->set_value('phone', $user->phone),
                    'type'  => 'text',
                    'lang'  => 'create_user_phone_label'
                );

                $inputs['password'] = array(
                    'name' => 'password',
                    'type' => 'password',
                    'lang' => 'edit_user_password_label'
                );

                $inputs['password_confirm'] = array(
                    'name' => 'password_confirm',
                    'type' => 'password',
                    'lang' => 'edit_user_password_confirm_label'
                );

                $inputs['groups'] = array(
                    'name'       => 'groups[]',
                    'fields'     => $all_group_id_name,
                    'field_lang' => FALSE,
                    'default'    => $current_group_id,
                    'value'      => $this->form_validation->set_value('groups[]'),
                    'type'       => 'checkbox',
                    'lang'       => 'edit_user_groups_heading'
                );


                /**
                 * check if selected group has a dean
                 */
                $this->load->model('Group_model');
                $dean_id = $this->Group_model->where(array('name' => $this->config->item('user_group_dean')))->get()->id;

                $has_dean = FALSE;
                if ( ! $dean_id)
                {
                        show_error('$dean_id not found.');
                }

                if ( ! $this->input->post('groups[]'))
                {
                        $has_dean = in_array($dean_id, $current_group_id);
                }
                else
                {
                        $has_dean = in_array($dean_id, $this->input->post('groups[]'));
                }

                if ($has_dean)
                {
                        $this->load->model(array('Course_model', 'Dean_course_model'));
                        $dean_course_obj = $this->Dean_course_model->where(array(
                                    'user_id' => $user->id
                                ))->get();
                        $course_id       = NULL;
                        if ($dean_course_obj)
                        {
                                $course_id = $dean_course_obj->course_id;
                        }
                        $course_bj      = $this->Course_model->get_all();
                        $course_id_code = array();
                        foreach ($course_bj as $c)
                        {
                                $course_id_code[$c->course_id] = $c->course_code;
                        }

                        $inputs['deancourse'] = array(
                            'name'       => 'dean_course',
                            'fields'     => $course_id_code,
                            'field_lang' => FALSE,
                            'value'      => $this->form_validation->set_value('dean_course', $course_id),
                            'type'       => 'radio',
                            'lang'       => 'dean_course_lebal'
                        );
                }

                $data['edit_user_form'] = $this->form_boostrap('edit-user?user-id=' . $user->id, $inputs, 'edit_user_heading', 'edit_user_submit_btn', 'info-sign', array('id', $user->id), TRUE);
                $data['bootstrap']      = $this->_bootstrap();
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
