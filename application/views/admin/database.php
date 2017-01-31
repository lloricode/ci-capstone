<?php defined('BASEPATH') OR exit('No direct script allowed'); ?>
<?php echo $backup_button; ?>
<div class="container-fluid">
    <hr>
    <h2>Platform</h2>
    <?php echo $platform; ?>

    <h2>Version</h2>
    <?php echo $version; ?>
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