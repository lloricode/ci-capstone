<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<head>
    <?php //--------------STYLE-------------- ?>
    <style>
        /*
       *author: Edzar Calibod edzcalibod@gmail.com
       */
        html
        {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }   
        .font14{
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

        .stud_type_div{
            position: absolute; /*or fixed*/
            right: 70px;
            top: 50px;
        }

        /*---------- Margins---------*/
        .Title-Margin{
            margin-top: -80px;
        }
        .Info-Margin{
            margin-left: 20px;

        }
        .MarginTop{
            margin-top: 10px;
        }

        .header_address{
            margin-top: -15px;
        }

        .header_stud_copy{
            margin-top: 30px;
        }
        /*---------- End of margin---------*/

        /*-----------Colors----------*/
        .blue{                                            
           
            width:auto; 
            height:140px;
        }
        .darkblue{
           
            width:auto; 
            height:100px;
        }
        /*-----------End of the colors----------*/
        .imageSize{
            margin-top:5px;
            margin-left:2px;
            width: 90px;
        }   

    </style>
    <?php //--------------END OF THE STYLE-------------- ?>
</head>

<?php //-------------HEADER------------ ?>
<div class="blue">
    <!--<img class="imageSize" src="<?php //base_url('assets/images/12592496_1001014029969291_6363135005697809320_n.PNG');    ?> "  alt=""/>-->
    <?php
    echo img(array(
        'src'   => $this->config->item('default_student_image_in_table'),
        'class' => 'imageSize'
    ));
    ?>
    <center>
        <p class="   Title-Margin">DIPOLOG CITY INSTITUTE OF TECHNOLOGY</p>
        <p class="  header_address">National Highway Minaog, Dipolog City</p>
        <p class="  header_address">Tel. No. (065) 212-2979 / (065) 908-0064</p>


        <p class="   header_stud_copy"><u>(STUDENT'S COPY)</u></p>
    </center>

    
</div>
<div class="stud_type_div"> 
   
        <input type="checkbox"> New Student<br>
        <input type="checkbox"> Old Student<br>
        
        <p class="header_stud_copy"> S.Y: <u><?php echo $this->student->semester; ?></u></p>
    
</div>
<?php //-------------HEADER2------------  ?>
<div class="darkblue">
    <br>
    <p class=" MarginTop Info-Margin">Name : <?php echo $this->student->fullname; ?></p>
    <p class=" MarginTop Info-Margin">Course : <?php echo $this->student->course_code . ' - ' . $this->student->level_place; ?> </p>
</div><br><br>
<!--start pare-->
<body>
    <table border="1">
        <tbody>
            <tr>
                <td class="width30 font14">Address: <?php echo $this->student->address; ?></td>
                <td class="width30 font14"> School ID: <?php echo $this->student->school_id; ?></td>
            </tr>
            <tr>
                <td class="width30 font14">Town: <?php echo $this->student->town; ?></td>
                <td>Status:  <?php echo $this->student->is_enrolled(TRUE); ?></td>
            </tr>
            <tr>
                <td class="width30 font14">Region: <?php echo $this->student->region; ?></td>
            </tr>
            <tr>
                <td class="width30 font14">Contact: <?php echo $this->student->contact; ?></td>
            </tr>
            <tr>
                <td class="width30 font14">Email: <?php echo $this->student->email; ?></td>
            </tr>
            <tr>
                <td class="width30 font14">Birthdate: <?php echo $this->student->birthdate; ?></td>
            </tr> 
            <tr>
                <td class="width30 font14">Age: <?php echo $this->student->age(TRUE); ?></td>
            </tr> 

        </tbody>
    </table>     
</body>

<?php
echo $subjecs;
if (isset($print_link))
{
        echo $print_link;
}
