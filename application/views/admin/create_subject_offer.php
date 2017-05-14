<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
if (isset($conflict_data))
{
        echo $conflict_data;
        unset($conflict_data);
}
if (isset($conflict_data2))
{
        echo $conflict_data2;
        unset($conflict_data2);
}
if (isset($two_forms_conflict_message))
{
        echo $two_forms_conflict_message;
        unset($two_forms_conflict_message);
}
if (isset($suggest_sechedule))
{
        echo $suggest_sechedule;
        unset($suggest_sechedule);
}
echo form_open(site_url('create-subject-offer'), array(
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
                        <h5><?php echo lang('create_subject_offer_heading') ?></h5>
                    </a> </div>

                <?php
                /**
                 * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                 *         
                 */
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
//                echo input_bootstrap($leclab);
                ?>
                <div class="control-group">
                    <div class="control-label">
                        Check to exclude second form
                    </div>
                    <div class="controls">
                        <?php echo form_checkbox('exclude', TRUE, set_checkbox('exclude', set_value('exclude'), TRUE)); ?>
                    </div>
                </div>

                <div class="widget-title"> <a href="#collapseTwo" data-toggle="collapse"> <span class="icon"><i class="icon-plus"></i></span>
                        <h5>Another Class Schedule</h5>
                    </a> </div>  
                <div class="widget-content nopadding">
                    <div <?php echo($err) ? '' : 'class="collapse"' ?> id="collapseTwo">
                        <div class="widget-content"> 

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
//                            echo input_bootstrap($leclab2);

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


                echo form_submit('submit', lang('create_subject_offer_submit_button_label'), array(
                    'class' => 'btn btn-success'
                ));

                echo '</div>';
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php
echo form_close();

