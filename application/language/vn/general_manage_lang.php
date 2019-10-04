<?php defined('BASEPATH') OR exit('No direct script access allowed');

//Errors
$lang['error_token'] = 'Có lỗi xảy ra trong quá trình thực thi. Vui lòng thử lại!';
$lang['error_json']  = 'Có lỗi xảy ra trong quá trình thực thi';
$lang['error_empty'] = 'Dữ liệu không tồn tại';
$lang['error']       = 'Lỗi hệ thống';
$lang['error_permission_execute'] = 'Bạn không có quyền thực thi thao tác này. <br />Xin kiểm tra lại quyền với admin.';
$lang['error_permission_read'] = 'Bạn không có quyền thao tác xem dữ liệu. <br />Xin kiểm tra lại quyền với admin.';
$lang['error_permission_add'] = 'Bạn không có quyền thao tác thêm mới dữ liệu. <br />Xin kiểm tra lại quyền với admin.';
$lang['error_permission_edit'] = 'Bạn không có quyền thao tác cập nhật dữ liệu. <br />Xin kiểm tra lại quyền với admin.';
$lang['error_permission_super_admin'] = 'Bạn không có quyền cập nhật hoặc xoá những User có quyền cao hơn. <br />Xin kiểm tra lại quyền với admin.';
$lang['error_permission_delete'] = 'Bạn không có quyền thao tác xoá dữ liệu. <br />Xin kiểm tra lại quyền với admin.';
$lang['file_not_found'] = 'File không tồn tại';

//successfully
$lang['modify_publish_success']     = 'Đã cập nhật trạng thái thành công';
$lang['reload_list_parent_success'] = 'Danh mục cha đã được làm mới';
$lang['delete_success']             = 'Đã xoá dữ liệu thành công';
$lang['add_success']                = 'Đã thêm mới dữ liệu thành công';
$lang['edit_success']               = 'Đã cập nhật thành công';
$lang['created_table_success']      = 'Đã tạo table thành công';
$lang['delete_file_success']        = 'Đã xoá file thành công';
$lang['write_success']        = 'Đã ghi file thành công!';


//filter
$lang['filter_header']       = 'Bộ lọc';
$lang['filter_dropdown_all'] = 'Tất cả';
$lang['filter_name']         = 'Tìm kiếm...';
$lang['filter_submit']       = 'Tìm kiếm';

//table header
$lang['f_id']          = 'ID';
$lang['f_title']       = 'Tiêu đề';
$lang['f_slug']        = 'Slug';
$lang['f_description'] = 'Mô tả ';
$lang['f_context']     = 'Context';
$lang['f_language']    = 'Ngôn ngữ';
$lang['f_precedence']  = 'Sort';
$lang['f_parent']      = 'Danh mục ';
$lang['f_published']   = 'Trạng thái';
$lang['f_function']    = 'Chức năng';

//lable
$lang['title_label']           = 'Tiêu đề';
$lang['slug_label']            = 'Slug';
$lang['description_label']     = 'Mô tả';
$lang['context_label']         = 'Context';
$lang['language_label']        = 'Ngôn ngữ';
$lang['precedence_label']      = 'Sort';
$lang['parent_label']          = 'Danh mục cha';
$lang['published_label']       = 'Trạng thái';
$lang['select_dropdown_label'] = '--- Select ---';
$lang['limit_label']           = 'Limit';
$lang['gender_label']          = 'Giới tính';
$lang['gender_male']           = 'Nam';
$lang['gender_female']         = 'Nữ';
$lang['gender_other']          = 'Khác';
$lang['super_admin_label']     = 'Super Admin';
$lang['image_label']           = 'Hình đại diện';
$lang['address_label']         = 'Địa chỉ';
$lang['dob_label']             = 'Ngày sinh';
$lang['pass_title_label']      = 'Mật khẩu';
$lang['confirm_pass_label']    = 'Nhập lại mật khẩu';
$lang['full_name_label']       = 'Họ và Tên';
$lang['first_name_label']      = 'Tên';
$lang['last_name_label']       = 'Họ và tên lót';
$lang['username_label']        = 'Username';
$lang['identity_label']        = 'Identity';
$lang['active_label']          = 'Active';
$lang['group_label']           = 'Nhóm';
$lang['permission_label']      = 'Permission';
$lang['check_all']             = 'Chọn tất cả';
$lang['module_label']          = 'Module';
$lang['sub_module_label']      = 'Sub Module';
$lang['seo_title_label'] = 'Seo Title';
$lang['seo_description_label'] = 'Seo Description';
$lang['seo_keyword_label'] = 'Seo Keyword';
$lang['categories_label'] = 'Danh mục';
$lang['tags_label'] = 'Tabs';

//validation
$lang['manage_validation_label']        = 'Vui lòng nhập thông tin cho %s';
$lang['manage_validation_number_label'] = 'Vui lòng nhập kiểu số nguyên cho %s';
$lang['manage_placeholder_label']       = 'Vui lòng nhập %s';

//button
$lang['btn_add']         = 'Thêm mới';
$lang['btn_edit']        = 'Cập nhật';
$lang['btn_delete']      = 'Xoá';
$lang['btn_cancel']      = 'Trở về';
$lang['edit_submit_btn'] = 'Lưu';
$lang['add_submit_btn']  = 'Thêm mới';
$lang['btn_close'] = 'Đóng';
$lang['btn_reset'] = 'Reset';
$lang['btn_write'] = 'Ghi file';
$lang['btn_close'] = 'Thoát';
$lang['btn_add_photo'] = 'Thêm hình';

//list
$lang['data_empty']    = 'Chưa có dữ liệu! Danh sách hiện tại đang rỗng';
$lang['total_records'] = 'Showing %s to %s of %s entries';

//delete
$lang['delete_confirm']    = 'Bạn có chắc chắn xoá các mục sau:';
$lang['delete_submit_btn'] = 'Xoá';
$lang['delete_submit_ng']  = 'Không xoá';

//edit
$lang['msg_not_active'] = 'Trạng thái bài viết hiện chưa được Active';
$lang['manage_more_label'] = 'Mở rộng';

//general
$lang['catcool_dashboard'] = 'Dashboard';
$lang['dashboard_heading'] = 'Dashboard';
$lang['image_upload'] = 'Kéo và thả file vào đây<br />Hoặc<br />Click vào để chọn file';
$lang['logout'] = 'Logout';

$lang['confirm_title'] = 'Vui lòng xác nhận!';
$lang['confirm_delete'] = 'Bạn có chắc chắn muốn xoá kông?';
$lang['confirm_write'] = 'Bạn có chắc chắn muốn ghi file kông?';
$lang['error_exist'] = 'Dữ liệu đã tồn tại!!!';
$lang['link_to_manage'] = 'Quản lý %s';

$lang['add_album_empty_photo'] = 'Vui lòng chọn hình trước khi tạo album';
$lang['select_photos'] = 'Vui lòng chọn hình';