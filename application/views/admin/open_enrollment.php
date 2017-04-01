<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <h3><?php echo 'Status: ' . (($enabled) ? 'Enabled' : 'Disabled'); ?></h3>
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
            <?php if ($enabled): ?>
                    <li class="bg_lr"> 
                        <a href= "<?php echo site_url('open-enrollment/set-disable'); ?>"> 
                            <i class="icon-lock"></i> 
                            <span class="label label-important"></span>
                            <?php echo lang('disable_enrollment_status_label'); ?>
                        </a> 
                    </li>
            <?php else: ?>
                    <li class="bg_lg"> 
                        <a href= "<?php echo site_url('open-enrollment/set-enable'); ?>"> 
                            <i class="icon-unlock"></i> 
                            <span class="label label-important"></span>
                            <?php echo lang('enable_enrollment_status_label'); ?>
                        </a> 
                    </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
