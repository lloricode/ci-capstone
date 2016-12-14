<?php
defined('BASEPATH') or exit('Direct Script is not allowed');

function inputs($attr) {

    switch ($attr['type']) {
        case 'text':
            echo form_input(array(
                'name' => $attr['field'],
                'value' => set_value($attr['field']),
              //  'placeholder' => $attr['label'],
                'id' => 'inputError'
            ));
            break;
        case 'password':
            echo form_password(array(
                'name' => $attr['field'],
               // 'placeholder' => $attr['label'],
                'id' => 'inputError'
            ));
            break;
        case 'combo':
            echo form_dropdown(
                    $attr['field'], $attr['combo_value'], set_value($attr['field']), array(
                'id' => 'inputError',
                    )
            );
            break;
        case 'textarea':
            echo form_textarea(
                    $attr['field'], set_value($attr['field']), $attr['label'], array(
              //  'placeholder' => $attr['label'],
                'id' => 'inputError'
                    )
            );
            break;
        case 'checkbox':
            echo form_checkbox($attr['field'], set_value($attr['field']), FALSE);
            break;
        default :
            break;
    }

    echo '<br />';
}
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo $caption; ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();

                    echo form_open(base_url($myform['action']), array(
                        'class' => 'form-horizontal',
                        'name' => 'basic_validate',
                        'id' => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));

                    foreach ($myform['attr'] as $attr):
                        $tmp = (form_error($attr['field']) == '') ? '' : ' error';
                        echo '<div class="control-group' . $tmp . '">';
//                        echo form_label($attr['label'], $attr['field'], array(
//                            'class' => 'control-label',
//                            'id' => 'inputError'
//                        ));
                        echo $attr['label'];
                        echo '<div class="controls">';
                        inputs($attr);
                        echo form_error($attr['field']);
                        echo '</div></div> ';
                    endforeach;
                    echo ' <div class="form-actions">';

                    echo form_submit($myform['button_name'], $myform['button_label'], array(
                        'class' => 'btn btn-success'
                    ));

                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    echo '</div>';
                    echo form_close(); 
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

