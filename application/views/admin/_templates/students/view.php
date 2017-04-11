<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
                    <h5><?php echo $this->config->item('project_title'); ?></h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>
                                    <tr>
                                        <td><h4><?php echo $this->student->fullname; ?></h4></td>
                                    </tr>
                                    <tr>
                                        <td ><?php echo $this->student->address; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->student->town; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->student->region; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->student->contact; ?></td>
                                    </tr>
                                    <tr>
                                        <td ><?php echo $this->student->email; ?></td>
                                    </tr> 
                                    <tr>
                                        <td ><?php echo $this->student->birthdate; ?></td>
                                    </tr> 
                                    <tr>
                                        <td ><?php echo $this->student->age(TRUE); ?></td>
                                    </tr> 
                                </tbody>
                            </table>                        </div>
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>
                                    <tr>
                                        <td><img src="<?php echo $image_src; ?>" alt="no image" /></td>
                                    </tr>

                                    <tr>
                                        <td class="width30">School ID:</td>
                                        <td class="width70"><strong><?php echo $this->student->school_id(); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Course</td>
                                        <td><strong><?php echo $this->student->course_code . ' - ' . $this->student->course_description; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Year Level</td>
                                        <td><strong> <?php echo $this->student->level_place; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><strong> <?php echo $this->student->is_enrolled(TRUE); ?></strong></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <table class="table table-bordered table-invoice-full">
                                <tbody>
                                    <tr>
<!--                                        <td class="msg-invoice" width="40%">
                                            <h4>Payment method: </h4>
                                            <a href="#" class="tip-bottom" title="Wire Transfer">Wire transfer</a> |
                                            <a href="#" class="tip-bottom" title="Bank account">Bank account #</a> | 
                                            <a href="#" class="tip-bottom" title="SWIFT code">SWIFT code </a>|  
                                            <a href="#" class="tip-bottom" title="IBAN Billing address">IBAN Billing address </a>
                                        </td>
                                        <td class="right">
                                            <strong>Subtotal</strong> <br>
                                            <strong>Tax (5%)</strong> <br>
                                            <strong>Discount</strong>
                                        </td>-->
                                        <?php if ($this->Enrollment_status_model->status()): ?>
                                                <td >
                                                    <!--                                            <div class="pull-right">-->
                                                    <!--                                <h4><span>Amount Due:</span> $7,650.00</h4>-->
                                                    <!--<br>-->
                                                    <?php echo anchor(site_url('create-student-subject?student-id=' . $this->student->id), lang('add_student_subject_label'), array('class' => 'btn btn-primary btn-large pull')); ?>
                                                    <!--                                            </div>-->
                                                </td>
                                        <?php endif; ?>
                                        <?php if ($this->Enrollment_status_model->status()): ?>
                                                <td >
                                                    <!--                                            <div class="pull-right">-->
                                                    <!--                                <h4><span>Amount Due:</span> $7,650.00</h4>-->
                                                    <!--<br>-->
                                                    <?php echo anchor_popup(site_url('students/print_data?action=prev&student-id=' . $this->student->id), lang('print_label'), array('class' => 'btn btn-primary btn-large pull')); ?>
                                                    <!--                                            </div>-->
                                                </td>
                                        <?php endif; ?>
                                        <?php
                                        if (( ! $this->student->is_enrolled()) &&
                                                $this->Enrollment_status_model->status() &&
                                                specific_groups_permission('accounting')):
                                                ?>
                                                <td >
                                                    <!--                                            <div class="pull-right">-->
                                                    <!--                                <h4><span>Amount Due:</span> $7,650.00</h4>-->
                                                    <!--<br>-->
                                                    <?php echo anchor(site_url('students/set-enroll?student-id=' . $this->student->id), 'Set Enroll', array('class' => 'btn btn-primary btn-large pull')); ?>
                                                    <!--                                            </div>-->
                                                </td>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>

                            <?php
                            /*
                             * subjects table
                             */
                            echo $table_subjects;
                            if (isset($table_subjects_pagination))
                            {
                                    echo '<div class = "pagination alternate pull-right">';
                                    echo $table_subjects_pagination;
                                    echo '</div>';
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
