<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT       = 'menus/manage';
    CONST MANAGE_URL        = 'menus/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->theme->theme(config_item('theme_admin'))
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        $this->lang->load('menus_manage', $this->_site_lang);

        //load model manage
        $this->load->model("menus/Menu", 'Menu');
        $this->load->model("menus/Menu_description", 'Menu_description');

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

        $this->theme->add_js(js_url('vendor/shortable-nestable/jquery.nestable', 'common'));
        $this->theme->add_js(js_url('js/admin/category', 'common'));

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $filter['is_admin'] = isset($_GET['is_admin']) ? $_GET['is_admin'] : true;

        list($list, $total) = $this->Menu->get_all_by_filter($filter);
        $data['is_admin'] = $filter['is_admin'];

        $data['list']   = format_tree(['data' => $list, 'key_id' => 'menu_id']);
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $total, $this->input->get('page'));

        set_last_url();

        theme_load('list', $data);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $add_data = [
                'slug'       => $this->input->post('slug', true),
                'context'    => $this->input->post('context', true),
                'icon'       => $this->input->post('icon', true),
                'nav_key'    => $this->input->post('nav_key', true),
                'label'      => $this->input->post('label', true),
                'attributes' => $this->input->post('attributes', true),
                'selected'   => $this->input->post('selected', true),
                'user_id'    => $this->get_user_id(),
                'parent_id'  => $this->input->post('parent_id', true),
                'sort_order' => $this->input->post('sort_order', true),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'is_admin'   => (isset($_POST['is_admin'])) ? STATUS_ON : STATUS_OFF,
                'hidden'     => (isset($_POST['hidden'])) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
            ];

            $id = $this->Menu->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['menu_id']     = $id;
            }

            $this->Menu_description->insert($add_data_description);

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
            if (valid_token() === FALSE || $id != $this->input->post('menu_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['menu_id']     = $id;

                if (!empty($this->Menu_description->get(['menu_id' => $id, 'language_id' => $key]))) {
                    $this->Menu_description->where('menu_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Menu_description->insert($edit_data_description[$key]);
                }
            }

            $edit_data['slug']       = $this->input->post('slug', true);
            $edit_data['context']    = $this->input->post('context', true);
            $edit_data['icon']       = $this->input->post('icon', true);
            $edit_data['nav_key']    = $this->input->post('nav_key', true);
            $edit_data['label']      = $this->input->post('label', true);
            $edit_data['attributes'] = $this->input->post('attributes', true);
            $edit_data['selected']   = $this->input->post('selected', true);
            $edit_data['user_id']    = $this->get_user_id();
            $edit_data['parent_id']  = $this->input->post('parent_id', true);
            $edit_data['sort_order'] = $this->input->post('sort_order', true);
            $edit_data['is_admin']   = (isset($_POST['is_admin'])) ? STATUS_ON : STATUS_OFF;
            $edit_data['hidden']     = (isset($_POST['hidden'])) ? STATUS_ON : STATUS_OFF;
            $edit_data['published']  = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;
            $edit_data['mtime']      = get_date();

            if ($this->Menu->update($edit_data, $id) !== FALSE) {
                set_alert(lang('text_edit_success'), ALERT_SUCCESS);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }
            redirect(self::MANAGE_URL . '/edit/' . $id);
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
                set_alert(lang('error_token'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error_token')]);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Menu->get_list_full_detail($ids);
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value){
                    $this->Menu_description->delete($value['menu_id']);
                    $this->Menu->delete($value['menu_id']);
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
        $list_delete = $this->Menu->get_list_full_detail($delete_ids);
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
        add_style(css_url('js/iconpicker/iconpicker', 'common'));
        $this->theme->add_js(js_url('js/iconpicker/iconpicker', 'common'));

        $data['list_lang'] = get_list_lang();

        list($list_all, $total) = $this->Menu->get_all_by_filter();
        $data['list_patent'] = format_tree(['data' => $list_all, 'key_id' => 'menu_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Menu->with_details()->get($id);
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

        theme_load('form', $data);
    }

    protected function validate_form()
    {

        $this->form_validation->set_rules('slug', lang('text_slug'), 'trim|required');
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        if (!empty($this->input->post('slug'))) {
            if (!empty($this->input->post('menu_id'))) {
                $slug = $this->Menu->where(['slug' => $this->input->post('slug'), 'menu_id !=' => $this->input->post('menu_id')])->get_all();
            } else {
                $slug = $this->Menu->where('slug', $this->input->post('slug'))->get_all();
            }

            if (!empty($slug)) {
                $this->errors['slug'] = lang('error_slug_exists');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
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
        $item_edit = $this->Menu->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Menu->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }

    public function update_sort()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
        }

        if (isset($_POST['ids']) && !empty($_POST['ids'])) {

            $data_sort = filter_sort_array(json_decode($_POST['ids'], true), 0 , "menu_id");

            if (!$this->Menu->update($data_sort, "menu_id")) {
                json_output(['status' => 'ng', 'msg' => lang('error_json')]);
            }

            json_output(['status' => 'ok', 'msg' => lang('text_sort_success')]);
        }

        json_output(['status' => 'ng', 'msg' => lang('error_json')]);
    }
}
