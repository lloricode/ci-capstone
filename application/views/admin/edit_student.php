<?php
defined('BASEPATH') or exit('no direct script allowed');
echo form_open_multipart(site_url("edit-student?student-id=" . $this->student->id), array(
    'class' => 'form-horizontal'
));
?>
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

                        echo image_view(array(
                            'src'   => $this->Student_model->image_resize()->profile,
                            'alt'   => 'no image for [ ' . $this->student->school_id(TRUE) . ' ]',
                            'title' => $this->student->school_id . ' - ' . $this->student->fullname,
                        ));
                        //student_image:
                        echo input_bootstrap($student_image);

                        //student_firstname:
                        echo input_bootstrap($student_firstname);

                        //student_middlename:
                        echo input_bootstrap($student_middlename);

                        //student_lastname:
                        echo input_bootstrap($student_lastname);


                        //student_gender:
                        echo input_bootstrap($student_gender);


                        //student_birthdate:                        
                        echo input_bootstrap($student_birthdate);

                        //student_birthplace:
                        echo input_bootstrap($student_birthplace);

                        //student_civil_status:
                        echo input_bootstrap($student_civil_status);

                        //student_nationality:
                        echo input_bootstrap($student_nationality);

                        //student_permanent_address:
                        echo input_bootstrap($student_permanent_address);
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
                        echo input_bootstrap($student_school_id_temp);

                        //course_id:                      
                        echo input_bootstrap($course_id);

                        //student_year_level:
                        echo input_bootstrap($enrollment_year_level);

                        //student_school_year: 
                        echo input_bootstrap($enrollment_school_year);

                        //student_semesterl:
                        echo input_bootstrap($enrollment_semester);
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
                        echo input_bootstrap($student_personal_email);

                        //personal_contact_number:
                        echo input_bootstrap($student_personal_contact_number);

                        //address_town:
                        echo input_bootstrap($student_address_town);

                        //address_region:
                        echo input_bootstrap($student_address_region);



                        //guardian_contact_number:
                        echo input_bootstrap($student_guardian_contact_number);


                        //guardian_fullname:
                        echo input_bootstrap($student_guardian_fullname);

                        //guardian_email:
                        echo input_bootstrap($student_guardian_email);
                        //guardian_address:
                        echo input_bootstrap($student_guardian_address);
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