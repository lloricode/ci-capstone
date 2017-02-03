<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_group extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters(
                        $this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth')
                );
        }

        public function index()
        {
                // validate form input
                $this->form_validation->set_rules(array(
                    array(
                        'label' => $this->lang->line('create_group_name_label'),
                        'field' => 'name',
                        'rules' => 'trim|required|alpha_dash',
                    ),
                    array(
                        'label' => $this->lang->line('create_group_desc_label'),
                        'field' => 'desc',
                        'rules' => 'trim|required',
                    )
                ));

                if ($this->form_validation->run())
                {
                        if ($this->ion_auth->create_group(
                                        $this->input->post('name', TRUE), $this->input->post('desc', TRUE)
                                ))
                        {
                                // redirect them back to the admin page
                                $this->session->set_flashdata('message', $this->ion_auth->messages());
                                redirect(current_url(), 'refresh');
                        }
                }

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                $this->data['name'] = array(
                    'name'  => 'name',
                    'id'    => 'name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('name'),
                );
                $this->data['desc'] = array(
                    'name'  => 'desc',
                    'id'    => 'desc',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('desc'),
                );
                $this->_render_admin_page('admin/create_group', $this->data);
        }

}
