<?php

defined('BASEPATH') or exit('no direct script allowed');

class MY_Upload extends CI_Upload
{

        public function __construct($config = array())
        {
                parent::__construct($config);
        }

        /**
         * 
         * @param string $_post_image_name
         * @param bool $required - default TRUE
         * @return array | uploaded- bool | error_message -string
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function _preparing_image($_post_image_name, $required = TRUE)
        {
                /**
                 * for image upload
                 */
                $uploaded            = !$required;
                $image_error_message = '';

                if (empty($_FILES[$_post_image_name]['name']) && $required)
                {

                        /*
                         * dear Lloric:
                         * i cant fix later improvement 
                         * trully yours: Lloric.
                         */
                        //  $this->form_validation->set_rules($_post_image_name, lang('index_student_image_th'), 'required');

                        /**
                         * image required
                         * with error delimiter in ion_auth configuration
                         */
                        $image_error_message = $this->_CI->config->item('error_start_delimiter', 'ion_auth') .
                                lang('student_image_required') .
                                $this->_CI->config->item('error_end_delimiter', 'ion_auth');
                }
                /**
                 * check if has error in upload $_FILES[] and pass rule validation
                 */
                if (isset($_FILES[$_post_image_name]['error']) && $_FILES[$_post_image_name]['error'] != 4)
                {
                        /**
                         * now uploading, FALSE in failed
                         */
                        $uploaded = $this->do_upload($_post_image_name);

                        /**
                         * if returned FALSE it means failed/error
                         */
                        if (!$uploaded)
                        {
                                /**
                                 * get error upload message
                                 * with error delimiter in ion_auth config
                                 */
                                $image_error_message = $this->_CI->config->item('error_start_delimiter', 'ion_auth') .
                                        $this->_CI->upload->display_errors() .
                                        $this->_CI->config->item('error_end_delimiter', 'ion_auth');
                        }
                }
                return array(
                    'uploaded'      => $uploaded,
                    'error_message' => $image_error_message
                );
        }

        public function image_resize($img_name)
        {
                $original_dir               = $this->_CI->config->item('student_image_dir');
                $student_image_size_profile = $this->_CI->config->item('student_image_size_profile');
                $student_image_size_table   = $this->_CI->config->item('student_image_size_table');

                $this->_resize($img_name, $original_dir, $student_image_size_profile);
                $this->_resize($img_name, $original_dir, $student_image_size_table);
        }

        private function _resize($img_name, $original_dir, $image_resize_dir)
        {
                $this->_CI->load->library('image_lib');

                /**
                 * for table
                 */
                list($w, $h) = explode('x', str_replace('/', '', $image_resize_dir));

                $new_dir = $original_dir . $image_resize_dir;

                if (!is_dir($new_dir))
                {
                        mkdir($new_dir);
                }
                $config['source_image'] = $original_dir . $img_name;
                $config['create_thumb'] = TRUE;
                $config['width']        = (int) $w;
                $config['height']       = (int) $h;
                $config['new_image']    = $new_dir . $img_name;

                $this->_CI->image_lib->initialize($config);
                $this->_CI->image_lib->resize();
                $this->_CI->image_lib->clear();
        }

}
