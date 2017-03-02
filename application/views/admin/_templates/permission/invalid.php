<?php

defined('BASEPATH') OR exit('No direct script access allowed');

echo '<p>' . lang('only_admin_user_group_allowed_current_controller') . '</p>';

echo '<h5>"' . $controller_obj->controller_name . '"</h5>';
