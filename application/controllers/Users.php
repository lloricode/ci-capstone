<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_excel');
        }

        public function index()
        {
                // set the flash data error message if there is one
                // $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                //list the users
                $users_obj = $this->ion_auth->users()->result();
                foreach ($users_obj as $k => $user)
                {
                        $users_obj[$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
                }

                $header = array(
                    lang('index_fname_th'),
                    lang('index_lname_th'),
                    lang('index_username_th'),
                    lang('index_groups_th'),
                    lang('index_status_th'),
                    lang('index_action_th'),
                );

                $table_data = array();

                foreach ($users_obj as $user)
                {
                        $groups = '';
                        foreach ($user->groups as $group)
                        {
                                $groups .= anchor("edit-group/index/" . $group->id, my_htmlspecialchars($group->name)) . ' | ';
                        }
                        array_push($table_data, array(
                            my_htmlspecialchars($user->first_name),
                            my_htmlspecialchars($user->last_name),
                            my_htmlspecialchars($user->username),
                            $groups,
                            (($user->active) ? anchor("deactivate/index/" . $user->id, lang('index_active_link')) : anchor("users/activate/" . $user->id, lang('index_inactive_link'))),
                            anchor("edit-user/index/" . $user->id, 'Edit'),
                        ));
                }

                $this->template['create_user_button'] = $this->_render_page('admin/_templates/button_view', array(
                    'href'         => 'create-user',
                    'button_label' => lang('create_user_heading'),
                        ), TRUE);

                $this->template['export_user_button'] = $this->_render_page('admin/_templates/button_view', array(
                    'href'         => 'users/export-excel',
                    'button_label' => lang('excel_export'),
                        ), TRUE);



                $this->data['caption']    = lang('index_heading');
                $this->data['table_data'] = $this->my_table_view($header, $table_data);

                $this->template['table_data_users'] = $this->_render_page('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']       = 'table';


                $this->_render_admin_page('admin/users', $this->template);
        }

        /**
         * Export data
         */
        public function export_excel()
        {
                $titles   = array(
                    lang('index_fname_th'),
                    lang('index_lname_th'),
                    lang('index_email_th'),
                    lang('index_groups_th'),
                    lang('index_status_th'),
                );
                $data_    = array();
                $user_obj = $this->ion_auth->users()->result();
                foreach ($user_obj as $k => $user)
                {
                        $user_obj[$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
                }
                foreach ($user_obj as $k => $user)
                {
                        $groups = '';
                        foreach ($user->groups as $group)
                        {
                                $groups .= $group->name . ' | ';
                        }
                        $data_[] = array(
                            $user->first_name,
                            $user->last_name,
                            $user->email,
                            $groups,
                            ($user->active) ? lang('index_active_link') : lang('index_inactive_link'),
                        );
                }
                $this->load->library('excel');
                // echo print_r($data_);
                $this->excel->make_from_array($titles, $data_);
        }

        /**
         * 
         * @param type $id
         * @param type $code
         */
        public function activate($id, $code = false)
        {
                if ($code !== false)
                {
                        $activation = $this->ion_auth->activate($id, $code);
                }
                else if ($this->ion_auth->is_admin())
                {
                        $activation = $this->ion_auth->activate($id);
                }

                if ($activation)
                {
                        // redirect them to the auth page
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect(base_url('users'), 'refresh');
                }
                else
                {
                        // redirect them to the forgot password page
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect(base_url('users'), 'refresh');
                }
        }

}
