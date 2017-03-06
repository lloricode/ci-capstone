<?php

defined('BASEPATH') OR exit('No direct script allowed');

if (isset($create_curriculum_subject_button))
{
        echo $create_curriculum_subject_button;
}
/**
 * for view
 */
if (isset($table_corriculum_subjects))
{
        echo '<div class="alert-success">' . $message . '</div>';
        echo $table_corriculum_subjects;
}

if (isset($table_curriculm))
{
        echo '<div class="alert-success">' . $message . '</div>';
        echo $table_curriculm;
}
