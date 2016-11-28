<?php
/**
 * 
 * @author Lloric Mayuga Garcia <emorickfighter@gmail.com> 
 */
defined('BASEPATH') OR exit('No direct script allowed');
?>

<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo $my_form['caption']; ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    echo form_open($my_form['action'], array(
                        'class' => 'form-horizontal',
                        'name' => 'basic_validate',
                        'id' => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));
                    ?>

                    <?php foreach ($my_forms_inputs as $k => $my_input): ?>  
                        <div class="control-group">
                            <?php
                            echo form_label($my_input['title'], $k, array(
                                'class' => 'control-label'
                            ));
                            ?>
                            <div class="controls">
                                <?php
                                switch ($my_input['type']) {
                                    case 'text':
                                        echo form_input(array(
                                            'name' => $k,
                                            'value' => ($my_input['value'] == NULL) ? set_value($k) : $my_input['value'],
                                            'placeholder' => $my_input['title'],
                                            'id' => 'required'
                                        ));
                                        break;
                                    case 'password':
                                        echo form_password(array(
                                            'name' => $k,
                                            'value' => NULL,
                                            'placeholder' => $my_input['title'],
                                            'id' => 'required'
                                        ));
                                        break;
                                    case 'combo':
                                        echo form_dropdown($k, $my_input['combo_value'], ($my_input['value'] == NULL) ? set_value($k) : $my_input['value'], array(
                                            'class' => 'form-control'
                                        ));
                                        break;
                                    case 'checkbox':
                                        checkbox($my_input['checkbox_value']);
                                        break;
                                    default:
                                        $tmp = FALSE;
                                        log_message('error', 'no value in form view');
                                        break;
                                }
                                echo form_error($k);
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="form-actions">
                        <?php
                        echo form_submit($my_form['button_name'], $my_form['button_title'], array(
                            'class' => 'btn btn-success'
                        ));
                        ?>
                        <?php
                        echo form_reset('reset', 'Reset', array(
                            'class' => 'btn btn-default'
                        ));
                        ?>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>


        </div>
    </div>
</div>