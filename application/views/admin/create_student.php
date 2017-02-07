<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">    
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_student_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("admin/create-student/index"), array(
                        'id'    => 'form-wizard',
                        'class' => 'form-horizontal'
                            ), $student_school_id);

                    /**
                     * first page 
                     */
                    echo '<div id="form-wizard-1" class="step">';
                    echo $first_page;
                    echo '</div>';
                    /**
                     * second page 
                     */
                    echo '<div id="form-wizard-2" class="step">';
                    echo $second_page;
                    echo '</div>';




                    echo ' <div class="form-actions">';

                    echo form_reset('btn1', 'Back', array(
                        'class' => 'btn btn-primary',
                        'id'    => 'back'
                    ));

                    echo form_submit('btn2', lang('create_student_submit_button_label'), array(
                        'class' => 'btn btn-primary',
                        'id'    => 'next'
                    ));
                    echo '<div id="status"></div>';
                    echo '</div>';


                    echo form_close();
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

