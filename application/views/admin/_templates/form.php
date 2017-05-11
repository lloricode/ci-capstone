<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
if ( ! $remove_bootrapt_div)
{
        echo '<div class="container-fluid"> <div class="row-fluid">';
}
?>
<div class="span<?php echo $form_size; ?>">
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
                                    echo bootstrap_error($e, TRUE);
                            }
                    }
            }

            $attibutes = array(
                'class'      => 'form-horizontal',
                'name'       => 'basic_validate',
                'id'         => 'basic_validate',
                'novalidate' => 'novalidate',
            );
            if ( ! is_null($other_attributes_form_open))
            {
                    if (is_array($other_attributes_form_open))
                    {
                            $attibutes = array_merge($attibutes, $other_attributes_form_open);
                    }
            }

            echo form_open(site_url($action), $attibutes, ((isset($hidden_inputs)) ? $hidden_inputs : NULL));

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
<?php
if ( ! $remove_bootrapt_div)
{
        echo '</div></div>';
}
unset($remove_bootrapt_div);
unset($form_size);
unset($icon);
unset($lang_header);
unset($error);
unset($action);
unset($attibutes);
unset($hidden_inputs);
unset($inputs);
unset($lang_button);
unset($other_attributes_form_open);
