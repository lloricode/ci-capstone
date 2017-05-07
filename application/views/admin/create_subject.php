<?php
defined('BASEPATH') or exit('Direct Script is not allowed');

echo form_open(site_url('create-subject'), array(
    'class'      => 'form-horizontal',
    'name'       => 'basic_validate',
    'id'         => 'basic_validate',
    'novalidate' => 'novalidate',
));
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6">

            <div class="widget-box collapsible">
                <div class="widget-title"> <a href="#collapseOne" data-toggle="collapse"> <span class="icon"><i class="icon-list"></i></span>
                        <h5><?php echo lang('create_subject_heading') ?></h5>
                    </a> </div>

                <?php
                /**
                 * @Author: Jinkee Po <pojinkee1@gmail.com>
                 *         
                 */
                echo input_bootstrap($subject_code);
                echo input_bootstrap($subject_description);
                echo input_bootstrap($course_id);
                ?>
                <div class="control-group">

                </div>

                <div class="widget-title"> <a href="#collapseTwo" data-toggle="collapse"> <span class="icon"><i class="icon-plus"></i></span>
                        <h5>Required for program GEN-ED</h5>
                    </a> </div>  
                <div class="widget-content nopadding">
                    <div <?php echo($err) ? '' : 'class="collapse"' ?> id="collapseTwo">

                        <div class="widget-content"> 

                            <?php
                            /**
                             * for GEN-ED
                             *         
                             */
                            echo input_bootstrap($curriculum_subject_lecture_hours);
                            echo input_bootstrap($curriculum_subject_laboratory_hours);
                            echo input_bootstrap($curriculum_subject_units);

                            echo form_close();
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                echo ' <div class="form-actions">';


                echo form_reset('reset', 'Reset', array(
                    'class' => 'btn btn-default'
                ));


                echo form_submit('submit', lang('create_subject_submit_button_label'), array(
                    'class' => 'btn btn-success'
                ));

                echo '</div>';
                ?>
            </div>
        </div>
    </div>
</div>

<?php
echo form_close();
