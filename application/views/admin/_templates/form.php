<?php defined('BASEPATH') or exit('Direct Script is not allowed'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-<?php echo $icon; ?>"></i> </span>
                    <h5><?php echo lang($lang_header) ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    // echo validation_errors();

                    /**
                     * error on specific fields
                     */
                    if (isset($error))
                    {
                            foreach (((is_array($error)) ? $error : array($error)) as $e)//convert to array if not,then iterate in loop
                            {
                                    if ($e != '')
                                    {
                                            echo ' <div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>' . $e . '</div>';
                                    }
                            }
                    }

                    echo form_open(site_url($action), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                            ), ((isset($hidden_inputs)) ? $hidden_inputs : NULL));


                    foreach ($inputs as $k => $v)
                    {
                            echo input_bootstrap($v);
                    }

                    echo ' <div class="form-actions">';

                    //reset button
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    //submit button
                    echo form_submit('submit', lang($lang_button), array(
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

