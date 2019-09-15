<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_api extends Ajax_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("users/UserManager", 'Manager');
    }

    public function publish()
    {
        header('content-type: application/json; charset=utf8');

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
            return;
        }

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        if (!empty($item_edit['super_admin']) && $this->is_super_admin() === FALSE) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_super_admin')]);
            return;
        }

        $active = (isset($_POST['published']) && $_POST['published'] == 'true') ? 1 : 0;
        if (!$this->Manager->update(['active' => $active], $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        echo json_encode($data);
        return;
    }
}
