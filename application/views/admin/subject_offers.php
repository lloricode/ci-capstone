<?php

defined('BASEPATH') OR exit('No direct script allowed');
if (isset($table_subject_offers))
{
        echo '<div class="alert-success">' . $message . '</div>';
        echo $table_subject_offers;
}
