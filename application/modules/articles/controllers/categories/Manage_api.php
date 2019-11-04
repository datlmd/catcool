<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_api extends Ajax_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("articles/Article_category_manager", 'Manager');
        $this->output->set_content_type('application/json');
    }

    public function publish()
    {
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
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        $item_edit['published'] = (!empty($this->input->post('published'))) ? STATUS_ON : STATUS_OFF;
        if ($this->Manager->update($item_edit, $id) === FALSE) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        $this->output->set_output(json_encode($data));
    }

    public function get_parent()
    {

        if (empty($_POST)) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => lang('error_json')]));
        }

        list($list, $total) = $this->Manager->fields('id, title, parent_id')->get_all_by_filter(['language' => $this->input->post('language', true)]);

        $id = $this->input->post('id', true);

        if (!empty($list) && !empty($id)) {
            foreach($list as $key => $value) {
                if ($value['id'] == $id) {
                    unset($list[$key]);
                    break;
                }
            }
        }

        if (isset($_POST['is_not_format'])) {
            $list_string = $list;
        } else {
            $output_html   = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>';
            $indent_symbol = '-&nbsp;-&nbsp;';

            $list_string = '<option value="">' . lang('select_dropdown_label') . '</option>';
            $list_string .= draw_tree_output(format_tree($list), $output_html, 0, $id, $indent_symbol);
        }

        $data = [
            'status' => 'ok',
            'msg'    => lang('reload_list_parent_success'),
            'list'   => $list_string,
        ];

        $this->output->set_output(json_encode($data));
    }

    public function add()
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => lang('error_permission_add')]));
        }

        //set rule form
        $this->form_validation->set_rules('title', sprintf(lang('manage_validation_label'), lang('title_label')), 'required');

        if (empty($_POST)) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => lang('error_json')]));
        }

        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(['status' => 'ng', 'msg' => '<ul>' . validation_errors('<li>','</li>') . '</ul>']));
        }

        $additional_data = [
            'title'       => $this->input->post('title'),
            'slug'        => slugify($this->input->post('title', true)),
            'description' => $this->input->post('description', true),
            'context'     => $this->input->post('context', true),
            'published'   => STATUS_ON,
            'sort_order'  => 0,
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

        $this->output->set_output(json_encode($data));
    }
}
