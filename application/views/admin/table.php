<?php defined('BASEPATH') OR exit('No direct script allowed'); ?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5><?php echo lang('index_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $users; ?>
                </div>
            </div>
        </div>
    </div>
</div>