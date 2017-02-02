<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('edit_user_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url('edit-user/?user-id=' . $user->id), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                            ), array('id', $user->id));



                    //First Name:
                    $tmp = (form_error('first_name') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_user_fname_label', 'first_name', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($first_name, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('first_name');
                    echo '</div></div> ';



                    //Last Name:
                    $tmp = (form_error('last_name') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_user_lname_label', 'last_name', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($last_name, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('last_name');
                    echo '</div></div> ';




                    //Company Name:
                    $tmp = (form_error('company') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_user_company_label', 'company', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($company, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('company');
                    echo '</div></div> ';






                    //Phone:
                    $tmp = (form_error('phone') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_user_phone_label', 'phone', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($phone, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('phone');
                    echo '</div></div> ';



                    //Password:
                    $tmp = (form_error('password') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('edit_user_password_label', 'password', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_password($password);
                    echo form_error('password');
                    echo '</div></div> ';



                    //Confirm Password:
                    $tmp = (form_error('password_confirm') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('edit_user_password_confirm_label', 'password_confirm', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_password($password_confirm);
                    echo form_error('password_confirm');
                    echo '</div></div> ';


                    echo '<div class="control-group">';
                    echo '<div class="controls">';
                    ?>

                    <?php if ($this->ion_auth->is_admin()): ?>

                            <h3><?php echo lang('edit_user_groups_heading'); ?></h3>
                            <?php foreach ($groups as $group): ?>
                                    <label class="checkbox">
                                        <?php
                                        $gID     = $group['id'];
                                        $checked = null;
                                        $item    = null;
                                        foreach ($currentGroups as $grp)
                                        {
                                                if ($gID == $grp->id)
                                                {
                                                        $checked = ' checked="checked"';
                                                        break;
                                                }
                                        }
                                        ?>
                                        <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                            <?php endforeach ?>

                            <?php
                    endif;
                    echo '</div></div>';
                    ?>




                    <?php
                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('edit_user_submit_btn'), array(
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

