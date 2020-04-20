<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang = [
    //table header
    'column_id'                     => 'ID',
    'column_name'                   => 'Tên',
    'column_slug'                   => 'SEO Url',
    'column_description'            => 'Mô tả',
    'column_context'                => 'Context',
    'column_sort_order'             => 'Thứ tự hiển thị',
    'column_parent'                 => 'Danh mục',
    'column_published'              => 'Trạng thái',
    'column_function'               => 'Chức năng',

    // Text
    'text_yes'                      => 'Có',
    'text_no'                       => 'Không',
    'text_enabled'                  => 'Bật',
    'text_disabled'                 => 'Tắt',
    'text_none'                     => ' --- Không --- ',
    'text_select'                   => ' --- Hãy chọn --- ',
    'text_all'                      => 'All',
    'text_select_all'               => 'Chọn tất cả',
    'text_unselect_all'             => 'bỏ chọn tất cả',
    'text_all_zones'                => 'Toàn bộ các lãnh thổ',
    'text_default'                  => ' <b>(Mặc định)</b>',
    'text_close'                    => 'Đóng',
    'text_cancel'                   => 'Huỷ',
    'text_pagination'               => 'Showing %d-%d of %d',
    'text_loading'                  => 'Đang nạp...',
    'text_no_results'               => 'Không có kết quả!',
    'text_confirm'                  => 'Bạn có chắc chắn?',
    'text_confirm_write'            => 'Bạn có chắc chắn muốn ghi file kông?',
    'text_confirm_delete'           => 'Bạn có chắc chắn muốn xoá kông?',
    'text_confirm_title'            => 'Vui lòng xác nhận!',
    'text_home'                     => 'Trang chủ',
    'text_plus'                     => '+',
    'text_minus'                    => '-',
    'text_photo_edit'               => 'Chọn hình',
    'text_photo_clear'              => 'Xóa hình',

    'text_name'                     => 'Tên',
    'text_slug'                     => 'SEO Url',
    'text_description'              => 'Mô tả',
    'text_context'                  => 'Context',
    'text_language'                 => 'Ngôn ngữ',
    'text_sort_order'               => 'Thứ tự hiển thị',
    'text_parent'                   => 'Danh mục cha',
    'text_published'                => 'Trạng thái',
    'text_limit'                    => 'Limit',
    'text_gender'                   => 'Giới tính',
    'text_gender_male'              => 'Nam',
    'text_gender_female'            => 'Nữ',
    'text_gender_other'             => 'Khác',
    'text_super_admin'              => 'Super Admin',
    'text_image'                    => 'Hình ảnh',
    'text_address'                  => 'Địa chỉ',
    'text_dob'                      => 'Ngày sinh',
    'text_password'                 => 'Mật khẩu',
    'text_confirm_password'         => 'Nhập lại mật khẩu',
    'text_full_name'                => 'Họ và Tên',
    'text_first_name'               => 'Tên',
    'text_last_name'                => 'Họ và tên lót',
    'text_username'                 => 'Username',
    'text_profile'                  => 'Trang cá nhân',
    'text_identity'                 => 'Identity',
    'text_active'                   => 'Active',
    'text_group'                    => 'Nhóm',
    'text_permission'               => 'Permission',
    'text_module'                   => 'Module',
    'text_sub_module'               => 'Sub Module',
    'text_seo_title'                => 'Meta Title',
    'text_seo_description'          => 'Meta Description',
    'text_seo_keyword'              => 'Meta Keyword',
    'text_category'                 => 'Danh mục',
    'text_tags'                     => 'Tabs',
    'text_manage_more'              => 'Mở rộng',
    'text_permission'               => 'You do not have permission to access this page, please refer to your system administrator.',

    //successfully
    'text_published_success'        => 'Đã cập nhật trạng thái thành công',
    'text_delete_success'           => 'Đã xoá dữ liệu thành công',
    'text_add_success'              => 'Đã thêm mới dữ liệu thành công',
    'text_edit_success'             => 'Đã cập nhật thành công',
    'text_delete_file_success'      => 'Đã xoá file thành công',
    'text_write_success'            => 'Đã ghi file thành công!',

    //filter
    'filter_header'                 => 'Bộ lọc',
    'filter_dropdown_all'           => 'Tất cả',
    'filter_name'                   => 'Tên',
    'filter_id'                     => 'ID',
    'filter_submit'                 => 'Tìm kiếm',

    // Button
    'button_add'                    => 'Thêm mới',
    'button_delete'                 => 'Xóa',
    'button_delete_all'             => 'Xoá tất cả',
    'button_save'                   => 'Lưu lại',
    'button_write'                  => 'Ghi file',
    'button_photo_add'              => 'Thêm hình',
    'button_cancel'                 => 'Hủy',
    'button_cancel_recurring'       => 'Hủy chi trả định kỳ',
    'button_continue'               => 'Tiếp tục',
    'button_clear'                  => 'Xóa',
    'button_close'                  => 'Đóng',
    'button_enable'                 => 'Kích hoạt',
    'button_disable'                => 'Tắt Kích hoạt',
    'button_filter'                 => 'Lọc dữ liệu',
    'button_send'                   => 'Gửi',
    'button_edit'                   => 'Chỉnh sửa',
    'button_copy'                   => 'Sao chép',
    'button_back'                   => 'Trở lại',
    'button_remove'                 => 'Loại bỏ',
    'button_refresh'                => 'Làm mới',
    'button_export'                 => 'Xuất',
    'button_import'                 => 'Nhập',
    'button_download'               => 'Tải về',
    'button_rebuild'                => 'Xây dựng lại',
    'button_upload'                 => 'Tải lên',
    'button_submit'                 => 'Submit',
    'button_invoice_print'          => 'In hóa đơn',
    'button_shipping_print'         => 'In danh sách đặt hàng',
    'button_address_add'            => 'Thêm địa chỉ',
    'button_attribute_add'          => 'Thêm thuộc tính',
    'button_banner_add'             => 'Thêm Banner',
    'button_custom_field_value_add' => 'Thêm trường tùy chỉnh',
    'button_product_add'            => 'Thêm sản phẩm',
    'button_filter_add'             => 'Thêm bộ lọc tìm kiếm',
    'button_option_add'             => 'Thêm Tùy chọn',
    'button_option_value_add'       => 'Thêm thuộc tính tùy chọn',
    'button_recurring_add'          => 'Thêm định kỳ',
    'button_discount_add'           => 'Thêm thẻ giảm giá',
    'button_special_add'            => 'Thêm Giá khuyến mãi',
    'button_image_add'              => 'Thêm hình ảnh',
    'button_geo_zone_add'           => 'Thêm Khu vực',
    'button_history_add'            => 'Thêm lịch sử đơn đặt hàng',
    'button_translation'            => 'Nạp bản dịch mặc định',
    'button_translation_add'        => 'Thêm bản dịch',
    'button_transaction_add'        => 'Thêm giao dịch',
    'button_route_add'              => 'Thêm lộ trình',
    'button_rule_add'               => 'Thêm Quy định',
    'button_module_add'             => 'Thêm mô đun',
    'button_link_add'               => 'Thêm địa chỉ liên kết',
    'button_approve'                => 'Chấp nhận',
    'button_deny'                   => 'Từ chối',
    'button_reset'                  => 'Thiết lập lại',
    'button_generate'               => 'Tạo ra',
    'button_voucher_add'            => 'Thêm Voucher',
    'button_reward_add'             => 'Thêm điểm thưởng',
    'button_reward_remove'          => 'Xóa điểm thưởng',
    'button_commission_add'         => 'Thêm hoa hồng',
    'button_commission_remove'      => 'Gỡ bỏ hoa hồng',
    'button_credit_add'             => 'Thêm thẻ tín dụng',
    'button_credit_remove'          => 'Xóa thẻ tín dụng',
    'button_ip_add'                 => 'Thêm địa chỉ IP',
    'button_parent'                 => 'Parent',
    'button_folder'                 => 'Thư mục mới',
    'button_search'                 => 'Tìm kiếm',
    'button_view'                   => 'Hiển thị',
    'button_install'                => 'Cài đặt',
    'button_uninstall'              => 'Gỡ cài đặt',
    'button_link'                   => 'Liên kết',
    'button_currency'               => 'Làm mới giá trị tiền tệ',
    'button_apply'                  => 'Áp dụng',
    'button_category_add'           => 'Thêm danh mục',
    'button_order'                  => 'Hiển thị đơn hàng',
    'button_order_recurring'        => 'Hiển thị định kỳ đơn hàng',
    'button_buy'                    => 'Mua',
    'button_Restore'                => 'Restore',
    'button_run'                    => 'Run Cron Job',
    'button_backup'                 => 'Backup',
    'button_developer'              => 'Developer Setting',
    'button_master'                 => 'Master Product',

    // Tab
    'tab_affiliate'                 => 'Affiliate',
    'tab_address'                   => 'Địa chỉ',
    'tab_additional'                => 'Thêm vào',
    'tab_admin'                     => 'Quản Trị',
    'tab_attribute'                 => 'Thuộc tính',
    'tab_customer'                  => 'Chi tiết khách hàng',
    'tab_comment'                   => 'Nhận xét',
    'tab_data'                      => 'Dữ liệu',
    'tab_description'               => 'Mô tả',
    'tab_design'                    => 'Thiết kế',
    'tab_discount'                  => 'Giảm giá',
    'tab_documentation'             => 'Tài liệu',
    'tab_general'                   => 'Chung',
    'tab_history'                   => 'Lịch sử',
    'tab_ftp'                       => 'FTP',
    'tab_ip'                        => 'Địa chỉ IP',
    'tab_links'                     => 'Liên kết',
    'tab_log'                       => 'Bản ghi lịch sử',
    'tab_image'                     => 'Hình ảnh',
    'tab_option'                    => 'Tùy chọn',
    'tab_server'                    => 'Máy chủ',
    'tab_seo'                       => 'SEO',
    'tab_store'                     => 'Của hàng',
    'tab_special'                   => 'Khuyến mãi',
    'tab_session'                   => 'Phiên bản',
    'tab_local'                     => 'Khu vực',
    'tab_mail'                      => 'Địa chỉ Mail',
    'tab_module'                    => 'Mô đun',
    'tab_payment'                   => 'Chi tiết thanh toán',
    'tab_product'                   => 'Sản phẩm',
    'tab_reward'                    => 'Điểm thưởng',
    'tab_shipping'                  => 'Địa chỉ giao hàng',
    'tab_total'                     => 'Tổng số',
    'tab_transaction'               => 'Giao dịch',
    'tab_voucher'                   => 'quản lý Vouchers',
    'tab_sale'                      => 'Quản lý bán hàng',
    'tab_marketing'                 => 'Marketing',
    'tab_online'                    => 'Người Online',
    'tab_activity'                  => 'Hoạt động gần đây',
    'tab_recurring'                 => 'Định kỳ',
    'tab_report'                    => 'Báo cáo',
    'tab_action'                    => 'Hoạt động',
    'tab_google'                    => 'Google',

    // Error
    'error_exception'               => 'Error Code(%s): %s in %s on line %s',
    'error_upload_1'                => 'Cảnh báo: Tệp tin được tải lên vượt quá qui định trong tệp  php.ini!',
    'error_upload_2'                => 'Cảnh báo: Tệp tin được tải lên vượt quá qui định đã được xác định trong mã HTML!',
    'error_upload_3'                => 'Cảnh báo: Tệp tin chỉ có một phần đã được tải lên!',
    'error_upload_4'                => 'Cảnh báo: Không tải được!',
    'error_upload_6'                => 'Cảnh báo: Không có thư mục!',
    'error_upload_7'                => 'Cảnh báo: Không thể ghi tập tin vào đĩa!',
    'error_upload_8'                => 'Cảnh báo: Tệp tin bị ngừng do các thành phần khác!',
    'error_upload_999'              => 'Cảnh báo: Lỗi mã nguồn!',
    'error_curl'                    => 'CURL: Lỗi Code(%s): %s',
    'error_token'                   => 'Có lỗi xảy ra trong quá trình thực thi. Vui lòng thử lại!',
    'error_json'                    => 'Có lỗi xảy ra trong quá trình thực thi',
    'error_empty'                   => 'Dữ liệu không tồn tại',
    'error'                         => 'Lỗi hệ thống',
    'error_permission_execute'      => 'Bạn không có quyền thực thi thao tác này. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_read'         => 'Bạn không có quyền thao tác xem dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_add'          => 'Bạn không có quyền thao tác thêm mới dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_edit'         => 'Bạn không có quyền thao tác cập nhật dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_super_admin'  => 'Bạn không có quyền cập nhật hoặc xoá những User có quyền cao hơn. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_delete'       => 'Bạn không có quyền thao tác xoá dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'file_not_found'                => 'File không tồn tại',
    'error_exist'                   => 'Dữ liệu đã tồn tại!!!',

    //modules
    'module_article' => 'Bài viết',
    'module_category' => 'Danh mục',
    'module_photo' => 'Hình ảnh',
    'module_user' => 'Tài khoản',
    'module_group' => 'Nhóm',

    //validation
    'text_manage_validation'        => 'Vui lòng nhập thông tin cho %s',
    'text_manage_validation_number' => 'Vui lòng nhập kiểu số nguyên cho %s',
    'text_manage_placeholder'       => 'Vui lòng nhập %s',


    //edit
    'msg_not_active' => 'Trạng thái bài viết hiện chưa được Active',


    //general
    'catcool_dashboard' => 'Home',
    'dashboard_heading' => 'Home',
    'image_upload' => 'Kéo và thả file vào đây<br />Hoặc<br />Click vào để chọn file',
    'logout' => 'Logout',


    'add_album_empty_photo' => 'Vui lòng chọn hình trước khi tạo album',
    'select_photos' => 'Vui lòng chọn hình',

    'login_heading'         => 'Đăng nhập',
    'text_login_remember'  => 'Nhớ mật khẩu',
    'text_captcha'  => 'Mã bảo vệ', //Security Code
    'button_login'      => 'Đăng nhập',
    'text_forgot_password' => 'Quên mật khẩu?',
    'login_successful' 		        => 'Đăng nhập thành công',
    'login_unsuccessful'  	        => 'Tài khoản hoặc mật khẩu không đúng',
    'error_captcha'  	        => 'Mã bảo vệ không đúng',
    'login_unsuccessful_not_active' => 'Tài khoản này đã bị khoá',
    'login_timeout'                 => 'Tài khoản này đã tạm thời bị khoá, vui lòng thử lại sau',
    'logout_successful' 		    => 'Đăng xuất thành công',
];