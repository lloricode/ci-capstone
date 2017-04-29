<?php
defined('BASEPATH') OR exit('No direct script allowed');
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-list"></i> </span>
                    <h5><?php echo lang('curriculum_label'); ?></h5>
                </div>
                <div class="widget-content"> 
                    <h5>Effective Year</h5>
                    <h2><?php echo $curriculum_obj->curriculum_effective_school_year; ?></h2> 
                    <h5>Course</h5>
                    <h2><?php echo $curriculum_obj->course->course_code; ?></h2> 
                    <h5>Description</h5>
                    <h2><?php echo $curriculum_obj->curriculum_description; ?></h2> 
                    <h5>Status</h5>
                    <h2><?php echo ($curriculum_obj->curriculum_status) ? 'Active' : 'Inactive'; ?></h2> 
                </div>
            </div>
        </div>
    </div>
</div>