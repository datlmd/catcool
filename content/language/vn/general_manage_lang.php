<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang = [
    //Errors
    'error_token' => 'Có lỗi xảy ra trong quá trình thực thi. Vui lòng thử lại!',
    'error_json'  => 'Có lỗi xảy ra trong quá trình thực thi',
    'error_empty' => 'Dữ liệu không tồn tại',
    'error'       => 'Lỗi hệ thống',
    'error_permission_execute' => 'Bạn không có quyền thực thi thao tác này. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_read' => 'Bạn không có quyền thao tác xem dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_add' => 'Bạn không có quyền thao tác thêm mới dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_edit' => 'Bạn không có quyền thao tác cập nhật dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_super_admin' => 'Bạn không có quyền cập nhật hoặc xoá những User có quyền cao hơn. <br />Xin kiểm tra lại quyền với admin.',
    'error_permission_delete' => 'Bạn không có quyền thao tác xoá dữ liệu. <br />Xin kiểm tra lại quyền với admin.',
    'file_not_found' => 'File không tồn tại',

    //successfully
    'modify_publish_success'     => 'Đã cập nhật trạng thái thành công',
    'reload_list_parent_success' => 'Danh mục cha đã được làm mới',
    'delete_success'             => 'Đã xoá dữ liệu thành công',
    'add_success'                => 'Đã thêm mới dữ liệu thành công',
    'edit_success'               => 'Đã cập nhật thành công',
    'created_table_success'      => 'Đã tạo table thành công',
    'delete_file_success'        => 'Đã xoá file thành công',
    'write_success'        => 'Đã ghi file thành công!',


    //filter
    'filter_header'       => 'Bộ lọc',
    'filter_dropdown_all' => 'Tất cả',
    'filter_name'         => 'Tìm kiếm...',
    'filter_submit'       => 'Tìm kiếm',

    //table header
    'f_id'          => 'ID',
    'f_title'       => 'Tiêu đề',
    'f_slug'        => 'Slug',
    'f_description' => 'Mô tả ',
    'f_context'     => 'Context',
    'f_language'    => 'Ngôn ngữ',
    'f_sort_order'  => 'Sort',
    'f_parent'      => 'Danh mục ',
    'f_published'   => 'Trạng thái',
    'f_function'    => 'Chức năng',

    //lable
    'title_label'           => 'Tiêu đề',
    'slug_label'            => 'Slug',
    'description_label'     => 'Mô tả',
    'context_label'         => 'Context',
    'language_label'        => 'Ngôn ngữ',
    'sort_order_label'      => 'Sort',
    'parent_label'          => 'Danh mục cha',
    'published_label'       => 'Trạng thái',
    'select_dropdown_label' => '--- Select ---',
    'limit_label'           => 'Limit',
    'gender_label'          => 'Giới tính',
    'gender_male'           => 'Nam',
    'gender_female'         => 'Nữ',
    'gender_other'          => 'Khác',
    'super_admin_label'     => 'Super Admin',
    'image_label'           => 'Hình đại diện',
    'address_label'         => 'Địa chỉ',
    'dob_label'             => 'Ngày sinh',
    'pass_title_label'      => 'Mật khẩu',
    'confirm_pass_label'    => 'Nhập lại mật khẩu',
    'full_name_label'       => 'Họ và Tên',
    'first_name_label'      => 'Tên',
    'last_name_label'       => 'Họ và tên lót',
    'username_label'        => 'Username',
    'identity_label'        => 'Identity',
    'active_label'          => 'Active',
    'group_label'           => 'Nhóm',
    'permission_label'      => 'Permission',
    'check_all'             => 'Chọn tất cả',
    'module_label'          => 'Module',
    'sub_module_label'      => 'Sub Module',
    'seo_title_label' => 'Seo Title',
    'seo_description_label' => 'Seo Description',
    'seo_keyword_label' => 'Seo Keyword',
    'categories_label' => 'Danh mục',
    'tags_label' => 'Tabs',

    //validation
    'manage_validation_label'        => 'Vui lòng nhập thông tin cho %s',
    'manage_validation_number_label' => 'Vui lòng nhập kiểu số nguyên cho %s',
    'manage_placeholder_label'       => 'Vui lòng nhập %s',

    //button
    'btn_add'         => 'Thêm mới',
    'btn_edit'        => 'Cập nhật',
    'btn_delete'      => 'Xoá',
    'btn_cancel'      => 'Trở về',
    'edit_submit_btn' => 'Lưu',
    'add_submit_btn'  => 'Thêm mới',
    'btn_close' => 'Đóng',
    'btn_reset' => 'Reset',
    'btn_write' => 'Ghi file',
    'btn_close' => 'Thoát',
    'btn_add_photo' => 'Thêm hình',

    //list
    'data_empty'    => 'Chưa có dữ liệu! Danh sách hiện tại đang rỗng',
    'total_records' => 'Showing %s to %s of %s entries',

    //delete
    'delete_confirm'    => 'Bạn có chắc chắn xoá các mục sau:',
    'delete_submit_btn' => 'Xoá',
    'delete_submit_ng'  => 'Không xoá',

    //edit
    'msg_not_active' => 'Trạng thái bài viết hiện chưa được Active',
    'manage_more_label' => 'Mở rộng',

    //general
    'catcool_dashboard' => 'Dashboard',
    'dashboard_heading' => 'Dashboard',
    'image_upload' => 'Kéo và thả file vào đây<br />Hoặc<br />Click vào để chọn file',
    'logout' => 'Logout',

    'confirm_title' => 'Vui lòng xác nhận!',
    'confirm_delete' => 'Bạn có chắc chắn muốn xoá kông?',
    'confirm_write' => 'Bạn có chắc chắn muốn ghi file kông?',
    'error_exist' => 'Dữ liệu đã tồn tại!!!',
    'link_to_manage' => 'Quản lý %s',

    'add_album_empty_photo' => 'Vui lòng chọn hình trước khi tạo album',
    'select_photos' => 'Vui lòng chọn hình',
];