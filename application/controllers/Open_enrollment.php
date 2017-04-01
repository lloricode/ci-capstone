<?php

/**
 * @author Lloric Mayuga Gracia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Open_enrollment extends CI_Capstone_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->breadcrumbs->unshift(2, lang('index_utility_label'), '#');
                $this->breadcrumbs->unshift(3, lang('enrollment_status_label'), 'open-enrollment');
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {
                $data['enabled']   = $this->Enrollment_status_model->status();
                $data['bootstrap'] = $this->_bootstrap();
                $this->render('admin/open_enrollment', $data);
        }

        public function set_disable()
        {
                $this->Enrollment_status_model->insert(array(
                    'status' => FALSE
                ));
                redirect('open-enrollment', 'refresh');
        }

        public function set_enable()
        {
                $this->Enrollment_status_model->insert(array(
                    'status' => TRUE
                ));
                redirect('open-enrollment', 'refresh');
        }

        /**
         * 
         * @return array
         *  @author Lloric Garcia <emorickfighter@gmail.com>
         */
        private function _bootstrap()
        {
                /**
                 * for header
                 * 
                 */
                $header       = array(
                    'css' => array(
                        'css/bootstrap.min.css',
                        'css/bootstrap-responsive.min.css',
                        'css/uniform.css',
                        'css/select2.css',
                        'css/matrix-style.css',
                        'css/matrix-media.css',
                        'font-awesome/css/font-awesome.css',
                        'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',
                    ),
                    'js'  => array(
                    ),
                );
                /**
                 * for footer
                 * 
                 */
                $footer       = array(
                    'css' => array(
                    ),
                    'js'  => array(
                        'js/jquery.min.js',
                        'js/jquery.ui.custom.js',
                        'js/bootstrap.min.js',
                        'js/jquery.uniform.js',
                        'js/select2.min.js',
                        'js/jquery.dataTables.min.js',
                        'js/matrix.js',
                        'js/matrix.tables.js',
                    ),
                );
                /**
                 * footer extra
                 */
                $footer_extra = '';
                return generate_link_script_tag($header, $footer, $footer_extra);
        }

}
