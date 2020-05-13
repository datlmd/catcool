<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['facebook_app_id']                = '515475869331347';
$config['facebook_app_secret']            = '3031ad5345c5b92351be7f9796117189';
$config['facebook_login_redirect_url']    = 'members/social_login?type=fb';
$config['facebook_logout_redirect_url']   = 'members/logout_facebook';
$config['facebook_login_type']            = 'web';
$config['facebook_permissions']           = array('email');//, 'user_friends', 'public_profile', 'user_birthday');
$config['facebook_graph_version']         = 'v3.2';
$config['facebook_auth_on_load']          = TRUE;
