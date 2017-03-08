<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 
        <?php echo $this->config->item('current_year_footer'); ?> &copy;
        <?php echo anchor($this->config->item('project_title_link'), $this->config->item('project_title')) ?>.
        <?php echo anchor($this->config->item('project_web_link'), $this->config->item('project_web')) ?>
    </div>
</div>

<!--end-Footer-part-->
<?php
/**
 * echo generated link/script tags
 */
echo $bootstrap['footer'];
echo script_tag(base_url('assets/custom_js/flashdata_fade.js'));
echo $bootstrap['footer_extra'];
?>


</body>
</html>
