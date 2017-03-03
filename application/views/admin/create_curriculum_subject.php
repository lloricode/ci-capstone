<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_curriculum_subject_label') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    //echo validation_errors();

                    echo $message;


                    echo form_open(site_url('create-curriculum-subject'), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



                    //curriculum_id:
                    echo input_bootstrap($curriculum_id, 'curriculum_subject_curriculum_label', 'dropdown');

                    //curriculum_subject_semester:
                    echo input_bootstrap($curriculum_subject_semester, 'curriculum_subject_semester_label', 'dropdown');

                    //subject_id:
                    echo input_bootstrap($subject_id, 'curriculum_subject_subject_label', 'dropdown');

                    //subject_id_pre:
                    echo input_bootstrap($subject_id_pre, 'curriculum_subject_co_subject_label', 'dropdown');

                    //subject_id_co:
                    echo input_bootstrap($subject_id_co, 'curriculum_subject_pre_subject_label', 'dropdown');




                    //curriculum_subject_lecture_hours:
                    echo input_bootstrap($curriculum_subject_lecture_hours, 'curriculum_subject_lecture_hours_label', 'dropdown');

                    //curriculum_subject_laboratory_hours:
                    echo input_bootstrap($curriculum_subject_laboratory_hours, 'curriculum_subject_laboratory_hours_label', 'dropdown');


                    //curriculum_subject_units:
                    echo input_bootstrap($curriculum_subject_units, 'curriculum_subject_units_label', 'dropdown');


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

