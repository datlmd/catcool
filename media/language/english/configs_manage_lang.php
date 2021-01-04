<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang["column_config_key"] = "Key";
$lang["column_config_value"] = "Value";
$lang["created_setting_success"] = "Success: You have modified the config file!";
$lang["error_config_key_exists"] = "KEY must be unique!";
$lang["heading_title"] = "Configs";
$lang["help_account_terms"] = "Forces people to agree to terms before an account can be created.";
$lang["help_affiliate_approval"] = "Automatically approve any new affiliates who sign up.";
$lang["help_affiliate_auto"] = "Automatically add commission when each order reaches the complete status.";
$lang["help_affiliate_commission"] = "The default affiliate commission percentage.";
$lang["help_affiliate_terms"] = "Forces people to agree to terms before an affiliate account can be created.";
$lang["help_cart_weight"] = "Show the cart weight on the cart page.";
$lang["help_checkout_guest"] = "Allow customers to checkout without creating an account. This will not be available when a downloadable product is in the shopping cart.";
$lang["help_checkout_terms"] = "Forces people to agree to terms before a customer can checkout.";
$lang["help_compression"] = "GZIP for more efficient transfer to requesting clients. Compression level must be between 0 - 9.";
$lang["help_currency"] = "Change the default currency. Clear your browser cache to see the change and reset your existing cookie.";
$lang["help_currency_auto"] = "Set your store to automatically update currencies daily.";
$lang["help_customer_activity"] = "Track customers activity via the customer reports section.";
$lang["help_customer_group_display"] = "Display customer groups that new customers can select to use such as wholesale and business when signing up.";
$lang["help_customer_group_id"] = "Default customer group.";
$lang["help_customer_online"] = "Track customers online via the customer reports section.";
$lang["help_customer_price"] = "Only show prices when a customer is logged in.";
$lang["help_email_alert"] = "Select which features you would like to receive an alert email on when a customer uses them.";
$lang["help_email_alert_email"] = "Any additional emails you want to receive the alert email, in addition to the main store email. (comma separated).";
$lang["help_email_engine"] = "Only choose 'Mail' unless your host has disabled the php mail function.";
$lang["help_email_host"] = "Add 'tls://' or 'ssl://' prefix if security connection is required. (e.g. tls://smtp.gmail.com, ssl://smtp.gmail.com).";
$lang["help_email_parameter"] = "When using 'Mail', additional mail parameters can be added here (e.g. -f email@storeaddress.com).";
$lang["help_email_smtp_pass"] = "For gmail you might need to setup a application specific password here: https://security.google.com/settings/security/apppasswords.";
$lang["help_enable_ssl"] = "To use SSL check with your host if a SSL certificate is installed and add the SSL URL to the catalog and admin config files.";
$lang["help_file_encrypt_name"] = "If set to TRUE the file name will be converted to a random encrypted string. This can be useful if you would like the file saved with a name that can not be discerned by the person uploading it";
$lang["help_file_max_height"] = "The maximum height (in pixels) that the image can be. Set to zero for no limit";
$lang["help_file_max_size"] = "The maximum size (in kilobytes) that the file can be. Set to 0 for no limit";
$lang["help_file_max_width"] = "The maximum width (in pixels) that the image can be. Set to zero for no limit";
$lang["help_fraud_status_id"] = "Set the order status when a customer is suspected of trying to alter the order payment details or use a coupon, gift voucher or reward points that have already been used.";
$lang["help_invoice_prefix"] = "Set the invoice prefix (e.g. INV-2020-00). Invoice IDs will start at 1 for each unique prefix.";
$lang["help_is_captcha"] = "Captcha to use for registration, login, contact and reviews.";
$lang["help_login_attempts"] = "Maximum login attempts allowed before the account is locked for 1 hour. Customer and affliate accounts can be unlocked on the customer or affliate admin pages.";
$lang["help_maintenance"] = "Prevents customers from browsing your store. They will instead see a maintenance message. If logged in as admin, you will see the store as normal.";
$lang["help_order_api_id"] = "Default API user the admin should use.";
$lang["help_order_status_id"] = "Set the default order status when an order is processed.";
$lang["help_pcomplete_status"] = "Set the order status the customer's order must reach before they are allowed to access their downloadable products and gift vouchers.";
$lang["help_processing_status"] = "Set the order status the customer's order must reach before the order starts stock subtraction and coupon, voucher and rewards redemption.";
$lang["help_product_count"] = "Show the number of products inside the subcategories in the storefront header category menu. Be warned, this will cause an extreme performance hit for stores with a lot of subcategories!";
$lang["help_product_limit_admin"] = "Determines how many admin items are shown per page (orders, customers, etc).";
$lang["help_product_voucher_max"] = "Maximum amount a customer can purchase a voucher for.";
$lang["help_product_voucher_min"] = "Minimum amount a customer can purchase a voucher for.";
$lang["help_return_status_id"] = "Set the default return status when a return request is submitted.";
$lang["help_return_terms"] = "Forces people to agree to terms before a return can be created.";
$lang["help_review_guest"] = "Cho phép Khách hàng chưa có Tài khoản trên Shop có thể gửi Bình luận.";
$lang["help_review_status"] = "Enable/Disable new review entry and display of existing reviews.";
$lang["help_robots"] = "A list of web crawler user agents that shared sessions will not be used with. Use separate lines for each user agent.";
$lang["help_seo_url"] = "To use SEO URLs, apache module mod-rewrite must be installed.";
$lang["help_stock_checkout"] = "Allow customers to still checkout if the products they are ordering are not in stock.";
$lang["help_stock_display"] = "Display stock quantity on the product page.";
$lang["help_stock_warning"] = "Display out of stock message on the shopping cart page if a product is out of stock but stock checkout is yes. (Warning always shows if stock checkout is no)";
$lang["help_tax_customer"] = "Use the customer's default address when they login to calculate taxes. You can choose to use the default address for the customer's shipping or payment address.";
$lang["help_tax_default"] = "Use the store address to calculate taxes if customer is not logged in. You can choose to use the store address for the customer's shipping or payment address.";
$lang["text_account_terms"] = "Account Terms";
$lang["text_add"] = "Add Config";
$lang["text_affiliate"] = "Affiliates";
$lang["text_affiliate_approval"] = "Affiliate Requires Approval";
$lang["text_affiliate_auto"] = "Automatic Commission";
$lang["text_affiliate_commission"] = "Affiliate Commission (%)";
$lang["text_affiliate_group_id"] = "Affiliate Group";
$lang["text_affiliate_terms"] = "Affiliate Terms";
$lang["text_bottom_center"] = "Bottom - Center";
$lang["text_bottom_left"] = "Bottom - Left";
$lang["text_bottom_right"] = "Bottom - Right";
$lang["text_captcha_page"] = "Captcha Page";
$lang["text_cart_weight"] = "Display Weight on Cart Page";
$lang["text_center_center"] = "Middle - Center";
$lang["text_checkout"] = "Checkout";
$lang["text_checkout_guest"] = "Guest Checkout";
$lang["text_checkout_terms"] = "Checkout Terms";
$lang["text_complete_status"] = "Complete Order Status";
$lang["text_compression"] = "Output Compression Level";
$lang["text_config_key"] = "Key";
$lang["text_config_value"] = "Value";
$lang["text_country"] = "Country";
$lang["text_currency"] = "Currency";
$lang["text_currency_auto"] = "Auto Update Currency";
$lang["text_currency_engine"] = "Currency Rate Engine";
$lang["text_customer"] = "Account";
$lang["text_customer_activity"] = "Customers Activity";
$lang["text_customer_group_display"] = "Customer Groups";
$lang["text_customer_group_id"] = "Customer Group";
$lang["text_customer_online"] = "Customers Online";
$lang["text_customer_price"] = "Login Display Prices";
$lang["text_customer_search"] = "Log Customer Searches";
$lang["text_edit"] = "Edit Config";
$lang["text_email"] = "Email";
$lang["text_email_alert"] = "Alert Mail";
$lang["text_email_alerts"] = "Mail Alerts";
$lang["text_email_alert_email"] = "Additional Alert Mail";
$lang["text_email_engine"] = "Mail Engine";
$lang["text_email_from"] = "Email From";
$lang["text_email_host"] = "SMTP Hostname";
$lang["text_email_parameter"] = "Mail Parameter";
$lang["text_email_port"] = "SMTP Port";
$lang["text_email_smtp_pass"] = "SMTP Password";
$lang["text_email_smtp_timeout"] = "SMTP Timeout";
$lang["text_email_smtp_user"] = "SMTP Username";
$lang["text_email_subject_title"] = "Subject Title";
$lang["text_enable_dark_mode"] = "Enable dark mode (Admin)";
$lang["text_enable_icon_menu_admin"] = "Enable the icon menu (Admin)";
$lang["text_enable_resize_image"] = "Enable Resize Image";
$lang["text_enable_ssl"] = "Use SSL";
$lang["text_file_encrypt_name"] = "Encrypt name";
$lang["text_file_ext_allowed"] = "Allowed File Extensions";
$lang["text_file_max_height"] = "Max Height";
$lang["text_file_max_size"] = "Max File Size";
$lang["text_file_max_width"] = "Max Width";
$lang["text_file_mime_allowed"] = "Allowed File Mime Types";
$lang["text_fraud_status_id"] = "Fraud Order Status";
$lang["text_general"] = "General";
$lang["text_hide_menu"] = "Display the menu (Admin)";
$lang["text_icon"] = "Icon";
$lang["text_image_none"] = "Default";
$lang["text_image_quality"] = "Quality image";
$lang["text_image_thumbnail_large"] = "Resize - Large";
$lang["text_image_thumbnail_large_height"] = "Height";
$lang["text_image_thumbnail_large_width"] = "Width";
$lang["text_image_thumbnail_small"] = "Resize - Small";
$lang["text_image_watermark"] = "Watermark";
$lang["text_image_watermark_font_color"] = "Color";
$lang["text_image_watermark_font_path"] = "Font";
$lang["text_image_watermark_font_size"] = "Size";
$lang["text_image_watermark_hor_offset"] = "Offset X";
$lang["text_image_watermark_opacity"] = "Opacity";
$lang["text_image_watermark_path"] = "Use the image";
$lang["text_image_watermark_shadow_color"] = "Shadow Color";
$lang["text_image_watermark_shadow_distance"] = "Shadow Distance";
$lang["text_image_watermark_text"] = "Use the text";
$lang["text_image_watermark_vrt_offset"] = "Offset Y";
$lang["text_invoice_prefix"] = "Invoice Prefix";
$lang["text_is_captcha"] = "Captcha";
$lang["text_language_admin"] = "Administration Language";
$lang["text_length_class"] = "Length Class";
$lang["text_list"] = "Config List";
$lang["text_login_attempts"] = "Max Login Attempts";
$lang["text_logo"] = "Logo";
$lang["text_maintenance"] = "Maintenance";
$lang["text_middle_left"] = "Middle - Left";
$lang["text_middle_right"] = "Middle - Right";
$lang["text_order_api_id"] = "API User";
$lang["text_order_status_id"] = "Order Status";
$lang["text_pagination_limit"] = "Default Items Per Page";
$lang["text_pagination_limit_admin"] = "Default Items Per Page (Admin)";
$lang["text_processing_status"] = "Processing Order Status";
$lang["text_product"] = "Products";
$lang["text_product_count"] = "Category Product Count";
$lang["text_product_limit_admin"] = "Default Items Per Page (Admin)";
$lang["text_product_voucher_max"] = "Voucher Max";
$lang["text_product_voucher_min"] = "Voucher Min";
$lang["text_return"] = "Returns";
$lang["text_return_status_id"] = "Return Status";
$lang["text_return_terms"] = "Return Terms";
$lang["text_review"] = "Reviews";
$lang["text_review_guest"] = "Allow Guest Reviews";
$lang["text_review_status"] = "Allow Reviews";
$lang["text_robots"] = "Robots";
$lang["text_security"] = "Security";
$lang["text_seo_url"] = "Use SEO URLs";
$lang["text_site_description"] = "Meta Tag Description";
$lang["text_site_keywords"] = "Meta Tag Keywords";
$lang["text_site_name"] = "Meta Title";
$lang["text_stock"] = "Stock";
$lang["text_stock_checkout"] = "Stock Checkout";
$lang["text_stock_display"] = "Display Stock";
$lang["text_stock_warning"] = "Show Out Of Stock Warning";
$lang["text_tax"] = "Display Prices With Tax";
$lang["text_tax_customer"] = "Use Customer Tax Address";
$lang["text_tax_default"] = "Use Store Tax Address";
$lang["text_timezone"] = "Time Zone";
$lang["text_title_tax"] = "Taxes";
$lang["text_top_center"] = "Top - Center";
$lang["text_top_left"] = "Top - Left";
$lang["text_top_right"] = "Top - Right";
$lang["text_voucher"] = "Vouchers";
$lang["text_weight_class"] = "Weight class";
$lang["text_zone"] = "Region / State";
