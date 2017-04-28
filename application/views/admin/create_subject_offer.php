<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
if (isset($conflict_data))
{
        echo $conflict_data;
}
if (isset($conflict_data2))
{
        echo $conflict_data2;
}
if (isset($two_forms_conflict_message))
{
        echo $two_forms_conflict_message;
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_subject_offer_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    /**
                     * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                     *         
                     */
                    echo form_open(site_url('create-subject-offer'), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));
                    /**
                     * info
                     */
                    echo input_bootstrap($user_id);
                    echo input_bootstrap($subject_id);
                    ?>
                    <div class="control-group">
                        <div class="control-label">
                            <h3>Schedule</h3>    
                        </div>
                    </div>

                    <?php
                    /**
                     * 1st
                     *////////////////////////////////////////////////////////////////////////////////////////////
                    //subject_offer_start:
                    echo input_bootstrap($subject_offer_start);


                    //subject_offer_end:
                    echo input_bootstrap($subject_offer_end);
                    echo input_bootstrap($days1);
                    echo input_bootstrap($room_id);
                    echo input_bootstrap($leclab);
                    ?>
                    <div class="control-group">
                        <div class="control-label">
                            <h3>Schedule 2</h3>Check to exclude <?php echo form_checkbox('exclude', TRUE, set_checkbox('exclude', set_value('exclude'))); ?>
                        </div>
                    </div>

                    <?php
                    /**
                     * end
                     *////////////////////////////////////////////////////////////////////////////////////////////
                    //subject_offer_start:
                    echo input_bootstrap($subject_offer_start2);


                    //subject_offer_end:
                    echo input_bootstrap($subject_offer_end2);
                    echo input_bootstrap($days2);
                    echo input_bootstrap($room_id2);
                    echo input_bootstrap($leclab2);

                    echo ' <div class="form-actions">';


                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));


                    echo form_submit('submit', lang('create_subject_offer_submit_button_label'), array(
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

