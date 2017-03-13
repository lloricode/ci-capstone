<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="quick-actions_homepage">
        <ul class="quick-actions">

            <?php foreach ($courses_info as $row): ?>
                    <li class="bg_<?php echo $row['color'] ?>"> 
                        <a href="<?php echo site_url('students?course-id=' . $row['course_id']); ?>"> 
                            <i class="icon-<?php echo $row['icon']; ?>"></i> 
                            <span class="label label-important"><?php echo $row['counts']; ?></span> 
                            <?php echo $row['code'] ?>
                        </a> 
                    </li>
            <?php endforeach; ?>

        </ul>
    </div>
</div>
