<?php defined('BASEPATH') OR exit('No direct script allowed'); ?>
<?php echo $backup_button; ?>
<?php echo $delete_cache_button; ?>
<div class="container-fluid">
    <h5>Platform</h5>
    <h2><?php echo $platform; ?></h2>

    <h5>Version</h5>
    <h2><?php echo $version; ?></h2>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Database</h5>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $table; ?>
                </div>
            </div>
        </div>
    </div>
</div>