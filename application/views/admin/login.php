<?php
defined('BASEPATH') or exit('no direct script allowed');
$title = 'Log in | CI Capstone';
$link = base_url('assets/framework/bootstrap/admin/');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?php echo $title; ?></title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url(); ?>images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/matrix-login.css" />
        <link href="<?php echo $link; ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            <?php echo form_open(base_url(ADMIN_DIRFOLDER_NAME . 'login/validate'), array('class' => 'form-vertical', 'id' => 'loginform')) ?>
            <div class="control-group normal_text"> <h3><img src="<?php echo $link; ?>img/logo.png" alt="Logo" /></h3></div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <?php echo (!is_null($msg)) ? '<div class="form-group">' . $msg . '</div>' : ''; ?>       
                    </div>
                </div>
            </div><div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                        <?php
                        echo form_input(array(
                            'name' => 'username',
                            'value' => set_value('username'),
                            'placeholder' => "Username",
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                        <?php
                        echo form_password(array(
                            'name' => 'password',
                            'placeholder' => "Password",
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                <span class="pull-right">
                    <!--                    <a type="submit" href="index.html" class="btn btn-success" /> Login</a>-->
                    <?php
                    echo form_submit('save', 'Login', array(
                        'class' => 'btn btn-success'
                    ));
                    ?>
                </span>
            </div>
        </form>
        <form id="recoverform" action="#" class="form-vertical">
            <p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>

            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                </div>
            </div>

            <div class="form-actions">
                <span class="pull-left">
                    <a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a>
                </span>
                <span class="pull-right">
                    <a class="btn btn-info"/>Reecover</a>
                </span>
            </div>
            <?php echo form_close(); ?>
    </div>

    <script src="<?php echo $link; ?>js/jquery.min.js"></script>  
    <script src="<?php echo $link; ?>js/matrix.login.js"></script> 
</body>

</html>
