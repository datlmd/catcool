<?php 

//Ngôn ngữ mặc định
$config['language'] = "vn";

//Danh sách ngôn ngữ lấy từ db langluages
$config['list_language_cache'] = '{"1":{"id":"1","name":"Vietnames","code":"vn","icon":null,"user_id":"1","published":"1"},"2":{"id":"2","name":"English","code":"english","icon":"flag-icon flag-icon-gb","user_id":"1","published":"1"}}';

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

$config['site_url'] = "http://192.168.64.2/dev/catcool";

//Bật chế độ resize hình
$config['enable_resize_image'] = TRUE;

//Hình logo
$config['image_logo_url'] = "root/118383452_342708590191134_1797971570784240891_o.jpg";

//Hình mặc định nêu hình gốc không tồn tại
$config['image_none'] = "images/img_default.png";

//Chiều rộng hình tối đa trên pc
$config['image_width_pc'] = 700;

//Chiều cao tối đa của hình trên pc
$config['image_height_pc'] = 900;

//Chiều rộng tối đa của hình trên mobile (pixel)
$config['image_width_mobile'] = 400;

//Chiều cao tối đa của hình trên mobile
$config['image_height_mobile'] = 600;

//Hiển thị thanh menu, false sẽ ẩn menu gọn lại
$config['enable_scroll_menu_admin'] = true;

//true sử dụng menu bằng icon, false sẽ sử dụng menu kiểu text
$config['enable_icon_menu_admin'] = "";

//Avatar mặc định cho nam
$config['avatar_default_male'] = "images/male.png";

//Avatar mặc định cho nữ
$config['avatar_default_female'] = "images/female.png";

//Tài khoảng email smtp
$config['email_smtp_user'] = "lmd.dat@gmail.com";

//Email from
$config['email_from'] = "lmd.dat@gmail.com";

//Bật SSL
$config['enable_ssl'] = TRUE;

//Khai báo html cho breadcrumb open
$config['breadcrumb_open'] = "<ul class='breadcrumb breadcrumb-light d-block text-center appear-animation' data-appear-animation='fadeIn' data-appear-animation-delay='300'>";

//Khai báo html cho breadcrumb close
$config['breadcrumb_close'] = "</ul>";

//Khai báo html cho breadcrumb_item_open
$config['breadcrumb_item_open'] = "<li class='active'>";

//Khai báo html đóng cho breadcrumb_item_close
$config['breadcrumb_item_close'] = "</li>";

//Khai báo định dạng ngày tháng
$config['date_format'] = "d/m/Y H:i:s";

//Icon website
$config['image_icon_url'] = "image_icon_url";

