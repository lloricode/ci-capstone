<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 
        <?php echo $this->config->item('current_year_footer'); ?> &copy;
        <a href="<?php echo $this->config->item('project_title_link'); ?>"><?php echo $this->config->item('project_title'); ?></a>.
        <a href="<?php echo $this->config->item('project_web_link'); ?>"><?php echo $this->config->item('project_web'); ?></a> 
    </div>
</div>

<!--end-Footer-part-->
<?php
/**
 * echo generated link/script tags
 */
echo $bootstrap['footer'];
echo $bootstrap['footer_extra'];
?>
</body>
</html>
