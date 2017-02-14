<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_subject_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                  

                    echo form_open(base_url('create-subject'), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));


                    //subject_code:
                    $tmp = (form_error('subject_code') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_subject_code_label', 'subject_code', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($subject_code, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('subject_code');
                    echo '</div></div> ';



                    //subject_description:
                    $tmp = (form_error('subject_description') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_subject_description_label', 'subject_description', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($subject_description, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('subject_description');
                    echo '</div></div> ';

                    //subject_unit:
                    $tmp = (form_error('subject_unit') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_subject_unit_label', 'subject_unit', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($subject_unit, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('subject_unit');
                    echo '</div></div> ';



                    echo ' <div class="form-actions">';

                    //reset button
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    //submit button
                    echo form_submit('submit', lang('create_subject_submit_button_label'), array(
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

