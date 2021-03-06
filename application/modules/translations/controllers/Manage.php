<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT = 'translations/manage';
    CONST MANAGE_URL  = 'translations/manage';

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('translations_manage', $this->_site_lang);

        //load model manage
        $this->load->model("translations/Translation", 'Translation');
        $this->load->model("languages/Language", 'Language');
        $this->load->model("modules/Module", 'Module');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add('Modules', base_url('modules/manage'));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));

        $this->load->helper('file');
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

        $module_id = $this->input->get('module_id');
        if (!empty($filter)) {
            $module_id = $filter['module_id'];
        }

        if (empty($module_id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('modules/manage');
        }

        $module = $this->Module->get($module_id);
        if (empty($module)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect('modules/manage');
        }

        $filter['module_id'] = $module_id;
        list($list, $total) = $this->Translation->get_all_by_filter($filter);
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $list[$value['lang_key']][$value['lang_id']] = $value;
                unset($list[$key]);
            }
        }

        list($list_module, $total_module) = $this->Module->get_all_by_filter();

        $list_lang = $this->Language->get_list_by_publish();

        $data['list']        = $list;
        $data['total']       = $total;
        $data['list_lang']   = $list_lang;
        $data['list_module'] = $list_module;
        $data['module']      = $module;


        //check permissions
        foreach ($list_lang as $lang) {
            if (!empty($module['sub_module'])) {
                $key_file = 'media/language/' . $lang['code'] . '/' . $module['sub_module'] . '_lang.php';
            } else {
                $key_file = 'media/language/' . $lang['code'] . '/' . $module['module'] . '_lang.php';
            }

            if (is_file(CATCOOLPATH . $key_file)) {
                $data['list_file'][$key_file] = octal_permissions(fileperms(CATCOOLPATH . $key_file));
            } else {
                $data['list_file'][$key_file] = "File not found!";
            }
        }

        set_last_url();

        theme_load('list', $data);
    }

    public function write()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_execute')]);
        }

        // lib
        $this->load->helper('file');

        if (!isset($_POST) || empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        try {
            $module_id = $this->input->post('module_id');

            $module = $this->Module->get($module_id);
            if (empty($module)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            list($list_translate, $total_records) = $this->Translation->get_all_by_filter(['module_id' => $module_id], 0, 0, ['lang_key' => 'ASC']);
            if (empty($list_translate)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            $content_template = '$lang["%s"] = "%s";' . "\n";

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
                if (!is_dir(CATCOOLPATH . "media/language/" . $lang['code'])) {
                    mkdir(CATCOOLPATH . 'media/language/' . $lang['code'], 0775, true);
                }

                if(!empty($module['sub_module'])) {
                    write_file(CATCOOLPATH . 'media/language/' . $lang['code'] . '/' . $module['sub_module'] . '_lang.php', $file_content);
                } else {
                    write_file(CATCOOLPATH . 'media/language/' . $lang['code'] . '/' . $module['module'] . '_lang.php', $file_content);
                }
            }

            json_output(['status' => 'ok', 'msg' => lang('text_write_success')]);
        } catch (Exception $e) {
            json_output(['status' => 'ng', 'msg' => $e->getMessage()]);
        }
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_add')]);
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (!isset($_POST) || empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $key       = $this->input->post('add_key');
        $values    = $this->input->post('add_value');
        $module_id = $this->input->post('module_id');
        if (empty($key)) {
            json_output(['status' => 'ng', 'msg' => sprintf(lang('text_manage_validation'), 'Key')]);
        }
        if (empty($module_id)) {
            json_output(['status' => 'ng', 'msg' => sprintf(lang('text_manage_validation'), 'Module')]);
        }

        $translates = $this->Translation->get_list_by_key_module($key, $module_id);
        if (!empty($translates)) {
            json_output(['status' => 'ng', 'msg' => lang('error_exist')]);
        }

        //list lang
        $list_lang = $this->Language->get_list_by_publish();
        foreach ($list_lang as $lang) {
            if (empty($values[$lang['id']])) {
                json_output(['status' => 'ng', 'msg' => sprintf(lang('text_manage_validation'), $lang['name'])]);
            }

            $add_data['lang_key']   = $key;
            $add_data['lang_value'] = str_replace('"', "'", $values[$lang['id']]);
            $add_data['lang_id']    = $lang['id'];
            $add_data['module_id']  = $module_id;
            $add_data['user_id']    = $this->get_user_id();
            $add_data['ctime']      = get_date();

            $this->Translation->insert($add_data);
        }

        set_alert(lang('text_add_success'), ALERT_SUCCESS);
        json_output(['status' => 'ok', 'msg' => lang('text_add_success')]);
    }

    public function edit()
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (!isset($_POST) || empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        $translates = $this->input->post('translate');
        $module_id  = $this->input->post('module_id');

        //list lang
        $list_lang = $this->Language->get_list_by_publish();

        if (empty($translates) || empty($module_id)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        foreach ($translates as $translation_key => $value) {
            foreach ($list_lang as $lang) {
                if (empty($value[$lang['id']])) {
                    continue;
                }

                $item_edit = $this->Translation->get_by_key_lang_module($translation_key, $lang['id'], $module_id);
                if (empty($item_edit)) {
                    $item_edit['lang_key']   = $translation_key;
                    $item_edit['lang_value'] = str_replace('"', "'", $value[$lang['id']]);
                    $item_edit['lang_id']    = $lang['id'];
                    $item_edit['module_id']  = $module_id;
                    $item_edit['user_id']    = $this->get_user_id();
                    $item_edit['ctime']      = get_date();

                    //add
                    $this->Translation->insert($item_edit);
                } else {
                    $data_edit['lang_value'] = str_replace('"', "'", $value[$lang['id']]);
                    $data_edit['user_id']    = $this->get_user_id();

                    //edit
                    $this->Translation->update($data_edit, $item_edit['id']);
                }
            }
        }

        set_alert(lang('text_edit_success'), ALERT_SUCCESS);
        json_output(['status' => 'ok', 'msg' => lang('text_edit_success')]);
    }

    public function delete()
    {
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_delete')]);
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //delete
        if (!isset($_POST) || empty($_POST)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        try {
            $key       = $this->input->post('key');
            $module_id = $this->input->post('module_id');

            $translates = $this->Translation->get_list_by_key_module($key, $module_id);
            if (empty($translates)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            foreach ($translates as $translate) {
                $this->Translation->delete($translate['id']);
            }
        } catch (Exception $e) {
            set_alert($e->getMessage(), ALERT_ERROR);
            json_output(['status' => 'ng', 'msg' => $e->getMessage()]);
        }

        set_alert(lang('text_delete_success'), ALERT_SUCCESS);
        json_output(['status' => 'ok', 'msg' => lang('text_delete_success')]);
    }
}
