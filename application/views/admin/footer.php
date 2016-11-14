<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$link = 'assets/framework/bootstrap/admin/';
?>

</div>	<!--/.main-->
<script src="<?php echo base_url($link); ?>js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url($link); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url($link); ?>js/chart.min.js"></script>
<script src="<?php echo base_url($link); ?>js/chart-data.js"></script>
<script src="<?php echo base_url($link); ?>js/easypiechart.js"></script>
<script src="<?php echo base_url($link); ?>js/easypiechart-data.js"></script>
<script src="<?php echo base_url($link); ?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url($link); ?>js/bootstrap-table.js"></script>
<script>
    $('#calendar').datepicker({
    });
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
