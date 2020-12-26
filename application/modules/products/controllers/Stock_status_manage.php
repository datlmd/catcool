<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_status_manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'products/stock_status_manage';
    CONST MANAGE_URL  = 'products/stock_status_manage';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('stock_status_manage', $this->_site_lang);

        //load model manage
        $this->load->model("products/Stock_status", "Stock_status");
        $this->load->model("products/Stock_status_description", "Stock_status_description");

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $this->theme->title(lang("heading_title"));

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit              = empty($this->input->get('filter_limit', true)) ? get_pagination_limit(true) : $this->input->get('filter_limit', true);
        $start_index        = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->Stock_status->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

        set_last_url();

        theme_load('stock_status/list', $data);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $add_data['published'] = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;
            $id = $this->Stock_status->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['stock_status_id'] = $id;
            }
            $this->Stock_status_description->insert($add_data_description);

            set_alert(lang('text_add_success'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL);
        }

        $this->get_form();
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('stock_status_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['stock_status_id'] = $id;

                if (!empty($this->Stock_status_description->get(['stock_status_id' => $id, 'language_id' => $key]))) {
                    $this->Stock_status_description->where('stock_status_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Stock_status_description->insert($edit_data_description[$key]);
                }
            }

            $edit_data['published'] = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;
            if ($this->Stock_status->update($edit_data, $id) !== FALSE) {
                set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
    }

    protected function get_form($id = null)
    {
        $data['list_lang'] = get_list_lang();

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Stock_status->with_details()->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $data_form = format_data_lang_id($data_form);

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('text_add');
            $data['text_submit'] = lang('button_add');
        }

        $data['text_cancel']   = lang('text_cancel');
        $data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        $this->theme->title($data['text_form']);
        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        theme_load('stock_status/form', $data);
    }

    protected function validate_form()
    {
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        return $is_validation;
    }

    public function delete($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            json_output(['status' => 'redirect', 'url' => 'permissions/not_allowed']);
        }

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Stock_status->get_list_full_detail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }
            try {
                foreach($list_delete as $value){
                    $this->Stock_status_description->delete($value['stock_status_id']);
                    $this->Stock_status->delete($value['stock_status_id']);
                }
                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }
            json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }
        if (empty($delete_ids)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Stock_status->get_list_full_detail($delete_ids);
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('stock_status/delete', $data, true)]);
    }

    public function publish()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Stock_status->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Stock_status->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}
