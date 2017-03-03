<?php

defined('BASEPATH') OR exit('No direct script allowed');
if (isset($table_courses))
{
        echo '<div class="alert-success">' . $message . '</div>';
        echo $table_courses;
}
