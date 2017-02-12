<?php
defined('BASEPATH') or exit('no direct script allowed');
$link = base_url($this->config->item('bootstarp_dir'));
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Log in | <?php echo $this->config->item('project_title'); ?></title>
        <meta charset="<?php echo $this->config->item('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url('assets/images/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/matrix-login.css" />
        <link href="<?php echo $link; ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            <?php echo form_open(base_url('auth/login'), array('class' => 'form-vertical', 'id' => 'loginform')) ?>
            <div class="control-group normal_text"> <h3><img src="<?php echo $link; ?>img/logo.png" alt="Logo" /></h3></div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <?php echo (!is_null($message)) ? '<div class="form-group">' . $message . '</div>' : ''; ?>       
                    </div>
                </div>
            </div><div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                        <?php
                        echo form_input($identity);
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                        <?php
                        echo form_password($password);
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                <span class="pull-right">
                    <?php
                    echo form_submit('submit', lang('login_submit_btn'), array(
                        'class' => 'btn btn-success'
                    ));
                    ?>
                </span>
            </div>
            <?php echo form_close(); ?>
            <?php echo form_open(base_url('auth/forgot_password'), array('class' => 'form-vertical', 'id' => 'recoverform')) ?>
            <p class="normal_text">Enter your Username below and we will send you instructions how to recover a password.</p>

            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-envelope"></i></span>
                    <?php //echo (($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)); ?>
                    <?php echo form_input($identity); ?>
                </div>
            </div>

            <div class="form-actions">
                <span class="pull-left">
                    <a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a>
                </span>
                <span class="pull-right">
                    <?php echo form_submit('submit', lang('forgot_password_submit_btn'), array('class' => "btn btn-info")); ?>
                </span>
            </div>
            <?php echo form_close(); ?>
        </div>

        <script src="<?php echo $link; ?>js/jquery.min.js"></script>  
        <script src="<?php echo $link; ?>js/matrix.login.js"></script> 
    </body>

</html>
