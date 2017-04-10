<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<table border="1">
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
</table>     
<table border="1">
    <tbody>
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


<?php
echo $subjecs;
if (isset($print_link))
{
        echo $print_link;
}
