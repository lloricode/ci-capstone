<?php

defined('BASEPATH') OR exit('No direct script allowed');
if (isset($table_rooms))
{
        echo '<div class="alert-success">' . $message . '</div>';
        echo $table_rooms;
}
