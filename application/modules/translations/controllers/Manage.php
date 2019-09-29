<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'translations';
    CONST MANAGE_URL        = 'translations/manage';
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

        $this->lang->load('translations_manage', $this->_site_lang);

        //load model manage
        $this->load->model("translations/Translation_manager", 'Manager');
        $this->load->model("languages/Language_manager", 'Language');
        $this->load->model("modules/Module_manager", 'Module');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [];

        //set form input
        $this->data = [];
    }

    public function index()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->data          = [];
        $this->data['title'] = lang('list_heading');

        $filter = [];

        $filter_module = $this->input->get('filter_module', true);
        $filter_name   = $this->input->get('filter_name', true);

        if (!empty($filter_name)) {
            $filter['lang_key']   = $filter_name;
            $filter['lang_value'] = $filter_name;
        }

        $module_id = $this->input->get('module_id');
        if (!empty($filter_module)) {
            $module_id = $filter_module;
        }

        if (empty($module_id) && empty($filter_module)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('modules/manage');
        }

        $module = $this->Module->get($module_id);
        if (empty($module)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('modules/manage');
        }

        $filter['module_id'] = $module_id;

        //list lang
        $list_lang = $this->Language->get_list_by_publish();

        list($list, $total_records) = $this->Manager->get_all_by_filter($filter);
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $list[$value['lang_key']][$value['lang_id']] = $value;
                unset($list[$key]);
            }
        }

        list($list_module, $total_module) = $this->Module->get_all_by_filter();

        $this->data['list']        = $list;
        $this->data['list_lang']   = $list_lang;
        $this->data['list_module'] = $list_module;
        $this->data['module']      = $module;

        theme_load('list', $this->data);
    }

    public function write()
    {
        header('content-type: application/json; charset=utf8');
        //phai full quyen
        if (!$this->acl->check_acl()) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_execute')]);
            return;
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // lib
        $this->load->helper('file');

        if (!isset($_POST) || empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        try {
            $module_id = $this->input->post('module_id');

            $module = $this->Module->get($module_id);
            if (empty($module)) {
                echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
                return;
            }

            list($list_translate, $total_records) = $this->Manager->get_all_by_filter(['module_id' => $module_id]);
            if (empty($list_translate)) {
                echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
                return;
            }

            $content_template = "\$lang['%s'] = '%s';\n";

            //list lang
            $list_lang = $this->Language->get_list_by_publish();
            foreach ($list_lang as $lang) {
                // file content
                $file_content = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n";

                foreach ($list_translate as $translate) {
                    if ($translate['lang_id'] == $lang['id']) {
                        $file_content .= sprintf($content_template, $translate['lang_key'], $translate['lang_value']);
                    }
                }

                // create module
                if (!is_dir(APPPATH . "language/" . $lang['code'])) {
                    mkdir(APPPATH . 'language/' . $lang['code'], 0775, true);
                }

                if(!empty($module['sub_module'])) {
                    write_file(APPPATH . 'language/' . $lang['code'] . '/' . $module['sub_module'] . '_lang.php', $file_content);
                } else {
                    write_file(APPPATH . 'language/' . $lang['code'] . '/' . $module['module'] . '_lang.php', $file_content);
                }
            }

            echo json_encode(['status' => 'ok', 'msg' => lang('write_success')]);
            return;
        } catch (Exception $e) {
            echo json_encode(['status' => 'ng', 'msg' => $e->getMessage()]);
            return;
        }
    }

    public function add()
    {
        header('content-type: application/json; charset=utf8');
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_add')]);
            return;
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (!isset($_POST) || empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $key       = $this->input->post('add_key');
        $values    = $this->input->post('add_value');
        $module_id = $this->input->post('module_id');

        if (empty($key) || empty($values)) {
            echo json_encode(['status' => 'ng', 'msg' => sprintf(lang('manage_validation_label'), 'Key')]);
            return;
        }

        if (empty($module_id)) {
            echo json_encode(['status' => 'ng', 'msg' => sprintf(lang('manage_validation_label'), 'Module')]);
            return;
        }

        $translates = $this->Manager->get_list_by_key_module($key, $module_id);
        if (!empty($translates)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_exist')]);
            return;
        }

        //list lang
        $list_lang = $this->Language->get_list_by_publish();
        foreach ($list_lang as $lang) {
            if (empty($values[$lang['id']])) {
                continue;
            }

            $add_data['lang_key']   = $key;
            $add_data['lang_value'] = $values[$lang['id']];
            $add_data['lang_id']    = $lang['id'];
            $add_data['module_id']  = $module_id;
            $add_data['user_id']    = $this->get_user_id();
            $add_data['ctime']      = get_date();

            $this->Manager->insert($add_data);
        }

        set_alert(lang('add_success'), ALERT_SUCCESS);
        echo json_encode(['status' => 'ok', 'msg' => lang('add_success')]);
        return;

    }

    public function edit()
    {
        header('content-type: application/json; charset=utf8');

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
            return;
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (!isset($_POST) || empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $translates = $this->input->post('translate');
        $module_id  = $this->input->post('module_id');

        //list lang
        $list_lang = $this->Language->get_list_by_publish();

        if (empty($translates) || empty($module_id)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        foreach ($translates as $translation_key => $value) {
            foreach ($list_lang as $lang) {
                if (empty($value[$lang['id']])) {
                    continue;
                }

                $item_edit = $this->Manager->get_by_key_lang_module($translation_key, $lang['id'], $module_id);

                if (empty($item_edit)) {
                    $item_edit['lang_key']   = $translation_key;
                    $item_edit['lang_value'] = $value[$lang['id']];
                    $item_edit['lang_id']    = $lang['id'];
                    $item_edit['module_id']  = $module_id;
                    $item_edit['user_id']    = $this->get_user_id();
                    $item_edit['ctime']      = get_date();

                    //add
                    $this->Manager->insert($item_edit);
                } else {
                    $data_edit['lang_value'] = $value[$lang['id']];
                    $data_edit['user_id']    = $this->get_user_id();

                    //edit
                    $this->Manager->update($data_edit, $item_edit['id']);
                }
            }
        }

        set_alert(lang('edit_success'), ALERT_SUCCESS);
        echo json_encode(['status' => 'ok', 'msg' => lang('edit_success')]);
        return;
    }

    public function delete()
    {
        header('content-type: application/json; charset=utf8');
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_delete')]);
            return;
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //delete
        if (!isset($_POST) || empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        try {
            $key       = $this->input->post('key');
            $module_id = $this->input->post('module_id');

            $translates = $this->Manager->get_list_by_key_module($key, $module_id);
            if (empty($translates)) {
                echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
                return;
            }

            foreach ($translates as $translate) {
                $this->Manager->delete($translate['id']);
            }
        } catch (Exception $e) {
            set_alert($e->getMessage(), ALERT_ERROR);
            echo json_encode(['status' => 'ng', 'msg' => $e->getMessage()]);
            return;
        }

        set_alert(lang('delete_success'), ALERT_SUCCESS);
        echo json_encode(['status' => 'ok', 'msg' => lang('delete_success')]);
        return;
    }
}
