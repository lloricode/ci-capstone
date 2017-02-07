<?php

defined('BASEPATH') or exit('Direct Script is not allowed');


//student_school_id:
$tmp = (form_error('student_school_id_temp') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_school_id_label', 'student_school_id_temp', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_input($student_school_id_temp, array(
    'id' => 'inputError'
));
echo form_error('student_school_id_temp');
echo '</div></div> ';


//course_id:
$tmp = (form_error('course_id') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_course_label', 'course_id', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_dropdown('course_id', $course_id_value, set_value('course_id'));
echo form_error('course_id');
echo '</div></div> ';



//student_year_level:
$tmp = (form_error('student_year_level') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_year_level_label', 'student_year_level', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_dropdown('student_year_level', $student_year_level_value, set_value('student_year_level'));
echo form_error('student_year_level');
echo '</div></div> ';


