<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('deactivate_heading'); ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();

                    echo form_open(base_url("deactivate/index/" . $user->id), array(
                        'class' => 'form-horizontal',
                        'name' => 'basic_validate',
                        'id' => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



                    // yes:
                    echo '<div class="control-group">';
                    echo lang('deactivate_confirm_y_label', 'confirm', array(
                        'class' => 'control-label',
                        'id' => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_radio('confirm', 'yes', TRUE);
                    echo '</div></div> ';



                    //no:
                    echo '<div class="control-group">';
                    echo lang('deactivate_confirm_n_label', 'confirm', array(
                        'class' => 'control-label',
                        'id' => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_radio('confirm', 'no');
                    echo '</div></div> ';







                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('deactivate_submit_btn'), array(
                        'class' => 'btn btn-success'
                    ));

                    echo form_hidden($csrf);
                    echo form_hidden(array('id' => $user->id));

                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    echo '</div>';
                    echo form_close();
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

