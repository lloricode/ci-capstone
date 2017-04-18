<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | Hooks
  | -------------------------------------------------------------------------
  | This file lets you define "hooks" to extend CI without hacking the core
  | files.  Please see the user guide for info:
  |
  |	https://codeigniter.com/user_guide/general/hooks.html
  |
 */

/* http://php.quicoto.com/how-to-speed-up-codeigniter/ */
$hook['display_override'] = array(
    'class' => '',
    'function' => 'compress',
    'filename' => 'compress.php',
    'filepath' => 'hooks'
);



/**
 * 
 * 
 * While you could create your own controller 
 * like a MY_Controller that derives from the CI_Controller, 
 * this is really not what it is meant for.
 * 
 * CodeIgniter supports something called hooks, 
 * which are scripts that are run at specific moments, 
 * much like events. There exists a hook that is called every time any controller is called,
 *  without you having to implement anything in the controller itself.
 * @reference: http://stackoverflow.com/a/34451507/3405221
 */
$hook['post_controller_constructor'][] = array(
    "class"    => "Check_access",
    "function" => "validate",
    "filename" => "Check_access.php",
    "filepath" => "hooks"
);
