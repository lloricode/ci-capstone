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
                    echo input_bootstrap($course_code, 'create_course_code_label');

                    //course_description:
                    echo input_bootstrap($course_description, 'create_course_description_label');

                    //education_id                     
                    echo input_dropdown_bootstrap('education_id', 'create_course_education_label', $education_id_value);


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

