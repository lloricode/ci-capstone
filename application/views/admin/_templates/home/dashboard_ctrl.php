<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
            <?php if (in_array('create-student', permission_controllers())): ?>
                    <li class="bg_lr"> 
                        <a href= "<?php echo site_url('create-student'); ?>"> 
                            <i class="icon-pencil"></i> 
                            <span class="label label-important"></span>Enroll Student
                        </a> 
                    </li>
            <?php endif; ?>
            <?php if (in_array('create-user', permission_controllers())): ?>
                    <li class="bg_ly"> 
                        <a href="<?php echo site_url('create-user'); ?>"> 
                            <i class="icon-user"></i>
                            <span class="label label-important"></span>Add Faculty
                        </a> 
                    </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
