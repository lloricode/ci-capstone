<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_group extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($id = NULL) {
        // bail if no group id given
        if (!$id || empty($id) || !is_numeric($id)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        $group = $this->ion_auth->group($id)->row();

//                if(){
//                    
//                }
        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect(base_url('users'), 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );
        $this->my_header_view();
        $this->_render_page('admin/edit_group', $this->data);
        $this->_render_page('admin/footer');
    }

}
