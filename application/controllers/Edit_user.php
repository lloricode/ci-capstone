<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_user extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        }

        public function index()
        {

                if (!($user_id = $this->input->get('user-id')))
                {
                        show_error('Invalid request.');
                }

                $this->data['title'] = $this->lang->line('edit_user_heading');



                $user = $this->ion_auth->user($user_id)->row();

                if (!$user)
                {
                        show_error('Invalid request.');
                }
                $groups        = $this->ion_auth->groups()->result_array();
                $currentGroups = $this->ion_auth->get_users_groups($user_id)->result();

                //just 
                // validate form input
                $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required|human_name');
                $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required|human_name');
                $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
                $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim');

                if (isset($_POST) && !empty($_POST))
                {


                        // update the password if it was posted
                        if ($this->input->post('password'))
                        {
                                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|no_space|password_level[3]');
                                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'trim|required');
                        }

                        if ($this->form_validation->run() === TRUE)
                        {
                                $data = array(
                                    'first_name' => $this->input->post('first_name'),
                                    'last_name'  => $this->input->post('last_name'),
                                    'company'    => $this->input->post('company'),
                                    'phone'      => $this->input->post('phone'),
                                );

                                // update the password if it was posted
                                if ($this->input->post('password'))
                                {
                                        $data['password'] = $this->input->post('password');
                                }



                                // Only allow updating groups if user is admin
                                if ($this->ion_auth->is_admin())
                                {
                                        //Update the groups user belongs to
                                        $groupData = $this->input->post('groups');

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
                                        // redirect them back to the admin page if admin, or to the base url if non admin
                                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                                        if ($this->ion_auth->is_admin())
                                        {
                                                redirect(base_url('edit-user/?user-id=' . $user_id), 'refresh');
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

                $this->_render_admin_page('admin/edit_user', $this->data);
        }

}
