<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
<!--            <li class="bg_lb"> <a href="index.html"> <i class="icon-dashboard"></i> <span class="label label-important">20</span> My Dashboard </a> </li>
            <li class="bg_lg span3"> <a href="charts.html"> <i class="icon-signal"></i> Charts</a> </li>
            <li class="bg_ly"> <a href="widgets.html"> <i class="icon-inbox"></i><span class="label label-success">101</span> Widgets </a> </li>
            <li class="bg_lo"> <a href="tables.html"> <i class="icon-th"></i> Tables</a> </li>
            <li class="bg_ls"> <a href="grid.html"> <i class="icon-fullscreen"></i> Full width</a> </li>
            <li class="bg_lo span3"> <a href="form-common.html"> <i class="icon-th-list"></i> Forms</a> </li>
            <li class="bg_ls"> <a href="buttons.html"> <i class="icon-tint"></i> Buttons</a> </li>
            <li class="bg_lb"> <a href="interface.html"> <i class="icon-pencil"></i>Elements</a> </li>
            <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li>
            <li class="bg_lr"> <a href="error404.html"> <i class="icon-info-sign"></i> Error</a> </li>-->
            <li class="bg_lb"> 
                <a href= "<?php echo base_url('admin/users'); ?>"> 
                    <i class="icon-group"></i> 
                    <span class="label label-important"><?php echo $active_users_count; ?></span>
                    Active Users 
                </a> 
            </li>
            <li class="bg_lg"> 
                <a href="<?php echo base_url('admin/students'); ?>"> 
                    <i class="icon-user"></i> 
                    <span class="label label-important"><?php echo $student_enrolled_count; ?></span> 
                    Enrolled Students 
                </a> 
            </li>

        </ul>
    </div>
</div>
