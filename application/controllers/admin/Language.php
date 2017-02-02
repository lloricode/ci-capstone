<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                //loader all needed
                $this->load->helper('combobox');
                $this->load->library('form_validation');
        }

        public function index()
        {
                $data['lang_chooser'] = my_lang_combo();
                $data['message']      = '';


                //get all valid input to be sure

                $rule_input = 'in_list[';
                foreach (my_lang_combo() as $k => $v)
                {
                        $rule_input .= $k . ',';
                }

                //end of rules string

                $rule_input .= ']';


                $this->form_validation->set_rules('lang', lang('change_lang_combo_label'), 'required|' . $rule_input);


                if ($this->form_validation->run())
                {
                        //no need to load, its already in my_controller
                        //   $this->load->model('Language_Model');
                        $data_return = $this->Language_model->where('user_id', $this->session->userdata('user_id'))->get();
                        $lang        = $this->input->post('lang');
                        if ($data_return)
                        {

                                //update
                                $data_update     = array(
                                    'language_value' => $lang
                                );
                                $where           = array(
                                    'language_id' => $data_return->language_id,
                                    'user_id'     => $this->session->userdata('user_id'),
                                );
                                $this->Language_model->update($data_update, $where);
                                $data['message'] = 'updated';
                        }
                        else
                        {
                                //insert
                                $this->Language_Model->set_user_language($lang);
                                $data['message'] = 'submitted';
                        }
                }
                $this->_render_admin_page('admin/lang_view', $data);
        }

}
