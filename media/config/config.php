<?php 

//Ngôn ngữ mặc định
$config['language'] = "vn";

//Danh sách ngôn ngữ lấy từ db langluages
$config['list_language_cache'] = '{"1":{"id":"1","name":"Vietnames","code":"vn","icon":null,"user_id":"1","published":"1"},"2":{"id":"2","name":"English","code":"english","icon":"flag-icon flag-icon-gb","user_id":"1","published":"1"}}';

//Hiển thị Selectbox ngôn ngữ?
$config['is_show_select_language'] = true;

//Set theme frontend default/kenhtraitim
$config['theme_frontend'] = "kenhtraitim";

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
$config['enable_resize_image'] = true;

//Hình logo
$config['image_logo_url'] = "";

//Hình mặc định nêu hình gốc không tồn tại
$config['image_none'] = "root/logo-hoatuoi24h-21.png";

//Chiều rộng hình tối đa trên pc
$config['image_width_pc'] = 1280;

//Chiều cao tối đa của hình trên pc
$config['image_height_pc'] = 1024;

//Chiều rộng tối đa của hình trên mobile (pixel)
$config['image_width_mobile'] = 800;

//Chiều cao tối đa của hình trên mobile
$config['image_height_mobile'] = 800;

//Hiển thị thanh menu, false sẽ ẩn menu gọn lại
$config['enable_scroll_menu_admin'] = true;

//true sử dụng menu bằng icon, false sẽ sử dụng menu kiểu text
$config['enable_icon_menu_admin'] = true;

//Avatar mặc định cho nam
$config['avatar_default_male'] = "images/male.png";

//Avatar mặc định cho nữ
$config['avatar_default_female'] = "images/female.png";

//Setting email host
$config['email_host'] = "ssl://smtp.googlemail.com";

//Port email
$config['email_port'] = 465;

//Tài khoảng email smtp
$config['email_smtp_user'] = "lmd.dat@gmail.com";

//email smtp pass
$config['email_smtp_pass'] = "tovyyqgibmnruaes";

//Email from
$config['email_from'] = "lmd.dat@gmail.com";

//Email Subject title
$config['email_subject_title'] = "CatCool FW";

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
$config['image_icon_url'] = "root/cropped-logo_cv6080-32x32.png";

//Chế độ tối
$config['enable_dark_mode'] = true;

//So luong trang
$config['pagination_limit'] = 20;

//so luong trang trong admin
$config['pagination_limit_admin'] = 20;

//Kich thuoc file toi da
$config['file_max_size'] = 300000;

$config['file_ext_allowed'] = "zip|txt|png|PNG|jpe|JPE|jpeg|JPEG|jpg|JPG|gif|GIF|bmp|BMP|ico|tiff|tif|svg|svgz|zip|rar|msi|cab|mp3|qt|mov|pdf|psd|ai|eps|ps|doc|mp4";

$config['file_mime_allowed'] = 'text/plain|image/png|image/jpeg|image/gif|image/bmp|image/tiff|image/svg+xml|application/zip|"application/zip"|application/x-zip|"application/x-zip"|application/x-zip-compressed|"application/x-zip-compressed"|application/rar|"application/rar"|application/x-rar|"application/x-rar"|application/x-rar-compressed|"application/x-rar-compressed"|application/octet-stream|"application/octet-stream"|audio/mpeg|video/quicktime|application/pdf';

$config['file_max_width'] = 0;

$config['file_max_height'] = 0;

$config['file_encrypt_name'] = false;

//RESIZE_IMAGE_DEFAULT_WIDTH
$config['image_thumbnail_large_width'] = 2048;

//RESIZE_IMAGE_DEFAULT_HEIGHT
$config['image_thumbnail_large_height'] = 2048;

//RESIZE_IMAGE_THUMB_WIDTH
$config['image_thumbnail_small_width'] = 800;

//RESIZE_IMAGE_THUMB_HEIGHT
$config['image_thumbnail_small_height'] = 800;

$config['image_quality'] = 60;

$config['image_watermark'] = "top_right";

$config['image_watermark_text'] = "Cat Cool Lê";

$config['image_watermark_path'] = "";

$config['image_watermark_hor_offset'] = -20;

$config['image_watermark_vrt_offset'] = 20;

$config['image_watermark_font_path'] = "./system/fonts/Lemonada.ttf";

$config['image_watermark_font_size'] = 46;

$config['image_watermark_font_color'] = "#15b07f";

$config['image_watermark_shadow_color'] = "";

$config['image_watermark_shadow_distance'] = "";

$config['image_watermark_opacity'] = 50;

$config['language_admin'] = "english";

$config['length_class'] = 1;

$config['weight_class'] = 1;

$config['timezone'] = "Asia/Ho_Chi_Minh";

$config['country'] = 237;

$config['country_province'] = 79;

$config['currency'] = "VND";

//https://fixer.io/quickstart
$config['fixer_io_access_key'] = "3fabec301ee1683b95fd8240bb5aba97";

$config['email_engine'] = "smtp";

$config['email_parameter'] = "";

$config['email_smtp_timeout'] = 6;

$config['encryption_key'] = "";

$config['maintenance'] = "";

$config['seo_url'] = "";

$config['robots'] = "";

$config['compression'] = "";

