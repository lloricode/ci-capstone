<?php
defined('BASEPATH') or exit('no direct script allowed');
$title = 'Log in | CI Capstone';
$link = 'assets/framework/bootstrap/admin/';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <link href="<?php echo base_url($link); ?>images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

        <link href="<?php echo base_url($link); ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url($link); ?>css/datepicker3.css" rel="stylesheet">
        <link href="<?php echo base_url($link); ?>css/styles.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading"><?php echo $title; ?></div>
                    <div class="panel-body">
                        <?php echo form_open(base_url(ADMIN_DIRFOLDER_NAME . 'login/validate'), array('role' => 'form')) ?>
                        <fieldset>                            
                            <?php echo (!is_null($msg)) ? '<div class="form-group">' . $msg . '</div>' : ''; ?>                            
                            <div class="form-group">
                                <?php
                                echo form_input(array(
                                    'name' => 'username',
                                    'class' => 'form-control',
                                    'value' => set_value('username'),
                                    'placeholder' => "Username",
                                    'autofocus' => ''
                                ));
                                ?>
                            </div>
                            <div class="form-group">
                                <?php 
                                echo form_input(array(
                                    'name' => 'password',
                                    'class' => 'form-control',
                                    'type' => 'password',
                                    'placeholder' => "Password",
                                    'autofocus' => ''
                                ));
                                ?>
                            </div>
                            <!--                            <div class="checkbox">
                                                            <label>
                            <?php
//                                    echo form_checkbox(array(
//                                        'name' => 'remember',
//                                        'value' => 'Remember Me',
//                                        'checked' => FALSE,
//                                    )) . 'Remember Me';
                            ?>
                                                            </label>
                                                        </div>-->
                            <?php
                            echo form_submit('save', 'Login', array(
                                'class' => 'btn btn-primary'
                            ));
                            ?>
                        </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->	



        <script src="<?php echo base_url($link); ?>js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url($link); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url($link); ?>js/chart.min.js"></script>
        <script src="<?php echo base_url($link); ?>js/chart-data.js"></script>
        <script src="<?php echo base_url($link); ?>js/easypiechart.js"></script>
        <script src="<?php echo base_url($link); ?>js/easypiechart-data.js"></script>
        <script src="<?php echo base_url($link); ?>js/bootstrap-datepicker.js"></script>
        <script>
            !function ($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })
        </script>	
    </body>

</html>

