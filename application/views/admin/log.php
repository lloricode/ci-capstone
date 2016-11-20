<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Error Logs</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <?php echo (isset($msg)) ? $msg : ''; ?>
                </div>
            </div>
        </div><!-- /.col-->
    </div>
</div>