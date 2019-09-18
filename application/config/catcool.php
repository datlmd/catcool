<?php 

//theme frontend
$config['theme_frontend'] = "default";

//Theme admin
$config['theme_admin'] = "admin";

//Keywords website
$config['site_keywords'] = "codeigniter, themes, libraries, bkader, catcool";

//Description website
$config['site_description'] = "thiết kế website chuyên nghiệp";

//Tên website
$config['site_name'] = "Cat Cool CMS";

//Hiển thị Selectbox ngôn ngữ?
$config['is_show_select_language'] = TRUE;

//Đa ngôn ngữ?
$config['is_multi_language'] = TRUE;

//Ngôn ngữ mặc định
$config['language'] = "vn";

$config['catcool_hash'] = "pass!@#$%";

//ten admin group can check
$config['admin_group'] = "admin";

$config['user_expire'] = 0; //thoi gian expire cua user khi login
$config['remember_cookie_name'] = 'remember_cookie_catcool'; //ten cookie khi login

$config['is_check_csrf_admin'] = TRUE; //true: bat check csrf trong admin
$config['csrf_name_key'] = 't_cc_key'; //ten input cua csrf key
$config['csrf_name_value'] = 't_cc_value'; //ten input cua csrf value
$config['csrf_cookie_expire'] = 3600; //thoi gian expire cua csrf 1 gio

$config['enable_develbar'] = FALSE; //dat add develbar
