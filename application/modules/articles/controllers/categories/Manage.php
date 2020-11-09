<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'articles/categories/manage';
    CONST MANAGE_URL  = 'articles/categories/manage';

    CONST SEO_URL_MODULE   = 'articles';
    CONST SEO_URL_RESOURCE = 'categories/detail/%s';

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

        $this->lang->load('categories_manage', $this->_site_lang);

        //load model manage
        $this->load->model("articles/Article_category", 'Article_category');
        $this->load->model("articles/Article_category_description", 'Article_category_description');

        $this->load->model("routes/Route", "Route");

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('module_article'), base_url("articles/manage"));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));
    }

    public function index()
    {
        $this->theme->add_js(js_url('vendor/shortable-nestable/jquery.nestable', 'common'));
        $this->theme->add_js(js_url('js/admin/category', 'common'));

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        list($list, $total) = $this->Article_category->get_all_by_filter($filter);

        $data['list']   = format_tree(['data' => $list, 'key_id' => 'category_id']);
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $total, $this->input->get('page'));

        set_last_url();

        theme_load('categories/list', $data);
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
                'sort_order' => $this->input->post('sort_order'),
                'image'      => $this->input->post('image'),
                'parent_id'  => $this->input->post('parent_id'),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
            ];

            $id = $this->Article_category->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            //save route url
            $seo_urls = $this->input->post('seo_urls');
            $this->Route->save_route($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['category_id'] = $id;
                $add_data_description[$key]['slug']        = !empty($seo_urls[$key]['route']) ? $seo_urls[$key]['route'] : '';
            }

            $this->Article_category_description->insert($add_data_description);

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
            if (valid_token() === FALSE || $id != $this->input->post('category_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            //save route url
            $seo_urls = $this->input->post('seo_urls');
            $this->Route->save_route($seo_urls, self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['category_id'] = $id;
                $edit_data_description[$key]['slug']        = !empty($seo_urls[$key]['route']) ? $seo_urls[$key]['route'] : '';

                if (!empty($this->Article_category_description->get(['category_id' => $id, 'language_id' => $key]))) {
                    $this->Article_category_description->where('category_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Article_category_description->insert($edit_data_description[$key]);
                }
            }

            $edit_data = [
                'sort_order' => $this->input->post('sort_order'),
                'image'      => $this->input->post('image'),
                'parent_id'  => $this->input->post('parent_id'),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'mtime'      => get_date(),
            ];

            if ($this->Article_category->update($edit_data, $id) !== FALSE) {
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

            $list_delete = $this->Article_category->get_list_full_detail($ids);
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                $this->load->model("articles/Article_category_relationship", 'Relationship');

                foreach($list_delete as $value) {
                    $this->Article_category_description->delete($value['category_id']);
                    $this->Article_category->delete($value['category_id']);
                    $this->Relationship->delete(['category_id' => $value['category_id']]);

                    //xoa slug ra khoi route
                    $this->Route->delete_by_module(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $value['category_id']));
                }

                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            json_output(['status' => 'reload', 'url' => self::MANAGE_URL]);
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
        $list_delete = $this->Article_category->get_list_full_detail($delete_ids);
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $data['csrf']        = create_token();
        $data['list_delete'] = $list_delete;
        $data['ids']         = $delete_ids;

        json_output(['data' => theme_view('categories/delete', $data, true)]);
    }

    protected function get_form($id = null)
    {
        $this->theme->add_js(js_url('js/admin/filemanager', 'common'));

        $data['list_lang'] = get_list_lang();

        list($list_all, $total) = $this->Article_category->get_all_by_filter();
        $data['list_patent'] = format_tree(['data' => $list_all, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $category = $this->Article_category->with_details()->get($id);
            if (empty($category) || empty($category['details'])) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $category = format_data_lang_id($category);

            //lay danh sach seo url tu route
            $data['seo_urls'] = $this->Route->get_list_by_module(self::SEO_URL_MODULE, sprintf(self::SEO_URL_RESOURCE, $id));

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $category;
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

        theme_load('categories/form', $data);
    }

    protected function validate_form()
    {
        //$this->form_validation->set_rules('published', str_replace(':', '', lang('text_published')), 'required|is_natural|is_unique');
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        $seo_urls = $this->input->post('seo_urls');
        $seo_data = $this->Route->get_list_available($seo_urls);
        if (!empty($seo_data)) {
            foreach ($seo_data as $val) {
                foreach ($seo_urls as $key => $value) {
                    if ($val['route'] == $value['route']) {
                        $this->errors['seo_url_' . $key] = lang('error_slug_exists');
                    }
                }
            }
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
        $item_edit = $this->Article_category->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Article_category->update($item_edit, $id)) {
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

            $data_sort = filter_sort_array(json_decode($_POST['ids'], true), 0 , "category_id");

            if (!$this->Article_category->update($data_sort, "category_id")) {
                json_output(['status' => 'ng', 'msg' => lang('error_json')]);
            }

            json_output(['status' => 'ok', 'msg' => lang('text_sort_success')]);
        }

        json_output(['status' => 'ng', 'msg' => lang('error_json')]);
    }
}
