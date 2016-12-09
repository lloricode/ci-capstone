<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$link = base_url('assets/framework/bootstrap/admin/');
?>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 2016 &copy; ci-capstone. <a href="http://lloricmayugagarcia.com">lloricmayugagarcia.com</a> </div>
</div>

<!--end-Footer-part-->
<?php
//hirap na hanapin ang file needed, so i just copy the code the lagay sa conditional statement
if (isset($controller)) {
    if ($controller == 'table') {
        ?>
        <script src="<?php echo $link; ?>js/jquery.min.js"></script> 
        <script src="<?php echo $link; ?>js/jquery.ui.custom.js"></script> 
        <script src="<?php echo $link; ?>js/bootstrap.min.js"></script> 
        <script src="<?php echo $link; ?>js/jquery.uniform.js"></script> 
        <script src="<?php echo $link; ?>js/select2.min.js"></script> 
        <script src="<?php echo $link; ?>js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo $link; ?>js/matrix.js"></script> 
        <script src="<?php echo $link; ?>js/matrix.tables.js"></script>
    <?php } else if ($controller == 'addadmin') {
        ?>
        <script src="<?php echo $link; ?>js/jquery.min.js"></script> 
        <script src="<?php echo $link; ?>js/jquery.ui.custom.js"></script> 
        <script src="<?php echo $link; ?>js/bootstrap.min.js"></script> 
        <script src="<?php echo $link; ?>js/jquery.uniform.js"></script> 
        <script src="<?php echo $link; ?>js/select2.min.js"></script> 
        <script src="<?php echo $link; ?>js/jquery.validate.js"></script> 
        <script src="<?php echo $link; ?>js/matrix.js"></script> 
        <script src="<?php echo $link; ?>js/matrix.form_validation.js"></script>
    <?php }
    ?>
<?php } else { ?>

    <script src="<?php echo $link; ?>js/excanvas.min.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.min.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.ui.custom.js"></script> 
    <script src="<?php echo $link; ?>js/bootstrap.min.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.flot.min.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.flot.resize.min.js"></script> 
<!--    <script src="<?php //echo $link; ?>js/jquery.peity.min.js"></script> -->
    <script src="<?php echo $link; ?>js/fullcalendar.min.js"></script> 
    <script src="<?php echo $link; ?>js/matrix.js"></script> 
    <script src="<?php echo $link; ?>js/matrix.dashboard.js"></script> 
<!--    <script src="<?php //echo $link; ?>js/matrix.interface.js"></script> -->
    <script src="<?php echo $link; ?>js/matrix.chat.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.validate.js"></script> 
    <script src="<?php echo $link; ?>js/matrix.form_validation.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.wizard.js"></script> 
    <script src="<?php echo $link; ?>js/jquery.uniform.js"></script> 
    <script src="<?php echo $link; ?>js/select2.min.js"></script> 
<!--    <script src="<?php //echo $link; ?>js/matrix.popover.js"></script> -->
    <script src="<?php echo $link; ?>js/jquery.dataTables.min.js"></script> 
    <script src="<?php echo $link; ?>js/matrix.tables.js"></script> 

<?php } ?>

<!--<script src="<?php //echo $link; ?>js/jquery.gritter.min.js"></script> 
<script src="<?php //echo $link; ?>js/jquery.peity.min.js"></script> 
<script src="<?php //echo $link; ?>js/matrix.interface.js"></script> 
<script src="<?php //echo $link; ?>js/matrix.popover.js"></script>-->

<script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
                resetMenu();
            }
            // else, send page to designated URL            
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>
</body>
</html>
