<?php
defined('BASEPATH') OR exit('No direct script allowed');

/**
 * for view
 */
if (isset($table_corriculum_subjects))
{
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
                            <h5>Semester</h5>
                            <h2><?php echo semesters($curriculum_obj->curriculum_effective_semester); ?></h2> 
                            <h5>Course</h5>
                            <h2><?php echo $this->Course_model->get($curriculum_obj->course_id)->course_code; ?></h2> 
                            <h5>Status</h5>
                            <h2><?php echo ($curriculum_obj->curriculum_status) ? 'Active' : 'Inactive'; ?></h2> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo $create_curriculum_subject_button;
        echo $table_corriculum_subjects;
}

if (isset($table_curriculm))
{
        echo $table_curriculm;
}
