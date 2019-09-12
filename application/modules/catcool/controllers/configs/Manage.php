<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'catcool/configs';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->theme->title(config_item('site_name'))
            ->description(config_item('site_description'))
            ->keywords(config_item('site_keywords'));

        $this->lang->load('configs_manage', $this->_site_lang);

        //load model manage
        $this->load->model("catcool/ConfigManager", 'Manager');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'description' => [
                'field' => 'description',
                'label' => lang('description_label'),
                'rules' => 'trim',
            ],
            'config_key' => [
                'field' => 'config_key',
                'label' => lang('config_key_label'),
                'rules' => 'required',
            ],
            'config_value' => [
                'field' => 'config_value',
                'label' => lang('config_value_label'),
                'rules' => 'required',
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('published_label'),
                'rules' => 'trim',
            ],
        ];

        //set form input
        $this->data = [
            'description' => [
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'form-control',
            ],
            'config_key' => [
                'name' => 'config_key',
                'id' => 'config_key',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'config_value' => [
                'name' => 'config_value',
                'id' => 'config_value',
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
            $filter['config_key']   = $filter_name;
            $filter['config_value'] = $filter_name;
        }

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        //create pagination
        $settings               = $this->config->item('pagination');
        $settings['base_url']   = base_url(self::MANAGE_URL);
        $settings['total_rows'] = $total_records;
        $settings['per_page']   = $limit;

        if ($total_records > 0) {
            // use the settings to initialize the library
            $this->pagination->initialize($settings);
            // build paging links
            $this->data['pagination_links'] = $this->pagination->create_links();
        }

        $this->data['list']          = $list;
        $this->data['total_records'] = $total_records;
        $this->data['page_to']       = ($total_records < $limit) ? $total_records : ($start_index * $limit) + $limit;
        $this->data['page_from']     = ($start_index*$limit) + 1;

        $this->theme->load('configs/manage/list', $this->data);
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

    public function write()
    {
        //phai full quyen
        if (!$this->acl->check_acl($this->ion_auth->get_user_id(), $this->ion_auth->is_super_admin())) {
            set_alert(lang('error_permission_execute'), ALERT_ERROR);
            redirect('permissions/not_allowed', 'refresh');
        }

        // lib
        $this->load->helper('file');

        try {
            $settings = $this->Manager->get_list_by_publish();

            // file content
            $file_content = "<?php \n\n";
            if (!empty($settings)) {
                foreach ($settings as $setting) {
                    $file_content .= "//" . $setting['description'] . "\n";
                    $file_content .= "\$config['" . $setting['config_key'] . "'] = " . html_entity_decode($setting['config_value']) . ";\n\n";
                }
            }

            write_file(APPPATH . 'config/catcool.php', $file_content);
            set_alert(lang('created_setting_success'), ALERT_SUCCESS);

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

            $additional_data['description']  = $this->input->post('description', true);
            $additional_data['config_key']   = $this->input->post('config_key', true);
            $additional_data['config_value'] = $this->input->post('config_value', true);
            $additional_data['user_id']      = $this->ion_auth->get_user_id();
            $additional_data['published']    = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;

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

        $this->data['description']['value']  = $this->form_validation->set_value('description');
        $this->data['config_key']['value']   = $this->form_validation->set_value('config_key');
        $this->data['config_value']['value'] = $this->form_validation->set_value('config_value');
        $this->data['published']['value']    = $this->form_validation->set_value('published', STATUS_ON);
        $this->data['published']['checked']  = true;

        $this->theme->load('configs/manage/add', $this->data);
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

                $additional_data['description']  = $this->input->post('description', true);
                $additional_data['config_key']   = $this->input->post('config_key', true);
                $additional_data['config_value'] = $this->input->post('config_value', true);
                $additional_data['user_id']      = $this->ion_auth->get_user_id();
                $additional_data['published']    = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;

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

        $this->data['description']['value']  = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['config_key']['value']   = $this->form_validation->set_value('config_key', $item_edit['config_key']);
        $this->data['config_value']['value'] = $this->form_validation->set_value('config_value', $item_edit['config_value']);
        $this->data['published']['value']    = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked']  = ($item_edit['published'] == STATUS_ON) ? true : false;

        $this->theme->load('configs/manage/edit', $this->data);
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

        $this->theme->load('configs/manage/delete', $this->data);
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
