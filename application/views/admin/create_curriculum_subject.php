<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
echo $curriculum_information;
//echo $curriculum_subject_form;
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6">

            <div class="widget-box collapsible">
                <div class="widget-title"> 
                    <a href="#collapseOne" data-toggle="collapse">
                        <span class="icon"><i class="icon-list"></i></span>
                            <?php echo heading(lang('create_subject_heading'), 5); ?>
                    </a>
                </div>

                <?php
                echo form_open("create-curriculum-subject?curriculum-id=$curriculum_id&type=$type", array(
                    'class'      => 'form-horizontal',
                    'id'         => 'basic_validate',
                    'novalidate' => 'novalidate'
                ));


                /**
                 * inputs
                 */
                $this->load->view('admin/_templates/form_view', array(
                    'index_iputs' => 0,
                    'type'        => $type,
                    '_dropdown_for_subjects'=>$_dropdown_for_subjects
                ));
                
                
                echo '<div id="newformplease">dfdf</div>';

                echo ' <div class="form-actions" id="div">';
                echo form_reset('reset', 'Reset', array(
                    'class' => 'btn btn-default'
                ));
                echo form_submit('submit', lang('create_subject_submit_button_label'), array(
                    'class' => 'btn btn-success'
                ));
                echo'<a href="#basic_validate" class="btn btn-info" onclick="loaddata();">add form test</a>';

                echo '</div>';
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
