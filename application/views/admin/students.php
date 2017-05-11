<?php

defined('BASEPATH') OR exit('No direct script allowed');


if (isset($student_per_course_report_btn))
{
        echo $student_per_course_report_btn;
}
/**
 * for table
 */
if (isset($table_students))
{
        if (isset($search_result_label))
        {
                echo '<div class="container-fluid">
    <div class="row-fluid">';
                echo $search_result_label;
                echo '</div></div>';
        }
        echo $table_students;
}
/**
 * for view
 */
if (isset($view))
{
        echo $view;
}


/**
 * search form for dean users_group
 */
if (isset($search_form_for_dean))
{
        echo $search_form_for_dean;
}
                
