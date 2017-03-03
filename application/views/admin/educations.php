<?php

defined('BASEPATH') OR exit('No direct script allowed');
if (isset($table_educations))
{
        echo '<div class="alert-success">' . $message . '</div>';
        echo $table_educations;
}
