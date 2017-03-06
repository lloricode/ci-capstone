<?php

/**
 * @author Lloric Mayuga Gracia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Last_logins extends CI_Capstone_Controller
{


        private $page_;
        private $limit;

        function __construct()
        {
                parent::__construct();
                $this->lang->load('ci_capstone/ci_last_logins');
                $this->load->model(array('Users_last_login_model', 'User_model'));
                $this->load->library('pagination');
                /**
                 * pagination limit
                 */
                $this->limit = 10;

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
                $this->breadcrumbs->unshift(2, 'Settings', '#');
                $this->breadcrumbs->unshift(3, lang('last_login_label'), 'last-logins');
        }

        /**
         * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
         */
        public function index()
        {


                $last_login_obj = $this->Users_last_login_model->
                        limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('created_at', 'DESC')->
                        set_cache('last-logins_page_' . $this->page_)->
                        get_all();


                $table_data = array();

                if ($last_login_obj)
                {

                        foreach ($last_login_obj as $last_login)
                        {
                                $user = $this->User_model->get($last_login->user_id);
                                array_push($table_data, array(
                                    my_htmlspecialchars($user->last_name . ', ' . $user->first_name),
                                    my_htmlspecialchars($last_login->ip_address),
                                    my_htmlspecialchars($last_login->agent),
                                    my_htmlspecialchars($last_login->platform),
                                    my_htmlspecialchars(unix_to_human($last_login->created_at)),
                                ));
                        }
                }

                /*
                 * Table headers
                 */
                $header     = array(
                    lang('users_header'),
                    lang('ip_address_header'),
                    lang('agent_header'),
                    lang('platform_header'),
                    lang('time_header')
                );
                $pagination = $this->pagination->generate_bootstrap_link('last-logins/index', $this->Users_last_login_model->count_rows() / $this->limit);

                $this->template['table_data_last_logins'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'user_last_login_capstion_table', $pagination, TRUE);
                $this->template['message']                = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']              = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->_render('admin/last_logins', $this->template);
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
                    'js'  => array(),
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
