<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller
{


        private $page_;
        private $limit;
        private $total_rows;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_excel');
                $this->load->model('User_model');

                /**
                 * pagination limit
                 */
                $this->limit      = 10;
                /**
                 * get total rows in users table (no where| all data)
                 */
                $this->total_rows = $this->User_model->total_rows();

                /**
                 * default page
                 */
                $this->page_ = 1;
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {

                /**
                 * get the page from url
                 * 
                 * if has not, default $page will is
                 */
                if ($this->uri->segment(3))
                {
                        $this->page_ = ($this->uri->segment(3));
                }
                // set the flash data error message if there is one
                // $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                //list the users
                $users_obj = $this->User_model->limit($this->limit, $this->limit * $this->page_ - $this->limit)->get_all();

                /**
                 * check if has a result
                 * 
                 * sometime pagination can replace a page that has no value by crazy users :)
                 */
                if (!$users_obj)
                {
                        show_error('Invalid request');
                }

                foreach ($users_obj as $k => $user)
                {
                        $users_obj[$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
                }

                /**
                 * where data array from db stored
                 */
                $table_data = array();

                foreach ($users_obj as $user)
                {
                        $groups = '';
                        foreach ($user->groups as $group)
                        {
                                $groups .= anchor("edit-group/?group-id=" . $group->id, my_htmlspecialchars($group->name)) . ' | ';
                        }
                        array_push($table_data, array(
                            my_htmlspecialchars($user->first_name),
                            my_htmlspecialchars($user->last_name),
                            my_htmlspecialchars($user->username),
                            $groups,
                            (($user->active) ? anchor("deactivate/?user-id=" . $user->id, lang('index_active_link')) : anchor("users/activate/" . $user->id, lang('index_inactive_link'))),
                            anchor("edit-user/?user-id=" . $user->id, 'Edit'),
                        ));
                }


                /*
                 * preparing html table
                 */
                /*
                 * header
                 */
                $header = array(
                    lang('index_fname_th'),
                    lang('index_lname_th'),
                    lang('index_username_th'),
                    lang('index_groups_th'),
                    lang('index_status_th'),
                    lang('index_action_th'),
                );

                /**
                 * table values
                 */
                $this->data['table_data'] = $this->my_table_view($header, $table_data, 'table_open_bordered');

                /**
                 * pagination
                 */
                $this->data['pagination'] = $this->pagination();

                /**
                 * caption of table
                 */
                $this->data['caption'] = lang('index_heading');


                /**
                 * table of users ready,
                 * so whole html table with datas passing as var table_data_users
                 */
                /**
                 * templates for users controller
                 */
                $this->template['table_data_users']   = $this->_render_page('admin/_templates/table', $this->data, TRUE);
                $this->template['controller']         = 'table';
                $this->template['create_user_button'] = $this->_render_page('admin/_templates/button_view', array(
                    'href'         => 'create-user',
                    'button_label' => lang('create_user_heading'),
                        ), TRUE);
                $this->template['export_user_button'] = $this->_render_page('admin/_templates/button_view', array(
                    'href'         => 'users/export-excel',
                    'button_label' => lang('excel_export'),
                        ), TRUE);

                /**
                 * rendering users view
                 */
                $this->_render_admin_page('admin/users', $this->template);
        }

        /**
         * complete pagination
         * 
         * @return string pagination '<ul><li><a></a></li></ul>'
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        private function pagination()
        {
                $config = array(
                    'base_url'         => base_url('users/index'),
                    'total_rows'       => $this->total_rows / $this->limit,
                    'per_page'         => 1,
                    'use_page_numbers' => TRUE,
                    'num_links'        => 3, // lesft&right - link number
                    'full_tag_open'    => '<ul>',
                    'full_tag_close'   => '</ul>',
                    'cur_tag_open'     => '<li class="active"><a href="#">',
                    'cur_tag_close'    => '</a></li>',
                    'next_link'        => 'Next',
                    'prev_link'        => 'Previous',
                    'uri_segment'      => 3,
                    'first_tag_open'   => '<li>',
                    'first_tag_close'  => '</li>',
                    'last_tag_open'    => '<li>',
                    'last_tag_close'   => '</li>',
                    'next_tag_open'    => '<li>',
                    'next_tag_close'   => '</li>',
                    'prev_tag_open'    => '<li>',
                    'prev_tag_close'   => '</li>',
                    'first_tag_open'   => '<li>',
                    'first_tag_close'  => '</li>',
                    'num_tag_open'     => '<li>',
                    'num_tag_close'    => '</li>'
                );
                $this->load->library('pagination');
                $this->pagination->initialize($config);

                /**
                 * attributes in pagination
                 */
                $pagination_attributes = array(
                );

                /**
                 * generate list into <ul></ul> then return | it depend on configuration of pagination
                 */
                return $this->pagination->create_links();
        }

        /**
         * Export data
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
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
         * @author ion_auth
         */
        public function activate($id = NULL, $code = false)
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
