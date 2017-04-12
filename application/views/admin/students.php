<?php

defined('BASEPATH') OR exit('No direct script allowed');

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
?>
                
