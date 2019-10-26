<?php 

//Ngôn ngữ mặc định
$config['language'] = "vn";

//Danh sách ngôn ngữ lấy từ db langluages
$config['list_language_cache'] = '{"1":{"id":"1","name":"Vietnames","code":"vn","user_id":"1","published":"yes"},"2":{"id":"2","name":"English","code":"english","user_id":"1","published":"yes"}}';

//Hiển thị Selectbox ngôn ngữ?
$config['is_show_select_language'] = true;

//Set theme frontend
$config['theme_frontend'] = "default";

//Set theme cho admin
$config['theme_admin'] = "admin";

//SEO site name mặc định
$config['site_name'] = "Cat Cool CMS";

//SEO keywords mặc định
$config['site_keywords'] = "thiet ke web, website, chuyen nghiep";

//SEO description
$config['site_description'] = "thiết kế website chuyên nghiệp";

//key hash
$config['catcool_hash'] = "pass!@#$%";

//tên nhóm admin, để check nhứng user nào có quyền admin
$config['admin_group'] = "admin";

//Thời gian expire cookie của user khi login
$config['user_expire'] = 0;

//Tên cookie login cho user
$config['remember_cookie_name'] = "remember_cookie_catcool";

//Có cần check csrf trong admin hay không?
$config['is_check_csrf_admin'] = TRUE;

//Set tên input khi sử dụng giá trị cho csrf key
$config['csrf_name_key'] = "t_cc_key";

//Set tên input khi sử dụng csrf value
$config['csrf_name_value'] = "t_cc_value";

//Thời gian expire của csrf
$config['csrf_cookie_expire'] = 3600;

//Hiển thị develbar tool hay không? 1
$config['enable_develbar'] = FALSE;

