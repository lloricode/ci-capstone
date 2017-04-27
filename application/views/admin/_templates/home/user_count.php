<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
            <?php if (isset($active_users_count)): ?>
                    <li class="bg_lb"> 
                        <a href= "<?php echo site_url('users'); ?>"> 
                            <i class="icon-group"></i> 
                            <span class="label label-important"><?php echo $active_users_count; ?></span>
                            <?php echo lang('index_active_link') . ' ' . lang('index_heading'); ?>  
                        </a> 
                    </li>
            <?php endif; ?>
            <?php if (isset($student_enrolled_count)): ?>
                    <li class="bg_lg"> 
                        <a href="<?php echo site_url('students?status=enrolled'); ?>"> 
                            <i class="icon-user"></i> 
                            <span class="label label-important"><?php echo $student_enrolled_count; ?></span> 
                            Enrolled Students 
                        </a> 
                    </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
