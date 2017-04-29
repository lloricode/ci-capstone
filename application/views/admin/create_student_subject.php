<?php
defined('BASEPATH') or exit('Direct Script is not allowed');


echo $student_subject_curriculum_table;
echo $added_subject_table;
if (isset($reset_subject_offer_session))
{
        echo $reset_subject_offer_session;
}
echo '<div class="container-fluid"> <div class="row-fluid">';
echo $student_subject_form;
?>
<div class="span<?php echo $form_size; ?>">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-<?php echo $icon; ?>"></i> </span>
            <h5><?php echo 'Units' ?></h5>
        </div>
        <div class="widget-content nopadding">
            <div class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
                <?php
                foreach ($term_units as $k => $v)
                {
                        echo input_bootstrap($v);
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
echo '</div></div>';
