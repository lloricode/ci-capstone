<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<head>
    <title>Student's Copy</title>
    <?php //--------------STYLE-------------- ?>
    <style>
        /*
       *
       *author: Edzar Calibod <edzcalibod@gmail.com>
       */
        html
        {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            font-size: 14px;
        }      

        table, td, th {    
            border: 2px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 10px;
        }

        .White{
            color:white;
        }

        .MaterialAColorFont{
            color:#5f6468;
        }

        /*---------- Margins---------*/
        .Title-Margin{
            margin-top: -80px;
            text-align: center;
        }

        .Title-address{
            margin-top: -15px;
            text-align: center;
        }
        .Info-Margin{
            margin-left: 20px;
        }
        .MarginTop{
            margin-top: 10px;
        }

        .isNew{
            position: absolute; /*or fixed*/
            right: 65px;
            margin-top: -70px;
        }

        .marginTop_10{
            margin-top: 10px;
        }

        .stud_name{
            margin-top: 30px;
            font-size: 20px;
        }

        .stud_secondary_info{
            margin-top: -35px;
        }

        .stud_tertiary_info{
            margin-top: -15px;
        }
        /*---------- End of margin---------*/

        /*-----------Colors----------*/
        .blue{        
            width:auto; 
            height:100px;
        }
        .darkblue{
            width:auto; 
            height:60px;
            margin-top: -10px;
        }
        /*-----------End of the colors----------*/

        /*------Nix Coop Image-------*/
        .imageSize{
            margin-left: 5px;
            margin-top: 15px;
            width:70px;
        }     
    </style>
    <?php //--------------END OF THE STYLE-------------- ?>
</head>

<div class="blue">
    <?php
    echo img(array(
        'src'   => $this->config->item('default_student_image_in_table'),
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
    <p class="marginTop_10"> Term: <u><?php echo semesters($this->student->semester); ?></u></p>
    <p class="marginTop_10"> S.Y: <u><?php echo $this->student->school_year; ?></u></p>
</div>
<?php //-------------HEADER2------------ ?>
<div class="darkblue">
    <p class="stud_name Info-Margin"><?php echo $this->student->fullname ?></p><br>
    <p class="stud_secondary_info Info-Margin"><?php echo $this->student->course_code . ' - ' . $this->student->level_place; ?></p>
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


<?php
echo $subjecs;
//if (isset($print_link))
//{
//        echo $print_link;
//}

