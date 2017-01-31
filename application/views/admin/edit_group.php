<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Create User</h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url('edit-group/?group-id=' . $group->id), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



                    // Name:
                    $tmp = (form_error('group_name') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('edit_group_name_label', 'group_name', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($group_name, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('group_name');
                    echo '</div></div> ';



                    //desc:
                    $tmp = (form_error('group_description') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('edit_group_desc_label', 'description', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($group_description, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('group_description');
                    echo '</div></div> ';







                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('edit_group_submit_btn'), array(
                        'class' => 'btn btn-success'
                    ));

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

