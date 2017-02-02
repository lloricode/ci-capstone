<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_group extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        }

        public function index($id = NULL)
        {


                if (!($id = $this->input->get('group-id')))
                {
                        show_error('Invalid request.');
                }

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
                                        $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                                }
                                redirect(base_url('admin/users'), 'refresh');
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
                $this->_render_admin_page('admin/edit_group', $this->data);
        }

}
