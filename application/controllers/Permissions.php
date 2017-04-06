<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Capstone_Controller
{

//        private $page_;
//        private $limit;

        function __construct()
        {
                parent::__construct();

                /**
                 * just to make sure
                 */
                if ( ! $this->ion_auth->is_admin())
                {
                        show_error(lang('access_denied_of_current_user_group'));
                }
                $this->load->model('Group_model');
                $this->load->library('pagination');

                /**
                 * pagination limit
                 */
                // $this->limit = 10;

                /**
                 * get the page from url
                 * 
                 */
                $this->page_ = get_page_in_url();
                $this->breadcrumbs->unshift(2, 'Settings', '#');
                $this->breadcrumbs->unshift(3, lang('permission_label'), 'permissions');
        }

        /**
         * 
         * @author Lloric Mayuga Garcia <pojinkee1@gmail.com>
         * @version 2017-2-12
         */
        public function index()
        {
                $this->main();
        }

        private function main($controller_obj = NULL)
        {
                $controllers_obj = $this->Controller_model->
                        //  limit($this->limit, $this->limit * $this->page_ - $this->limit)->
                        order_by('controller_description', 'ASC')->
                        set_cache('controllers_all'/* . $this->page_ */)->
                        get_all();
                $table_data      = array();
                if ($controllers_obj)
                {
                        foreach ($controllers_obj as $c)
                        {
                                $permission_obj = $this->Permission_model->
                                        set_cache('permission_controllers_' . $c->controller_id)->
                                        get_all(array(
                                    'controller_id' => $c->controller_id
                                ));
                                $gruops         = NULL;
                                if ($permission_obj)
                                {
                                        foreach ($permission_obj as $p)
                                        {
                                                $group_obj = $this->Group_model->
                                                        set_cache('permission_group_' . $p->group_id)->
                                                        get_all(array(
                                                    'id' => $p->group_id
                                                ));
                                                if ($group_obj)
                                                {
                                                        foreach ($group_obj as $g)
                                                        {
                                                                $gruops .= anchor("edit-group/?group-id=" . $g->id, ('<button class="btn btn-mini pending">' . $g->name . '</button>'));
                                                        }
                                                }
                                        }
                                }
                                if ( ! $gruops)
                                {
                                        $gruops = 'no permission to all';
                                }
                                if ($c->controller_admin_only)
                                {
                                        $edit = '--';
                                }
                                else
                                {
                                        $edit = anchor(site_url('permissions/edit?controller-id=' . $c->controller_id), '<button class="btn btn-mini pending">Edit</button>');
                                }
                                $table_data[] = array(
                                    my_htmlspecialchars($c->controller_name),
                                    my_htmlspecialchars($c->controller_description),
                                    $gruops,
                                    my_htmlspecialchars(($c->controller_admin_only) ? 'admin only' : 'no'),
                                    my_htmlspecialchars(($c->controller_enrollment_open) ? 'yes' : 'no'),
                                    $edit
                                );
                        }
                }


                /*
                 * Table headers
                 */
                $header = array(
                    array('data' => 'Controllers', 'colspan' => '2'),
                    'Users Group',
                    'admin only',
                    'enrollment',
                    'Option'
                );
                /**
                 * table of users ready,
                 * 
                 */
                /**
                 * templates for group controller
                 */
                if ($controller_obj)
                {
                        $this->data['controller_obj'] = $controller_obj;
                        if ($controller_obj->controller_admin_only)
                        {
                                $this->template['permission_form'] = MY_Controller::render('admin/_templates/permission/invalid', $this->data, TRUE);
                        }
                        else
                        {
                                $this->template['permission_form'] = MY_Controller::render('admin/_templates/permission/edit', $this->data, TRUE);
                        }
                }

                $this->template['table_permissions'] = $this->table_bootstrap($header, $table_data, 'table_open_bordered', 'permission_label', FALSE, TRUE);
                $this->template['message']           = (($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->template['bootstrap']         = $this->_bootstrap();
                /**
                 * rendering users view
                 */
                $this->render('admin/permission', $this->template);
        }

        public function edit()
        {
                $controller_obj = check_id_from_url('controller_id', 'Controller_model', 'controller-id');

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span> ');
                $this->form_validation->set_rules(array(
                    array(
                        'label' => 'Group',
                        'field' => 'groups[]',
                        'rules' => 'trim',
                    ),
                ));
                $this->load->library('permission');
                if ($this->form_validation->run() && ! $controller_obj->controller_admin_only)//double check maybe user use ctrl + u to edit html output
                {


                        $groupData = $this->input->post('groups', TRUE);
                        $done      = FALSE;
                        $done      = $this->permission->controller_remove_all_group($controller_obj->controller_id);
                        if (isset($groupData) && ! empty($groupData))
                        {


                                foreach ($groupData as $g_id)
                                {
                                        $done = $this->permission->add_permision($controller_obj->controller_id, $g_id);

                                        if ( ! $done)
                                        {
                                                break;
                                        }
                                }
                        }
                        $this->session->set_flashdata('message', ($done) ? 'Updated!' : 'Failed!');
                }
                $this->main($controller_obj);
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
