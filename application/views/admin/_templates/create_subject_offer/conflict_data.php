<?php
defined('BASEPATH') or exit('no direct script allowed');
if (isset($data_conflict)) :
        ?>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5><?php echo 'Conflict Data' ?></h5>
                        </div>
                        <div class="widget-content nopadding">
                            <?php
                            echo $data_conflict;
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($pagination))
                {
                        echo '<div class="pagination alternate">';
                        echo $pagination;
                        echo '</div>';
                }
                ?>
            </div>
        </div>

        <?php


 endif;