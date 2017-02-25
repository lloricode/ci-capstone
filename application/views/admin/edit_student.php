<?php
defined('BASEPATH') or exit('no direct script allowed');
echo form_open_multipart(base_url("edit-student?student-id=" . $this->student->id), array(
    'class' => 'form-horizontal'
));
?>
<?php echo (isset($message)) ? $message : ''; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Personal Information</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="form-horizontal">
                        <?php
                        // echo validation_errors();
                        image_view(array(
                            'src'   => $this->config->item('student_image_dir') . $this->student->image,
                            'alt'   => 'no image for [ ' . $this->student->school_id . ' ]',
                            //  'class'  => 'post_images',
                            'width' => '200',
                            // 'height' => '200',
                            'title' => $this->student->school_id . ' - ' . $this->student->fullname,
                                //'rel'    => 'lightbox'
                        ));
                        //student_image:
                        echo input_bootstrap($student_image, 'create_student_image_label', 'file');

                        //student_firstname:
                        echo input_bootstrap($student_firstname, 'create_student_firstname_label');

                        //student_middlename:
                        echo input_bootstrap($student_middlename, 'create_student_middlename_label');

                        //student_lastname:
                        echo input_bootstrap($student_lastname, 'create_student_lastname_label');



                        //student_gender:
                        $gender_field    = $student_gender['name'];
                        $tmp             = (form_error($gender_field) == '') ? '' : ' error';
                        echo '<div class="control-group' . $tmp . '">';
                        echo lang('create_student_gender_label', $gender_field, array(
                            'class' => 'control-label',
                        ));
                        echo '<div class="controls">';
                        $set_vale_gender = $student_gender['value'];
                        $male            = FALSE;
                        $female          = FALSE;
                        if ($set_vale_gender == 'Male')
                        {
                                $male = TRUE;
                        }
                        else if ($set_vale_gender == 'Female')
                        {
                                $female = TRUE;
                        }
                        ?>
                        <label>
                            <?php echo form_radio($gender_field, 'Female', $female); ?>
                            Female
                        </label>   
                        <label>
                            <?php echo form_radio($gender_field, 'Male', $male); ?>
                            Male
                        </label> 
                        <?php
                        echo form_error($gender_field);

                        echo '</div></div>';

                        //student_birthdate:                        
                        echo input_bootstrap($student_birthdate, 'create_student_birthdate_label');

                        //student_birthplace:
                        echo input_bootstrap($student_birthplace, 'create_student_birthplace_label');

                        //student_civil_status:
                        echo input_bootstrap($student_civil_status, 'create_student_civil_status_label');

                        //student_nationality:
                        echo input_bootstrap($student_nationality, 'create_student_nationality_label');

                        //student_permanent_address:
                        echo input_bootstrap($student_permanent_address, 'create_student_permanent_address_label', 'textarea');
                        ?>

                    </div>
                </div>
            </div>
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>School Information</h5>
                </div>
                <div class="widget-content nopadding">
                    <div  class="form-horizontal">
                        <?php
                        //student_school_id:
                        echo input_bootstrap($student_school_id_temp, 'create_student_school_id_label');

                        //course_id:                       
                        echo input_dropdown_bootstrap($course_id['name'], 'create_course_label', $course_id['value']);

                        //student_year_level:
                        echo input_dropdown_bootstrap($enrollment_year_level['name'], 'create_student_year_level_label', $enrollment_year_level['value'], $enrollment_year_level['default']);

                        //student_school_year:                    
                      //  echo input_bootstrap($enrollment_school_year, 'create_student_school_year_label');
                        echo input_dropdown_bootstrap($enrollment_school_year['name'], 'create_student_school_year_label', $enrollment_school_year['value'], $enrollment_school_year['default']);

                        //student_semesterl:
                    //    echo input_bootstrap($enrollment_semester, 'create_student_semester_label');
                        echo input_dropdown_bootstrap($enrollment_semester['name'], 'create_student_semester_label', $enrollment_semester['value'], $enrollment_semester['default']);
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Contacts</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="form-horizontal">
                        <?php
                        //personal_email:
                        echo input_bootstrap($student_personal_email, 'create_student_personal_email_label');

                        //personal_contact_number:
                        echo input_bootstrap($student_personal_contact_number, 'create_student_personal_contact_label');

                        //address_town:
                        echo input_bootstrap($student_address_town, 'create_student_town_label');

                        //address_region:
                        echo input_bootstrap($student_address_region, 'create_student_region_label');



                        //guardian_contact_number:
                        echo input_bootstrap($student_guardian_contact_number, 'create_student_guardian_contact_label');


                        //guardian_fullname:
                        echo input_bootstrap($student_guardian_fullname, 'create_student_guardian_fullname_label');

                        //guardian_email:
                        echo input_bootstrap($student_guardian_email, 'create_student_guardian_email_label');
                        //guardian_address:
                        echo input_bootstrap($student_guardian_address, 'create_student_guardian_address_label', 'textarea');
                        ?>
                    </div>
                </div>
            </div>
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Requirements</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Old</label>
                            <div class="controls">
                                <label>
                                    <?php echo form_checkbox('newsletter', 'accept', TRUE); ?>
                                    First One</label>
                                <label>
                                    <input type="checkbox" name="radios" />
                                    Second One</label>
                                <label>
                                    <input type="checkbox" name="radios" />
                                    Third One</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">New</label>
                            <div class="controls">
                                <label>
                                    <input type="checkbox" name="radios" />
                                    First One</label>
                                <label>
                                    <input type="checkbox" name="radios" />
                                    Second One</label>
                                <label>
                                    <input type="checkbox" name="radios" />
                                    Third One</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Transferee</label>
                            <div class="controls">
                                <label>
                                    <input type="checkbox" name="radios" />
                                    First One</label>
                                <label>
                                    <input type="checkbox" name="radios" />
                                    Second One</label>
                                <label>
                                    <input type="checkbox" name="radios" />
                                    Third One</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <div class="row-fluid">
            <div class="widget-box">

                <?php
                echo ' <div class="form-actions">';

                echo form_reset('btn1', 'Reset', array(
                    'class' => 'btn btn-default'
                ));

                echo form_submit('submit', lang('edit_student_submit_button_label'), array(
                    'class' => 'btn btn-primary'
                ));
                echo '<div id="status"></div>';
                echo '</div>';
                ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>