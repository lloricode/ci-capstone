<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student's Copy</title>
        <?php echo link_tag('assets/custom_ccs/print_style.css') ?>
    </head>
    <body>
        <div class="blue">
            <?php
            echo img(array(
                'src'   => $this->config->item('print_student_copy_logo'),
                'class' => 'imageSize'
            ));
            ?>
            <p class="Title-Margin"> <?php echo $report_info->school_name; ?></p>
            <p class="Title-address"> <?php echo $report_info->school_address; ?></p>
            <p class="Title-address"> <?php echo $report_info->school_contact; ?></p>
        </div>

        <div class="isNew">
            <input type="checkbox"> New Student<br>
            <input type="checkbox"> Old Student
            <p class="marginTop_10"> Term: <u><?php echo $this->student->semester; ?></u></p>
            <p class="marginTop_10"> S.Y: <u><?php echo $this->student->school_year; ?></u></p>
        </div>

        <?php //-------------HEADER2------------ ?>

        <div class="darkblue">
            <p class="stud_name Info-Margin"><?php echo $this->student->fullname ?></p><br>
            <p class="stud_secondary_info Info-Margin"><?php echo $this->student->course_code . ' - ' . $this->student->level_roman; ?></p>
            <p class="stud_tertiary_info Info-Margin"><?php echo $this->student->school_id(); ?></p>
        </div>

        <?php echo br(2); ?>

        <table border="1">
            <tbody>
                <tr>
                    <td class="width70"> Address: <?php echo $this->student->address; ?></td>
                    <td class="width70"> Contact: <?php echo $this->student->contact; ?></td>
                </tr>
                <tr>
                    <td class="width70"> Town: <?php echo $this->student->town; ?></td>
                    <td class="width70"> Email: <?php echo $this->student->email; ?></td>
                </tr>
                <tr>
                    <td class="width70"> Region: <?php echo $this->student->region; ?></td>
                    <td class="width70"> Civil Status: <?php echo $this->student->civil_status; ?></td>
                </tr>
                <tr>
                    <td class="width70"> Birthdate: <?php echo $this->student->birthdate; ?></td>
                    <td class="width70"> Nationality: <?php echo $this->student->nationality; ?></td>
                </tr>
                <tr>
                    <td class="width70"> Age: <?php echo $this->student->age(TRUE); ?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>

<?php
echo $subjecs;
//if (isset($print_link))
//{
//        echo $print_link;
//}

