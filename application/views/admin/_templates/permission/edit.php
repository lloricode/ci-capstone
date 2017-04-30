<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <?php echo heading('Update Permission', 5) ?>
                </div>
                <div class="widget-content nopadding">
                    <?php
                    echo validation_errors();

                    echo form_open(site_url("permissions/edit?controller-id=" . $controller_obj->controller_id), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));

                    if ($this->ion_auth->is_admin())://just to make sure that only admin can manage this
                            ?>

                            <label class="checkbox"><?php echo heading($controller_obj->controller_name, 3) . paragraph($controller_obj->controller_description); ?></label>
                            <?php foreach ($this->ion_auth->groups()->result() as $group): ?>
                                    <label class="checkbox">
                                        <?php
                                        $checked = FALSE;
                                        foreach ($this->permission->controller_groups($controller_obj->controller_id) as $g_id)
                                        {
                                                if ($group->id == $g_id)
                                                {
                                                        $checked = TRUE;
                                                        break;
                                                }
                                        }
                                        ?>
                                        <?php echo form_checkbox('groups[]', $group->id, $checked) ?>
                                        <?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                            <?php endforeach ?>

                            <?php
                    endif;

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

