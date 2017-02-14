<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_education_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    echo $message;
                    /**
                     * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                     *         
                     */
                    echo form_open(base_url('create-subject-offer'), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));

                    //subject_offer_start:
                    echo input_bootstrap($subject_offer_start, 'create_subject_offer_start_label');


                    //subject_offer_end:
                    echo input_bootstrap($subject_offer_end, 'create_subject_offer_end_label');
                    ?>
                    <div class="control-group">
                        <div class="controls">
                            <table>
                                <tr>
                                    <td>
                                        <label>
                                            Monday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="monday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Tuesday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="tuesday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Wednesday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="wednesday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Thursday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="thursday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Friday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="friday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Saturday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="saturday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Sunday
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sunday" value="1"/>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php
                    echo input_dropdown_bootstrap('user_id', 'create_user_id_label', $user_id_value);
                    echo input_dropdown_bootstrap('subject_id', 'create_subject_id_label', $subject_id_value);
                    echo input_dropdown_bootstrap('room_id', 'create_room_id_label', $room_id_value);

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

