<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5><?php echo 'Update Permission' ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    echo validation_errors();
                    echo $message;

                    echo form_open(base_url("permissions/edit?controller-id=" . $controller_obj->controller_id), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));

                    if ($this->ion_auth->is_admin()):
                            ?>

                            <h3><?php echo $controller_obj->controller_name . ' [' . $controller_obj->controller_description . ']'; ?></h3>
                            <?php foreach ($this->ion_auth->groups()->result() as $group): ?>
                                    <label class="checkbox">
                                        <?php
                                        $checked = null;
                                        $item    = null;
                                        foreach ($this->permission->controller_groups($controller_obj->controller_id) as $g_id)
                                        {
                                                if ($group->id == $g_id)
                                                {
                                                        $checked = ' checked="checked"';
                                                        break;
                                                }
                                        }
                                        ?>
                                        <input type="checkbox" name="groups[]" value="<?php echo $group->id; ?>"<?php echo $checked; ?>>
                                        <?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                            <?php endforeach ?>

                            <?php
                    endif;
//
//                    //Name:
//                    $tmp = (form_error('name') == '') ? '' : ' error';
//                    echo '<div class="control-group' . $tmp . '">';
//                    echo lang('create_group_name_label', 'name', array(
//                        'class' => 'control-label',
//                        'id'    => 'inputError'
//                    ));
//                    echo '<div class="controls">';
//                    echo form_input($name, array(
//                        'id' => 'inputError'
//                    ));
//                    echo form_error('name');
//                    echo '</div></div> ';
//
//
//
//                    //desc:
//                    $tmp = (form_error('desc') == '') ? '' : ' error';
//                    echo '<div class="control-group' . $tmp . '">';
//                    echo lang('create_group_desc_label', 'desc', array(
//                        'class' => 'control-label',
//                        'id'    => 'inputError'
//                    ));
//                    echo '<div class="controls">';
//                    echo form_input($desc, array(
//                        'id' => 'inputError'
//                    ));
//                    echo form_error('desc');
//                    echo '</div></div> ';
//
//


                    echo ' <div class="form-actions">';

                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));
                    echo form_submit('submit', 'Update Permission', array(
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

