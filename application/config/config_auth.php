<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['min_password_length'] = 8; // Minimum Required Length of Password (not enforced by lib - see note above)

$config['forgot_password_expiration'] = 1800; // The number of seconds after which a forgot password request will expire. If set to 0, forgot password requests will not expire.