<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_api extends Ajax_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("categories/Category_manager", 'Manager');
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

        $item_edit['published'] = (isset($_POST['published']) && $_POST['published'] == 'true') ? STATUS_ON : STATUS_OFF;
        if (!$this->Manager->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        echo json_encode($data);
        return;
    }

    public function get_parent()
    {
        header('content-type: application/json; charset=utf8');

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        list($list, $total) = $this->Manager->get_all_by_filter(['language' => $this->input->post('language', true)]);

        $id = $this->input->post('id', true);

        $output_html   = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>';
        $indent_symbol = '-&nbsp;-&nbsp;';

        $list_string = '<option value="">' . lang('select_dropdown_label') . '</option>';
        $list_string .= draw_tree_output(format_tree($list), $output_html, 0, $id, $indent_symbol);

        $data = [
            'status' => 'ok',
            'msg'    => lang('reload_list_parent_success'),
            'list'   => $list_string,
        ];

        echo json_encode($data);
        return;
    }

    public function add()
    {
        header('content-type: application/json; charset=utf8');

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_add')]);
            return;
        }

        //set rule form
        $this->form_validation->set_rules('title', sprintf(lang('manage_validation_label'), lang('title_label')), 'required');

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        if (!$this->form_validation->run()) {
            echo json_encode(['status' => 'ng', 'msg' => '<ul>' . validation_errors('<li>','</li>') . '</ul>']);
            return;
        }

        $additional_data = [
            'title'       => $this->input->post('title'),
            'slug'        => slugify($this->input->post('title', true)),
            'description' => $this->input->post('description', true),
            'context'     => $this->input->post('context', true),
            'published'   => STATUS_ON,
            'precedence'  => 0,
            'parent_id'   => 0,
            'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
            'ctime'       => get_date(),
        ];

        $id = $this->Manager->insert($additional_data);
        if ($id === FALSE) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $additional_data['id'] = $id;
            $data = ['status' => 'ok', 'msg' => lang('add_success'), 'item' => $additional_data];
        }

        echo json_encode($data);
        return;
    }
}
