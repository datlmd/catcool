<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['google']['client_id']        = '515995961004-h0h0f4t93g6nf2o7kos5rcjoo75q7d6q.apps.googleusercontent.com';
$config['google']['client_secret']    = '9LVGDYeCGuV7N39MwxoT13yS';
$config['google']['redirect_uri']     = 'http://localhost/dev/catcool/customers/social_login?type=gg';
$config['google']['application_name'] = 'Login to Cat Cool CMS';
$config['google']['api_key']          = '';
$config['google']['scopes']           = array('email', 'profile');

$config['facebook']['app_id']                = '515475869331347';
$config['facebook']['app_secret']            = '3031ad5345c5b92351be7f9796117189';
$config['facebook']['login_redirect_url']    = 'customers/social_login?type=fb';
$config['facebook']['logout_redirect_url']   = 'customers/logout_facebook';
$config['facebook']['login_type']            = 'web';
$config['facebook']['permissions']           = array('email');//, 'user_friends', 'public_profile', 'user_birthday');
$config['facebook']['graph_version']         = 'v3.2';
$config['facebook']['auth_on_load']          = TRUE;