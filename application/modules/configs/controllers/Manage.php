<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_NAME       = 'configs';
    CONST MANAGE_URL        = 'configs/manage';
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
        $this->load->model("configs/Config_manager", 'Manager');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $limit              = empty($this->input->get('filter_limit', true)) ? self::MANAGE_PAGE_LIMIT : $this->input->get('filter_limit', true);
        $start_index        = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

        set_last_url();

        theme_load('list', $data);
    }

    public function write()
    {
        //phai full quyen
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_execute'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        // lib
        $this->load->helper('file');

        try {
            $this->load->model("languages/Language_manager", 'Language');

            $list_language_config = [];
            $list_language = $this->Language->get_list_by_publish();
            foreach ($list_language as $key => $value) {
                unset($value['ctime']);
                unset($value['mtime']);
                $list_language_config[$value['id']] = $value;

            }

            $settings = $this->Manager->get_list_by_publish();

            // file content
            $file_content = "<?php \n\n";
            if (!empty($settings)) {
                foreach ($settings as $setting) {
                    $config_value = $setting['config_value'];
                    if (is_numeric($config_value) || is_bool($config_value) || in_array($config_value, ['true', 'false', 'TRUE', 'FALSE']) || strpos($config_value, '[') !== false) {
                        $config_value = $config_value;
                    } else {
                        $config_value = sprintf('"%s"', $config_value);
                    }

                    if ($setting['config_key'] == 'list_language_cache') {
                        $config_value = "'" . json_encode($list_language_config) . "'";
                    }

                    $file_content .= "//" . $setting['description'] . "\n";
                    $file_content .= "\$config['" . $setting['config_key'] . "'] = " . $config_value . ";\n\n";
                }
            }

            write_file(CATCOOLPATH . 'media/config/config.php', $file_content);
            set_alert(lang('created_setting_success'), ALERT_SUCCESS);

        } catch (Exception $e) {
            set_alert(lang('error'), ALERT_ERROR);
        }

        redirect(self::MANAGE_URL);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() !== FALSE) {

            $additional_data['description']  = $this->input->post('description', true);
            $additional_data['config_key']   = $this->input->post('config_key', true);
            $additional_data['config_value'] = $this->input->post('config_value', true);
            $additional_data['user_id']      = $this->get_user_id();
            $additional_data['published']    = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;
            $additional_data['ctime']        = get_date();

            $id = $this->Manager->insert($additional_data);
            if ($id !== FALSE) {
                set_alert(lang('text_add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }
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

        if (isset($_POST) && !empty($_POST) && $this->validate_form() !== FALSE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            if ($this->form_validation->run() === TRUE) {
                $edit_data['description']  = $this->input->post('description', true);
                $edit_data['config_key']   = $this->input->post('config_key', true);
                $edit_data['config_value'] = $this->input->post('config_value', true);
                $edit_data['user_id']      = $this->get_user_id();
                $edit_data['published']    = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;

                if ($this->Manager->update($edit_data, $id) !== FALSE) {
                    set_alert(lang('text_edit_success'), ALERT_SUCCESS);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                }
                redirect(self::MANAGE_URL . '/edit/' . $id);
            }
        }

        $this->get_form($id);
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
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Manager->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    $this->Manager->delete($value['id']);
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
        $list_delete = $this->Manager->where('id', $delete_ids)->get_all();
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('delete', $data, true)]);
    }

    protected function get_form($id = null)
    {
        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Manager->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

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

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        theme_load('form', $data);
    }

    protected function validate_form()
    {
        $this->form_validation->set_rules('config_key', lang('text_config_key'), 'trim|required');
        $this->form_validation->set_rules('config_value', lang('text_config_value'), 'trim|required');

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        if (!empty($this->input->post('config_key'))) {
            if (!empty($this->input->post('id'))) {
                $slug = $this->Manager->where(['config_key' => $this->input->post('config_key'), 'id !=' => $this->input->post('id')])->get_all();
            } else {
                $slug = $this->Manager->where('config_key', $this->input->post('config_key'))->get_all();
            }

            if (!empty($slug)) {
                $this->errors['config_key'] = lang('error_config_key_exists');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
    }
}
