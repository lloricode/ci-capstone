<?php defined('BASEPATH') OR exit('No direct script allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $caption; ?></div>
            <div class="panel-body">
                <table data-toggle="table" data-url="<?php echo base_url(ADMIN_DIRFOLDER_NAME.'api_web/' . $controller); ?>"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>
                            <?php foreach ($columns as $key => $col): ?>
                                <th data-field="<?php echo $key; ?>" data-sortable="true" >
                                    <?php echo $col; ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div><!--/.row-->	