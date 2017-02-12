<?php
/**
 * 
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

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
$segment__  = str_replace('_', '-', $this->uri->segment(1)); //base_url 0,
$main_sub   = '';
/**
 * navigation
 */
$menu_items = $navigations;

$menu_settings = $setting_vavigations;

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
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($sub_label != '') ? $sub_label : $label; ?> | <?php echo $this->config->item('project_title'); ?></title>
        <meta charset="<?php echo $this->config->item('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <?php echo link_tag('assets/images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
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
            <h1><a href="<?php echo base_url(HOME_REDIRECT); ?>"><?php echo $this->config->item('project_title'); ?></a></h1>
        </div>
        <!--close-Header-part--> 


        <!--top-Header-menu-->
        <div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav">
                <li  class="dropdown" id="profile-messages" >
                    <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                        <i class="icon icon-user"></i>  
                        <span class="text"><?php echo $this->session->userdata('user_last_name') . ', ' . $this->session->userdata('user_first_name'); ?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('auth/logout'); ?>">
                                <i class="icon-key"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown" id="menu-messages">
                    <a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle">
                        <i class="icon icon-cog"></i> 
                        <span class="text">Settings</span> 
<!--                        <span class="label label-important">5</span> -->
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($menu_settings as $k => $v): ?>  
                                <li class="divider"></li>
                                <li><a class="sAdd" title="" href="<?php echo base_url(HOME_REDIRECT . $k); ?>"><i class="icon-<?php echo $v['icon']; ?>"></i> <?php echo $v['label']; ?></a></li>

                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="">
                    <a title="" href="<?php echo base_url('auth/logout'); ?>">
                        <i class="icon icon-share-alt"></i> 
                        <span class="text">Logout</span>
                    </a>
                </li>
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
                <?php if (ENVIRONMENT === 'development' || ENVIRONMENT === 'testing'): ?>
                        <li class="">
                            <a title="">
                                <i class="icon icon-magic"></i> 
                                <span class="text">
                                    <?php echo my_htmlspecialchars(ucfirst(ENVIRONMENT)); ?>
                                </span>
                            </a>
                        </li>
                <?php endif; ?>
            </ul>
        </div>
        <!--close-top-Header-menu-->
        <!--start-top-serch-->
        <div id="search">
            <input type="text" placeholder="Search here..."/>
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </div>
        <!--close-top-serch-->
        <!--sidebar-menu-->
        <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
            <?php echo sidebar_menu_ci_capstone($menu_current, $main_sub); ?>
        </div>
        <!--sidebar-menu-->

        <!--main-container-part-->
        <div id="content">
            <!--breadcrumbs-->
            <div id="content-header">
                <div id="breadcrumb"> 
                    <a href="<?php echo base_url(HOME_REDIRECT); ?>" title="Go to Home" class="tip-bottom">
                        <i class="icon-home"></i> Home
                    </a> 
                    <?php
                    if (MENU_ITEM_DEFAULT != $menu_current)
                    {
                            echo '<a' .
                            (



                            //-----------------start
                            #if
                            ($sub_label != '') ?
                                    #then
                                    '' :
                                    #else

                                    ' href="' . base_url(HOME_REDIRECT . $menu_current) . '"'


                            //--------------end


                            )
                            .
                            (
                            //--------------start
                            #if
                            ($sub_label != '') ?
                                    #then
                                    '' :
                                    #else
                                    ' class="current"'

                            //--------------end
                            )
                            . '>'
                            . $label . '</a>' . (($sub_label != '') ? ' '
                                    . '<a ' .
                                    //-------start sub
                                    (
                                    ##if
                                    ($active_link) ?
                                            ##then
                                            'href="' . base_url(HOME_REDIRECT . $menu_current) . '"'

                                    ##else
                                            : ''
                                    )
                                    //---------end sub
                                    . ' class="current">'
                                    . $sub_label
                                    . '</a>' : '' );
                    }
                    ?> 
                </div>
                <?php echo(($sub_label != '') ? '<h1>' . $sub_label . '</h1>' : (MENU_ITEM_DEFAULT == $label) ? '<h1>' . $label . '</h1>' : '' ); ?>
            </div>
            <!--End-breadcrumbs-->
