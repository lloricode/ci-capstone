<?php
/**
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<!-- ' . $this->benchmark->elapsed_time() . ' -->';
/*
 *
 * MY CONSTANT
 * 
 */
const MENU_ITEM_DEFAULT = 'home';
const HOME_REDIRECT = ''; // sample    admin/

/**
 * replace '_' to '-' in controller, to prevent error in navigation
 */
$segment__  = str_replace('_', '-', $this->uri->segment($this->config->item('segment_controller'))); //base_url 0,
$main_sub   = '';
/**
 * navigation
 */
$menu_items = $navigations;


$active_link  = TRUE;
// Determine the current menu item.
$menu_current = MENU_ITEM_DEFAULT;
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($segment__, $menu_items))
{
        $menu_current = $segment__;
}
if (MENU_ITEM_DEFAULT == $menu_current)
{
        foreach ($menu_items as $key => $item)
        {
                if (isset($item['sub']))
                {
                        if (@array_key_exists($segment__, $item['sub']))
                        {

                                $main_sub     = $key;
                                $menu_current = $segment__;


                                foreach ($item['sub'] as $k => $v)
                                {
                                        if ($menu_current == $k)
                                        {
                                                $active_link = $v['seen'];
                                        }
                                }
                                break;
                        }
                }
        }
}

$label     = html_escape(((isset($menu_items[$menu_current]['label'])) ? $menu_items[$menu_current]['label'] : $menu_items[$main_sub]['label']));
$sub_label = html_escape(((isset($menu_items[$menu_current]['label'])) ? '' : $menu_items[$main_sub]['sub'][$segment__]['label']));
echo doctype();
?>
<html lang="en">
    <head>
        <title><?php echo ($sub_label != '') ? $sub_label : $label; ?> | <?php echo $this->config->item('project_title'); ?></title>
        <meta charset="<?php echo $this->config->item('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <?php echo link_tag($this->config->item('tab_icon_logo'), 'shortcut icon', 'image/ico'); ?>
        <?php
        /**
         * echo generated link/script tags
         */
        echo $bootstrap['header'];
        ?>

    </head>
    <body>

        <!--Header-part-->
        <div id="header">
            <?php echo heading(anchor(HOME_REDIRECT, $this->config->item('project_title'))); ?>
        </div>
        <!--close-Header-part--> 


        <!--top-Header-menu-->
        <div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav">
                <li  class="dropdown" id="profile-messages" >
                    <?php
                    echo anchor('#', '<i class="icon icon-user"></i><span class="text"> ' . $user_info . ' </span><b class="caret"></b>', array(
                        'title'       => '',
                        'data-toggle' => 'dropdown',
                        'data-target' => '#profile-messages',
                        'class'       => 'dropdown-toggle'
                    ));
                    ?>
                    <ul class="dropdown-menu">
                        <?php if (in_array('edit-user', permission_controllers())): ?>
                                <li>
                                    <?php echo anchor('edit-user?user-id=' . $this->ion_auth->get_user_id(), '<i class="icon-user"></i> Profile</a>'); ?>
                                </li>
                        <?php endif; ?>
                        <li>
                            <?php echo anchor('auth/logout', ' <i class="icon-key"></i> Log Out</a>'); ?>
                        </li>
                    </ul>
                </li>
                <li class="dropdown" id="menu-messages">
                    <?php
                    echo anchor('#', ' <i class="icon icon-flag"></i><span class="text"> ' . lang('lang_label') . ' </span><b class="caret"></b>', array(
                        'title'       => '',
                        'data-toggle' => 'dropdown',
                        'data-target' => '#menu-messages',
                        'class'       => 'dropdown-toggle'
                    ));
                    ?>
                    <ul class="dropdown-menu">
                        <?php foreach (lang_array_() as $k => $v): ?>  
                                <li class="divider"></li>
                                <li>
                                    <?php echo anchor($this->lang->switch_uri($k), $v, array('class' => 'sAdd')); ?>
                                </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php if (ENVIRONMENT === 'development'): ?>
                        <li class="">
                            <a title="">
                                <i class="icon icon-bolt"></i> 
                                <span class="text">
                                    {elapsed_time}
                                </span>
                                <i class="icon icon-leaf"></i> 
                                <span class="text">
                                    {memory_usage}
                                </span>
                                <i class="icon icon-beaker"></i> 
                                <span class="text">
                                    <?php echo CI_VERSION; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a title="">
                                <i class="icon icon-magic"></i> 
                                <span class="text">
                                    <?php echo my_htmlspecialchars(ucfirst(ENVIRONMENT)); ?>
                                </span>
                            </a>
                        </li>
                <?php else: echo comment_tag('CI_VERSION: ' . CI_VERSION); ?>
                <?php endif; ?>
            </ul>
        </div>
        <!--close-top-Header-menu-->
        <!--start-top-serch-->
        <div id="search">
            <?php echo $search_form; ?>
        </div>
        <!--close-top-serch-->
        <!--sidebar-menu-->
        <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
            <?php echo sidebar_menu_ci_capstone($menu_current, $main_sub); ?>
        </div>
        <!--sidebar-menu-->

        <!--main-container-part-->
        <div id="content">

            <div id="content-header">
                <?php
                echo $this->breadcrumbs->show();

                echo(($sub_label != '') ? heading($sub_label) : (MENU_ITEM_DEFAULT == $label) ? heading($label) : '' );
                /**
                 * messages
                 */
                if ($this->ion_auth->errors())
                {
                        echo $this->ion_auth->errors();
                }
                else if ($this->session->flashdata('message') != '')
                {
                        echo $this->session->flashdata('message');
                }
                else if (isset($message))
                {
                        echo $message;
                }
                /**
                 * unset flash data
                 * 
                 * issue on permission, after set_flashdata, is ok, but go another controller will appear again
                 */
                $this->session->unset_userdata('message');
                ?>
            </div>



