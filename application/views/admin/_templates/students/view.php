<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function info_row($str)
{
        if ($str == '')
        {
                return;
        }
        return '<tr><td>' . $str . '</td></tr>';
}

function function_row_td($link, $label, $popup = FALSE)
{
        return table_row_button_link($link, $label, NULL, array('title' => $label, 'class' => "tip-bottom"), $popup);
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
                    <?php echo heading($this->config->item('project_title'), 5); ?>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>
                                    <tr>
                                        <td><img src="<?php echo $image_src; ?>" alt="no image" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo heading($this->student->fullname, 4); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->student->address; ?></td>
                                    </tr>
                                    <?php echo info_row($this->student->town); ?>
                                    <?php echo info_row($this->student->region); ?>
                                    <?php echo info_row($this->student->contact); ?>
                                    <?php echo info_row($this->student->email); ?>
                                    <tr>
                                        <td><?php echo $this->student->birthdate; ?></td>
                                    </tr> 
                                    <tr>
                                        <td><?php echo $this->student->age(TRUE); ?></td>
                                    </tr> 
                                </tbody>
                            </table>                        
                        </div>
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>
                                    <tr>
                                        <td class="width30">School ID:</td>
                                        <td class="width70"><?php echo bold($this->student->school_id()); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Course / Year</td>
                                        <td><?php echo bold($this->student->course_code . ' - ' . $this->student->level_roman); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td> <?php echo bold($this->student->is_enrolled(TRUE)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Enrolled Term</td>
                                        <td> <?php echo bold($this->student->enrolled_term_year()); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Enrolled Curriculum</td>
                                        <td> <?php echo $this->student->curriculum(TRUE); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >
                                            <?php
                                            if ($this->Enrollment_status_model->status())
                                            {
                                                    /**
                                                     * add subject
                                                     */
                                                    $lang_for_add_subject = ($this->student->is_enrolled()) ? lang('add_student_enrolled___subject_label') : lang('add_student_subject_label');
                                                    echo function_row_td('create-student-subject?student-id=' . $this->student->id, $lang_for_add_subject);
                                            }
                                            if ($this->student->is_has_pending())
                                            {
                                                    /**
                                                     * set enroll added subject/s
                                                     */
                                                    echo function_row_td('students/set-enroll-added-subjects?student-id=' . $this->student->id, 'Enroll Added Subject/s');
                                            }
                                            if ($this->student->is_enrolled())
                                            {
                                                    /**
                                                     * print
                                                     */
                                                    echo function_row_td('students/print_data?action=prev&student-id=' . $this->student->id, lang('print_label'), TRUE);
                                            }
                                            if (( ! $this->student->is_enrolled()) &&
                                                    $this->Enrollment_status_model->status() &&
                                                    specific_groups_permission('accounting'))
                                            {
                                                    /**
                                                     * set enroll
                                                     */
                                                    echo function_row_td('students/set-enroll?student-id=' . $this->student->id, 'Set Enroll');
                                            }
                                            if (in_array('edit-student', permission_controllers()))
                                            {
                                                    /**
                                                     * print
                                                     */
                                                    echo function_row_td('edit-student?student-id=' . $this->student->id, 'Edit');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">

                            <?php
                            /*
                             * subjects table
                             */
                            echo $table_subjects;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
