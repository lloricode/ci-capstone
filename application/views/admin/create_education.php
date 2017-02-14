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
//echo validation_errors();

                    echo $message;
                    /**
                     * @Contributor: Jinkee Po <pojinkee1@gmail.com>
                     *         
                     */

                    echo form_open(base_url('create-education'), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));


                    //education_code:
                    $tmp = (form_error('education_code') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_education_code_label', 'education_code', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($education_code, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('education_code');
                    echo '</div></div> ';



                    //education_description:
                    $tmp = (form_error('education_description') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_education_description_label', 'education_description', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($education_description, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('education_description');
                    echo '</div></div> ';

                    echo ' <div class="form-actions">';

                    //reset button
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    //submit button
                    echo form_submit('submit', lang('create_education_submit_button_label'), array(
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

