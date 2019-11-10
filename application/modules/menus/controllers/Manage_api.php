<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_api extends Ajax_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("menus/Menu_manager", 'Manager');
        $this->output->set_content_type('application/json');
    }

    public function publish()
    {
        header('content-type: application/json; charset=utf8');

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => lang('error_permission_edit')]));
        }

        if (empty($_POST)) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => lang('error_json')]));
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => lang('error_empty')]));
        }

        $item_edit['published'] = (!empty($this->input->post('published'))) ? STATUS_ON : STATUS_OFF;
        if (!$this->Manager->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        $this->output->set_output(json_encode($data));
    }
}
