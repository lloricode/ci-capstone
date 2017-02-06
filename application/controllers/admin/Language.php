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
                        $this->load->model('Language_model');
                        $data_return = $this->Language_model->where('user_id', $this->ion_auth->user()->row()->id)->get();
                        $lang        = $this->input->post('lang', TRUE);
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
                             //   $this->Language_model->update($data_update, $where);
                                $data['message'] = 'disbled, only english available for now';
                        }
                        else
                        {
                                $insert_data     = array(
                                    'user_id'        => $this->session->userdata('user_id'),
                                    'language_value' => $lang,
                                );
                                //insert
                             //   $this->Language_model->insert($insert_data);
                                $data['message'] = 'disbled, only english available for now';
                        }
                }
                $this->_render_admin_page('admin/lang_view', $data);
        }

}
