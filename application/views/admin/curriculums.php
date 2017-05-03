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
        echo $table_corriculum_subjects;
}

if (isset($table_curriculm))
{
        echo $table_curriculm;
}
