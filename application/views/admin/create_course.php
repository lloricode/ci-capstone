<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_course_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("admin/create-course/index"), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



                    //course_code:
                    $tmp = (form_error('course_code') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_course_code_label', 'course_code', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($course_code, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('course_code');
                    echo '</div></div> ';



                    //course_description:
                    $tmp = (form_error('course_description') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_course_description_label', 'course_description', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($course_description, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('course_description');
                    echo '</div></div> ';

                    echo ' <div class="form-actions">';

                    //reset button
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    //submit button
                    echo form_submit('submit', lang('create_course_submit_button_label'), array(
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

