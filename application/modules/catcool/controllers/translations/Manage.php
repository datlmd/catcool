<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'catcool/translations';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('translation', $this->_site_lang);

        //load model manage
        $this->load->model("catcool/TranslationManager", 'Manager');
        $this->load->model("catcool/LanguageManager", 'Language');
        $this->load->model("catcool/ModuleManager", 'Module');

        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'lang_key' => [
                'field' => 'lang_key',
                'label' => lang('lang_key_label'),
                'rules' => 'required',
            ],
            'lang_value' => [
                'field' => 'lang_value',
                'label' => lang('lang_value_label'),
                'rules' => 'required',
            ],
            'lang_id' => [
                'field' => 'lang_id',
                'label' => lang('lang_id_label'),
                'rules' => 'required',
            ],
            'module_id' => [
                'field' => 'module_id',
                'label' => lang('module_id_label'),
                'rules' => 'required',
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('published_lable'),
                'rules' => 'trim',
            ],
        ];

        //set form input
        $this->data = [
            'lang_key' => [
                'name' => 'lang_key',
                'id' => 'lang_key',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'lang_value' => [
                'name' => 'lang_value',
                'id' => 'lang_value',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'lang_id' => [
                'name' => 'lang_id',
                'id' => 'lang_id',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'module_id' => [
                'name' => 'module_id',
                'id' => 'module_id',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'published' => [
                'name' => 'published',
                'id' => 'published',
                'type' => 'checkbox',
                'checked' => true,
            ],
        ];
    }

    public function index()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed', 'refresh');
        }

        $this->data          = [];
        $this->data['title'] = lang('list_heading');

        $filter = [];

        $filter_name  = $this->input->get('filter_name', true);
        $filter_limit = $this->input->get('filter_limit', true);

        if (!empty($filter_name)) {
            $filter['lang_key']   = $filter_name;
            $filter['lang_value'] = $filter_name;
        }

        $module_id = $this->input->get('module_id');
        if (empty($module_id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('catcool/modules/manage', 'refresh');
        }

        $module = $this->Module->get_by_id($module_id);
        if (empty($module)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('catcool/modules/manage', 'refresh');
        }

        $filter['module_id'] = $module_id;
        //list lang
        list($list_lang, $total_lang) = $this->Language->get_all_by_filter();

        list($list, $total_records) = $this->Manager->get_all_by_filter($filter);
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $list[$value['lang_key']][$value['lang_id']] = $value;
                unset($list[$key]);
            }
        }

        $this->data['list'] = $list;
        $this->data['list_lang'] = $list_lang;
        $this->data['module'] = $module;

        $this->theme->load('translations/manage/list', $this->data);
    }

    /**
     * Create table manage by entity
     */
    public function create_table()
    {
        //phai full quyen
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            set_alert(lang('error_permission_execute'), ALERT_ERROR);
            redirect('permissions/not_allowed', 'refresh');
        }

        try {
            $this->Manager->install();
            set_alert(lang('created_table_success'), ALERT_SUCCESS);

        } catch (Exception $e) {
            set_alert(lang('error'), ALERT_ERROR);
        }

        redirect(self::MANAGE_URL, 'refresh');
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed', 'refresh');
        }

        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {

            $additional_data['lang_key'] = $this->input->post('lang_key', true);
            $additional_data['lang_value'] = $this->input->post('lang_value', true);
            $additional_data['lang_id'] = $this->input->post('lang_id', true);
            $additional_data['module_id'] = $this->input->post('module_id', true);
            $additional_data['user_id']      = $this->ion_auth->get_user_id();
            $additional_data['published']   = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;

            if ($this->Manager->create($additional_data)) {
                set_alert(lang('add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL, 'refresh');
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add', 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $this->data['lang_key']['value'] = $this->form_validation->set_value('lang_key');
        $this->data['lang_value']['value'] = $this->form_validation->set_value('lang_value');
        $this->data['lang_id']['value'] = $this->form_validation->set_value('lang_id');
        $this->data['module_id']['value'] = $this->form_validation->set_value('module_id');
        $this->data['published']['value']   = $this->form_validation->set_value('published', STATUS_ON);
        $this->data['published']['checked'] = true;

        $this->theme->load('translations/manage/add', $this->data);
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed', 'refresh');
        }

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
//            if (valid_token() === FALSE || $id != $this->input->post('id')) {
//                set_alert(lang('error_token'), ALERT_ERROR);
//                redirect(self::MANAGE_URL, 'refresh');
//            }

            if ($this->form_validation->run() === TRUE) {

                $additional_data = $item_edit;

                $additional_data['lang_key'] = $this->input->post('lang_key', true);
                $additional_data['lang_value'] = $this->input->post('lang_value', true);
                $additional_data['lang_id'] = $this->input->post('lang_id', true);
                $additional_data['module_id'] = $this->input->post('module_id', true);
                $additional_data['user_id']      = $this->ion_auth->get_user_id();
                $additional_data['published']   = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;

                if ($this->Manager->create($additional_data, $id)) {
                    set_alert(lang('edit_success'), ALERT_SUCCESS);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                }
                redirect(self::MANAGE_URL . '/edit/' . $id, 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['lang_key']['value'] = $this->form_validation->set_value('lang_key', $item_edit['lang_key']);
        $this->data['lang_value']['value'] = $this->form_validation->set_value('lang_value', $item_edit['lang_value']);
        $this->data['lang_id']['value'] = $this->form_validation->set_value('lang_id', $item_edit['lang_id']);
        $this->data['module_id']['value'] = $this->form_validation->set_value('module_id', $item_edit['module_id']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == STATUS_ON) ? true : false;

        $this->theme->load('translations/manage/edit', $this->data);
    }

    public function delete($id = null)
    {
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            redirect('permissions/not_allowed', 'refresh');
        }

        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            $ids         = explode(",", $this->input->post('ids', true));
            $list_delete = $this->Manager->get_list_by_ids($ids);

            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            try {
                foreach($ids as $id){
                    $this->Manager->delete($id);
                }

                set_alert(lang('delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            redirect(self::MANAGE_URL, 'refresh');
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $list_delete = $this->Manager->get_list_by_ids($delete_ids);
        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $this->data['csrf']        = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids']         = $delete_ids;

        $this->theme->load('translations/manage/delete', $this->data);
    }

    public function api_publish()
    {
        header('content-type: application/json; charset=utf8');

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
            return;
        }

        $data = [];
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        $item_edit['published'] = (isset($_POST['published']) && $_POST['published'] == 'true') ? STATUS_ON : STATUS_OFF;
        if (!$this->Manager->create($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        echo json_encode($data);
        return;
    }
}
