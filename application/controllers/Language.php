<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();

                //loader all needed
                $this->load->helper('combobox');
                $this->load->library('form_validation');
                $this->breadcrumbs->unshift(2, 'Settings', '#');
                $this->breadcrumbs->unshift(3, 'Language', 'language');
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
                $data['bootstrap'] = $this->bootstrap();
                $this->_render('admin/lang_view', $data);
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function bootstrap()
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
