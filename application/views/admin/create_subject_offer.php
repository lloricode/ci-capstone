<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
if (isset($conflict_data))
{
        echo $conflict_data;
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

                    //subject_offer_start:
                    echo input_bootstrap($subject_offer_start);


                    //subject_offer_end:
                    echo input_bootstrap($subject_offer_end);
                    ?>
                    <div class="control-group">
                        <div class="controls">
                            <?php
                            $this->table->set_template(array(
                                'table_open' => '<table>',
                            ));
                            ?>
                            <?php foreach ($days as $d): ?>
                                    <?php $this->table->add_row(form_label(lang('cal_' . $d), $d), form_label(form_checkbox($d, TRUE/* i set this TRUE for directly insert, */, set_checkbox($d, set_value($d))), $d)); ?>
                            <?php endforeach; ?>
                            <?php echo $this->table->generate(); ?>
                        </div>
                    </div>

                    <?php
                    echo input_bootstrap($user_id);
                    echo input_bootstrap($subject_id);
                    echo input_bootstrap($room_id);

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

