<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_curriculum_label') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    echo validation_errors();

                    echo $message;
                    /**
                     * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                     *         
                     */
                    echo form_open(site_url('create-curriculum'), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));





                    //curriculum_description:
                    echo input_bootstrap($curriculum_description, 'curriculumn_description', 'textarea');

                    #combo//curriculum_effective_school_year:
                    echo input_bootstrap($curriculum_effective_school_year, 'curriculumn_effective_year', 'dropdown');

                    #combo//curriculum_effective_semester:
                    echo input_bootstrap($curriculum_effective_semester, 'curriculumn_effective_semester', 'dropdown');

                    #combo//course_id
                    echo input_bootstrap($course_id, 'curriculumn_course', 'dropdown');

                    //curriculum_status:
                    echo input_bootstrap($curriculum_status, 'curriculumn_status', 'checkbox');




                    echo ' <div class="form-actions">';

                    //reset button
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    //submit button
                    echo form_submit('submit', lang('curriculumn_create_button'), array(
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

