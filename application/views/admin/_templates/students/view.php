<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
                    <h5><?php echo $this->config->item('project_title'); ?></h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <table class="">
                                <tbody>
                                    <tr>
                                        <td><h4><?php echo $student->student_lastname . ', ' . $student->student_firstname . ' ' . $student->student_middlename; ?></h4></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $student->student_address_town; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $student->student_address_region; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile Phone: <?php echo $student->student_personal_contact_number; ?></td>
                                    </tr>
                                    <tr>
                                        <td ><?php echo $student->student_personal_email; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>

                                    <tr>
                                        <td class="width30">School ID:</td>
                                        <td class="width70"><strong><?php echo $student->student_school_id; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Issue Date:</td>
                                        <td><strong>March 23, 2013</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Due Date:</td>
                                        <td><strong>April 01, 2013</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="width30">Client Address:</td>
                                        <td class="width70">
                                            <?php echo $student->student_permanent_address; ?>
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
                            echo '<div class="pagination alternate">';
                            echo $table_subjects_pagination;
                            echo '</div>';
                            ?>
                            <table class="table table-bordered table-invoice-full">
                                <tbody>
                                    <tr>
                                        <td class="msg-invoice" width="85%"><h4>Payment method: </h4>
                                            <a href="#" class="tip-bottom" title="Wire Transfer">Wire transfer</a> |  <a href="#" class="tip-bottom" title="Bank account">Bank account #</a> |  <a href="#" class="tip-bottom" title="SWIFT code">SWIFT code </a>|  <a href="#" class="tip-bottom" title="IBAN Billing address">IBAN Billing address </a></td>
                                        <td class="right"><strong>Subtotal</strong> <br>
                                            <strong>Tax (5%)</strong> <br>
                                            <strong>Discount</strong></td>
                                        <td class="right"><strong>$7,000 <br>
                                                $600 <br>
                                                $50</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pull-right">
                                <h4><span>Amount Due:</span> $7,650.00</h4>
                                <br>
                                <a class="btn btn-primary btn-large pull-right" href="">Pay Invoice</a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
