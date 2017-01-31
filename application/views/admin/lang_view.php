<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('change_lang_label') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("language/index"), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));





                    //lang choose:
                    $tmp = (form_error('lang') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('change_lang_combo_label', 'lang', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown(
                            'lang', $lang_chooser, set_value('lang'), array(
                        'id' => 'inputError',
                            )
                    );
                    echo form_error('lang');
                    echo '</div></div> ';



                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('change_lang_btn_label'), array(
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

