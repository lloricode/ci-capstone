<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                    <h5><?php echo lang('create_room_heading') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="form-horizontal">
                        <?php
                        echo form_open(site_url('create-room'), array(
                            'class' => 'form-horizontal'));
                        //room_number:
                        echo input_bootstrap($room_number, 'create_room_number_label');

                        //room_description:
                        echo input_bootstrap($room_description, 'create_room_description_label');

                        echo ' <div class="form-actions">';

                        echo form_reset('reset', 'Reset', array(
                            'class' => 'btn btn-default'
                        ));

                        echo form_submit('submit', lang('create_room_submit_button_label'), array(
                            'class' => 'btn btn-success'
                        ));
                        echo '<div id="status"></div>';
                        echo '</div>';
                        echo form_close();
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
