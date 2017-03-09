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
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-book"></i> 
                    <span class="label label-important"><?php echo $stud_beed; ?></span> 
                    BEED  
                </a> 
            </li>
            <li class="bg_lg"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-fire"></i> 
                    <span class="label label-important"><?php echo $stud_hrm; ?></span> 
                    HRM  
                </a> 
            </li>
            <li class="bg_ly"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-medkit"></i> 
                    <span class="label label-important"><?php echo $stud_paramedical; ?></span> 
                    Paramedical Students 
                </a> 
            </li>
            <li class="bg_lo"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-tasks"></i> 
                    <span class="label label-important"><?php echo $stud_ict; ?></span> 
                    ICT  
                </a> 
            </li>
            <li class="bg_lv"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-briefcase"></i> 
                    <span class="label label-important"><?php echo $stud_highschool; ?></span> 
                    High School Students 
                </a> 
            </li>
            
            <li style="margin-top: 10px" class="bg_lb"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-beaker"></i> 
                    <span class="label label-important"><?php echo $stud_amt; ?></span> 
                    AMT 
                </a> 
            </li>
            <li style="margin-top: 10px" class="bg_lg"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-user"></i> 
                    <span class="label label-important"><?php echo $stud_tesda; ?></span> 
                    TESDA
                </a> 
            </li>
            <li style="margin-top: 10px" class="bg_ly"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-tint"></i> 
                    <span class="label label-important"><?php echo $stud_cme; ?></span> 
                    CME
                </a> 
            </li>
            <li style="margin-top: 10px" class="bg_lo"> 
                <a href="<?php echo site_url('students'); ?>"> 
                    <i class="icon-move"></i> 
                    <span class="label label-important"><?php echo $stud_cross_enroll; ?></span> 
                    Cross Enroll Students 
                </a> 
            </li>
            
        </ul>
    </div>
</div>
