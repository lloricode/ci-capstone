<?php defined('BASEPATH') or exit('Direct Script is not allowed'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6>">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_curriculum_subject_label') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    // echo validation_errors();

                    echo form_open($action, array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));

                    foreach ($inputs as $k => $v)
                    {
                            if (isset($v['form_count']))
                            {
                                    echo heading(form_label("Form {$v['form_count']}"), 3);
                                    continue;
                            }
                            echo input_bootstrap($v);
                    }

                    echo ' <div class="form-actions">';

                    //reset button
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    //submit button
                    echo form_submit('submit', lang('create_curriculum_subject_label'), array(
                        'class' => 'btn btn-success'
                    ));

                    echo '</div>';
                    echo form_close();
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
unset($action);
unset($inputs);
