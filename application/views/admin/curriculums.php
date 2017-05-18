<?php

defined('BASEPATH') OR exit('No direct script allowed');

/**
 * for view
 */
if (isset($table_corriculum_subjects))
{
        echo $curriculum_information;
        if (isset($create_curriculum_subject_major_button))
        {
                echo $create_curriculum_subject_major_button;
        }
        if (isset($create_curriculum_subject_monor_button))
        {
                echo $create_curriculum_subject_monor_button;
        }
         if (isset($view_by_semester_btn))
        {
                echo $view_by_semester_btn;
        }
         if (isset($export_curriculum_btn))
        {
                echo $export_curriculum_btn;
        }
        echo $table_corriculum_subjects;
}

if (isset($table_curriculm))
{
        if (isset($curriculum_button_view_all))
        {
                echo $curriculum_button_view_all;
        }
        echo $table_curriculm;
}
