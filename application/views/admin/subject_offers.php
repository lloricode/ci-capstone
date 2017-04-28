<?php

defined('BASEPATH') OR exit('No direct script allowed');
if (isset($table_subject_offers))
{
        echo $table_subject_offers;
}
if (isset($view))
{
        if (isset($facullty_schedule_students))
        {
                echo $facullty_schedule_students;
        }
        echo $view;
}
