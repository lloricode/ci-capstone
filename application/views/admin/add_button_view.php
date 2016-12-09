<?php defined('BASEPATH') OR exit('No direct script allowed'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12"> 
            <?php echo anchor(base_url(ADMIN_DIRFOLDER_NAME . $href), $button_label, array('class' => 'btn btn-info')); ?> 
        </div>
    </div>
</div>