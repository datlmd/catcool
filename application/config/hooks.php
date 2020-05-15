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

//dat add develbar
if (!empty(config_item('enable_develbar')) && config_item('enable_develbar') == TRUE) {
    $hook['display_override'][] = [
        'class' => 'Develbar',
        'function' => 'debug',
        'filename' => 'Develbar.php',
        'filepath' => 'third_party/DevelBar/hooks'
    ];
}

$hook['post_controller_constructor'][] = [
    'function' => 'redirect_ssl',
    'filename' => 'Ssl.php',
    'filepath' => 'hooks'
];