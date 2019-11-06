<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'menus';
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

        $this->theme->title(config_item('site_name'))
            ->description(config_item('site_description'))
            ->keywords(config_item('site_keywords'));

        $this->lang->load('menus_manage', $this->_site_lang);

        //load model manage
        $this->load->model("menus/Menu_manager", 'Manager');
        $this->load->model("menus/Menu_description_manager", 'Manager_description');

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

        $this->data          = [];
        $this->data['title'] = lang('list_heading');

        $filter = [];

        $filter_name     = $this->input->get('filter_name', true);
        $filter_is_admin = $this->input->get('filter_is_admin', true);
        $filter_limit    = $this->input->get('filter_limit', true);


        if (!empty($filter_name)) {
            $filter['title'] = $filter_name;
        }

        if (!empty($filter_is_admin)) {
            $filter['is_admin'] = $filter_is_admin;
        }
        $filter['language_id'] = get_lang_id();

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $this->data['list']   = format_tree(['data' => $list, 'key_id' => 'menu_id']);
        $this->data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $start_index);

        theme_load('list', $this->data);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $additional_data = [
                'title'       => $this->input->post('title', true),
                'description' => $this->input->post('description', true),
                'slug'        => $this->input->post('slug', true),
                'context'     => $this->input->post('context', true),
                'icon'        => $this->input->post('icon', true),
                'nav_key'     => $this->input->post('nav_key', true),
                'label'       => $this->input->post('label', true),
                'attributes'  => $this->input->post('attributes', true),
                'selected'    => $this->input->post('selected', true),
                'user_id'     => $this->get_user_id(),
                'parent_id'   => $this->input->post('parent_id', true),
                'sort_order'  => $this->input->post('sort_order', true),
                'published'   => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'is_admin'    => (isset($_POST['is_admin'])) ? STATUS_ON : STATUS_OFF,
                'hidden'      => (isset($_POST['hidden'])) ? STATUS_ON : STATUS_OFF,
                'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
                'ctime'       => get_date(),
            ];

            if ($this->Manager->insert($additional_data) !== FALSE) {
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

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            if ($this->form_validation->run() === TRUE) {

                $edit_data['title']       = $this->input->post('title', true);
                $edit_data['description'] = $this->input->post('description', true);
                $edit_data['slug']        = $this->input->post('slug', true);
                $edit_data['context']     = $this->input->post('context', true);
                $edit_data['icon']        = $this->input->post('icon', true);
                $edit_data['nav_key']     = $this->input->post('nav_key', true);
                $edit_data['label']       = $this->input->post('label', true);
                $edit_data['attributes']  = $this->input->post('attributes', true);
                $edit_data['selected']    = $this->input->post('selected', true);
                $edit_data['user_id']     = $this->get_user_id();
                $edit_data['parent_id']   = $this->input->post('parent_id', true);
                $edit_data['sort_order']  = $this->input->post('sort_order', true);
                $edit_data['is_admin']    = (isset($_POST['is_admin'])) ? STATUS_ON : STATUS_OFF;
                $edit_data['hidden']      = (isset($_POST['hidden'])) ? STATUS_ON : STATUS_OFF;
                $edit_data['published']   = (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF;
                $edit_data['language']    = isset($_POST['language']) ? $_POST['language'] : $this->_site_lang;

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
        //phai full quyen hoac duowc xoa
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Manager->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            try {
                foreach($ids as $id){
                    $this->Manager->delete($id);
                }

                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            redirect(self::MANAGE_URL);
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $delete_ids  = is_array($delete_ids) ? $delete_ids : explode(',', $delete_ids);
        $list_delete = $this->Manager->where('id', $delete_ids)->get_all();

        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $this->data['csrf']        = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids']         = $delete_ids;

        theme_load('delete', $this->data);
    }

    protected function get_form($id = null) {
        $this->data['list_lang'] = get_list_lang();

        list($list_all, $total) = $this->Manager->get_all_by_filter();
        $this->data['list_patent'] = format_tree(['data' => $list_all, 'key_id' => 'menu_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $this->data['text_form'] = lang('text_edit');
            $this->data['text_submit'] = lang('button_save');

            $data = $this->Manager->with_details()->get($id);
            if (empty($data)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $data = format_data_lang_id($data);

            // display the edit user form
            $this->data['csrf']      = create_token();
            $this->data['edit_data'] = $data;
        } else {
            $this->data['text_form']   = lang('text_add');
            $this->data['text_submit'] = lang('button_add');
        }

        $this->data['text_cancel']   = lang('text_cancel');
        $this->data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        if (!empty($this->errors)) {
            $this->data['errors'] = $this->errors;
        }

        theme_load('form', $this->data);
    }

    protected function validate_form()
    {

        $this->form_validation->set_rules('slug', str_replace(':', '', lang('text_slug')), 'trim|required');
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('article_category_description[%s][title]', $key), str_replace(':', '', $value['name'] . ' ' . lang('text_title')), 'trim|required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        if (!empty($this->input->post('slug'))) {
            if (!empty($this->input->post('menu_id'))) {
                $slug = $this->Manager->where(['slug' => $this->input->post('slug'), 'menu_id !=' => $this->input->post('menu_id')])->get_all();
            } else {
                $slug = $this->Manager->where('slug', $this->input->post('slug'))->get_all();
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
}
