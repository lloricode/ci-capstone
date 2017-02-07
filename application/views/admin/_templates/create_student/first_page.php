<?php

defined('BASEPATH') or exit('Direct Script is not allowed');
//student_firstname:
$tmp = (form_error('student_firstname') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_firstname_label', 'student_firstname', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_input($student_firstname, array(
    'id' => 'inputError'
));
echo form_error('student_firstname');
echo '</div></div> ';



//student_middlename:
$tmp = (form_error('student_middlename') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_middlename_label', 'student_middlename', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_input($student_middlename, array(
    'id' => 'inputError'
));
echo form_error('student_middlename');
echo '</div></div> ';




//student_lastname:
$tmp = (form_error('student_lastname') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_lastname_label', 'student_lastname', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_input($student_lastname, array(
    'id' => 'inputError'
));
echo form_error('student_lastname');
echo '</div></div> ';



//student_gender:
$tmp = (form_error('student_gender') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_gender_label', 'student_gender', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_input($student_gender, array(
    'id' => 'inputError'
));
echo form_error('student_gender');
echo '</div></div> ';



//student_permanent_address:
$tmp = (form_error('student_permanent_address') == '') ? '' : ' error';
echo '<div class="control-group' . $tmp . '">';
echo lang('create_student_permanent_address_label', 'student_permanent_address', array(
    'class' => 'control-label',
    'id'    => 'inputError'
));
echo '<div class="controls">';
echo form_input($student_permanent_address, array(
    'id' => 'inputError'
));
echo form_error('student_permanent_address');
echo '</div></div> ';




