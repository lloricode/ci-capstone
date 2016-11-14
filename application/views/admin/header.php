<?php
/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *
 * MY CONSTANT
 * 
 */
        const TITLETAB = 'CI Capstone';
        const TITLE1 = 'CI';
        const TITLE2 = 'Capstone';
        const SEGMENT_NUMBER = 2; //base_url 0,
        const MENU_ITEM_DEFAULT = 'home';
        const BOOTSTRAPS_LIB_DIR = 'assets/framework/bootstrap/admin/';
        const HOME_REDIRECT = ADMIN_DIRFOLDER_NAME; // sample    admin/

$main_sub = '';
/**
 * navigation
 */
$menu_items = $navigations;


// Determine the current menu item.
$menu_current = MENU_ITEM_DEFAULT;
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($this->uri->segment(SEGMENT_NUMBER), $menu_items)) {
    $menu_current = $this->uri->segment(SEGMENT_NUMBER);
}
if (MENU_ITEM_DEFAULT == $menu_current) {
    foreach ($menu_items as $key => $item) {
        if (isset($item['sub'])) {
            if (@array_key_exists($this->uri->segment(SEGMENT_NUMBER), $item['sub'])) {
                $main_sub = $key;
                $menu_current = $this->uri->segment(SEGMENT_NUMBER);
                break;
            }
        }
    }
}

$label = html_escape(((isset($menu_items[$menu_current]['label'])) ? $menu_items[$menu_current]['label'] : $menu_items[$main_sub]['label']));
$sub_label = html_escape(((isset($menu_items[$menu_current]['label'])) ? '' : $menu_items[$main_sub]['sub'][$this->uri->segment(SEGMENT_NUMBER)]['label']));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo ($sub_label != '') ? $sub_label : $label; ?> | <?php echo TITLETAB; ?></title>
        <link href="<?php echo base_url(); ?>images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/datepicker3.css" rel="stylesheet">
        <link href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/styles.css" rel="stylesheet">
        <link href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/bootstrap-table.css" rel="stylesheet">
        <!--Icons-->
        <script src="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>js/lumino.glyphs.js"></script>
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(HOME_REDIRECT); ?>"><span><?php echo TITLE1; ?></span><?php echo TITLE2; ?></a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $this->session->userdata('admin_fullname'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url(HOME_REDIRECT . MENU_ITEM_DEFAULT); ?>/logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <form role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
            </form>
            <ul class="nav menu">
                <?php
                /**
                 * navigations
                 */
                foreach ($menu_items as $key => $item) {
                    if (isset($item['sub'])) {
                        //sub menu
                        $active1 = ($key == $main_sub ? ' active' : '');
                        echo '<li class="parent' . $active1 . '">';
                        echo '<a href="#">';
                        echo '<span data-toggle="collapse" href="#sub-item-' . $key . '">';
                        echo '<svg class="glyph stroked ' . str_replace('-', ' ', $item['icon']) . '"><use xlink:href="#stroked-' . $item['icon'] . '"/></svg>';
                        echo '</span>';
                        echo $item['label'];
                        echo '</a>';
                        //start sub menu 
                        echo '<ul class="children collapse" id="sub-item-' . $key . '">';
                        foreach ($item['sub'] as $sub_key => $sub_item) {
                            echo '<li>'
                            . '<a href="' . base_url(HOME_REDIRECT . $sub_key) . '">'
                            . '<svg class="glyph stroked download"><use xlink:href="#stroked-' . $sub_item['icon'] . '"/></svg> '
                            . $sub_item['label'] . '</a>'
                            . '</li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    } else {
                        $active = ($key == $menu_current ? ' class="active"' : '');
                        echo '<li' . $active . '>'
                        . '<a href="' . base_url(HOME_REDIRECT . $key) . '">'
                        . '<svg class="glyph stroked ' . str_replace('-', ' ', $item['icon']) . '"><use xlink:href="#stroked-' . $item['icon'] . '"/></svg> '
                        . $item['label'] . '</a>'
                        . '</li>';
                    }
                }
                ?>
            </ul>
        </div><!--/.sidebar-->
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">	<!--main-->
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                    <li class="active">
                        <?php
                        echo '<a href="' . (($sub_label != '') ? '#' : base_url(HOME_REDIRECT . $menu_current) ) . '">'
                        . $label . '</a>' . (($sub_label != '') ? '</li><li>'
                                . '<a href="' . base_url(HOME_REDIRECT . $menu_current) . '">'
                                . $sub_label
                                . '</a>' : '' );
                        ?>
                    </li>
                    <li>
                        <?php
                        // echo now('Asia/Manila');
                        $datestring = '%Y %m %d - %D %h:%i %a';
                        $time = time();
                        echo mdate($datestring, $time);
                        ?>
                    </li>
                    <?php
                    echo (ENVIRONMENT === 'development') ?
                            '<li>[rendered <strong>{elapsed_time}</strong> ver. <strong>'
                            . CI_VERSION
                            . '</strong>]</li>' : ''
                    ?>
                </ol>
            </div><!--/.row-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo(($sub_label != '') ? $sub_label : $label ); ?></h1>
                </div>
            </div>
