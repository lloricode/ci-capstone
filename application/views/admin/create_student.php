<?php
echo form_open(base_url("admin/create-student/index"), array(
    'class' => 'form-horizontal'
        ), $student_school_id);
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
                        //student_firstname:
                        echo input_bootstrap($student_firstname, 'create_student_firstname_label');

                        //student_middlename:
                        echo input_bootstrap($student_middlename, 'create_student_middlename_label');

                        //student_lastname:
                        echo input_bootstrap($student_lastname, 'create_student_lastname_label');



                        //student_gender:
                        $tmp             = (form_error('student_gender') == '') ? '' : ' error';
                        echo '<div class="control-group' . $tmp . '">';
                        echo lang('create_student_gender_label', 'student_gender', array(
                            'class' => 'control-label',
                            'id'    => 'inputError'
                        ));
                        echo '<div class="controls">';
                        $set_vale_gender = set_value('student_gender');
                        $male            = FALSE;
                        $female          = FALSE;
                        if ($set_vale_gender == 'male')
                        {
                                $male = TRUE;
                        }
                        else if ($set_vale_gender == 'female')
                        {
                                $female = TRUE;
                        }
                        ?>
                        <label>
                            <?php echo form_radio('student_gender', 'female', $female); ?>
                            Female
                        </label>   
                        <label>
                            <?php echo form_radio('student_gender', 'male', $male); ?>
                            Male
                        </label> 
                        <?php
                        echo form_error('student_gender');

                        echo '</div></div>';

                        //student_birtdate:                        
                        echo input_bootstrap($student_birtdate, 'create_student_birthdate_label');

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
                        echo input_dropdown_bootstrap('course_id', 'create_course_label', $course_id_value);

                        //student_year_level:
                        echo input_dropdown_bootstrap('student_year_level', 'student_year_level', $student_year_level_value);
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
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Contacts</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="form-horizontal">
                        <?php
                        //guardian_fullname:
                        echo input_bootstrap($student_guardian_fullname, 'create_student_guardian_fullname_label');

                        //address_town:
                        echo input_bootstrap($student_address_town, 'create_student_town_label');

                        //address_region:
                        echo input_bootstrap($student_address_region, 'create_student_region_label');

                        //guardian_address:
                        echo input_bootstrap($student_guardian_address, 'create_student_guardian_address_label', 'textarea');

                        //personal_contact_number:
                        echo input_bootstrap($student_personal_contact_number, 'create_student_personal_contact_label');

                        //guardian_contact_number:
                        echo input_bootstrap($student_guardian_contact_number, 'create_student_guardian_contact_label');

                        //personal_email:
                        echo input_bootstrap($student_personal_email, 'create_student_personal_email_label');

                        //guardian_email:
                        echo input_bootstrap($student_guardian_email, 'create_student_guardian_email_label');
                        ?>
                    </div>
                </div>
            </div>
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5>Others</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Tooltip Input</label>
                            <div class="controls">
                                <input type="text" placeholder="Hover for tooltip…" data-title="A tooltip for the input" class="span11 tip" data-original-title="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Type ahead Input</label>
                            <div class="controls">
                                <input type="text" placeholder="Type here for auto complete…" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source="[&quot;Alabama&quot;,&quot;Alaska&quot;,&quot;Arizona&quot;,&quot;Arkansas&quot;,&quot;California&quot;,&quot;Colorado&quot;,&quot;Ahmedabad&quot;,&quot;India&quot;,&quot;Florida&quot;,&quot;Georgia&quot;,&quot;Hawaii&quot;,&quot;Idaho&quot;,&quot;Illinois&quot;,&quot;Indiana&quot;,&quot;Iowa&quot;,&quot;Kansas&quot;,&quot;Kentucky&quot;,&quot;Louisiana&quot;,&quot;Maine&quot;,&quot;Maryland&quot;,&quot;Massachusetts&quot;,&quot;Michigan&quot;,&quot;Minnesota&quot;,&quot;Mississippi&quot;,&quot;Missouri&quot;,&quot;Montana&quot;,&quot;Nebraska&quot;,&quot;Nevada&quot;,&quot;New Hampshire&quot;,&quot;New Jersey&quot;,&quot;New Mexico&quot;,&quot;New York&quot;,&quot;North Dakota&quot;,&quot;North Carolina&quot;,&quot;Ohio&quot;,&quot;Oklahoma&quot;,&quot;Oregon&quot;,&quot;Pennsylvania&quot;,&quot;Rhode Island&quot;,&quot;South Carolina&quot;,&quot;South Dakota&quot;,&quot;Tennessee&quot;,&quot;Texas&quot;,&quot;Utah&quot;,&quot;Vermont&quot;,&quot;Virginia&quot;,&quot;Washington&quot;,&quot;West Virginia&quot;,&quot;Wisconsin&quot;,&quot;Wyoming&quot;]" class="span11">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Prepended Input</label>
                            <div class="controls">
                                <div class="input-prepend"> <span class="add-on">#</span>
                                    <input type="text" placeholder="prepend" class="span11">
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Appended Input</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input type="text" placeholder="5.000" class="span11">
                                    <span class="add-on">$</span> </div>
                            </div>
                        </div>
                        <div class="control-group warning">
                            <label class="control-label" for="inputWarning">Input with warning</label>
                            <div class="controls">
                                <input type="text" id="inputWarning" class="span11">
                                <span class="help-inline">Something may have gone wrong</span> </div>
                        </div>
                        <div class="control-group error">
                            <label class="control-label" for="inputError">Input with error</label>
                            <div class="controls">
                                <input type="text" id="inputError" class="span11">
                                <span class="help-inline">Please correct the error</span> </div>
                        </div>
                        <div class="control-group info">
                            <label class="control-label" for="inputInfo">Input with info</label>
                            <div class="controls">
                                <input type="text" id="inputInfo" class="span11">
                                <span class="help-inline">Username is already taken</span> </div>
                        </div>
                        <div class="control-group success">
                            <label class="control-label" for="inputSuccess">Input with success</label>
                            <div class="controls">
                                <input type="text" id="inputSuccess" class="span11">
                                <span class="help-inline">Woohoo!</span> </div>
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

                echo form_submit('btn2', lang('create_student_submit_button_label'), array(
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