<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_student_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("admin/create-student/index"), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



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



                    //student_school_id:
                    $tmp = (form_error('student_school_id') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_student_school_id_label', 'student_school_id', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($student_school_id, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('student_school_id');
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



                    //course_id:
                    $tmp = (form_error('course_id') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('create_course_id_label', 'course_id', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($course_id, $course_id_value);
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
                    echo form_dropdown($student_year_level, $student_year_level_value);
                    echo form_error('student_year_level');
                    echo '</div></div> ';



                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('create_student_submit_button_label'), array(
                        'class' => 'btn btn-success'
                    ));

                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    echo '</div>';
                    echo form_close();
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

