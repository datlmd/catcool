<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'articles/categories';
    CONST MANAGE_URL        = 'articles/categories/manage';
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

        $this->lang->load('categories_manage', $this->_site_lang);

        //load model manage
        $this->load->model("articles/Article_category_manager", 'Manager');
        $this->load->model("articles/Article_category_description_manager", 'Manager_description');

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
        $this->data['title'] = lang('heading_title');

        $filter = [];

        $filter_name     = $this->input->get('filter_name', true);
        $filter_limit    = $this->input->get('filter_limit', true);

        $filter['language_id'] = 1;//$this->_site_lang;

        if (!empty($filter_name)) {
            $filter['title']   = $filter_name;
            $filter['context'] = $filter_name;
        }

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $this->data['list']   = format_tree(['data' => $list, 'key_id' => 'category_id']);
        $this->data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $start_index);

        theme_load('categories/list', $this->data);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        //set rule form
        $this->validate_form();

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $add_data = [
                'sort_order' => $this->input->post('sort_order'),
                'image'      => $this->input->post('image'),
                'parent_id'  => $this->input->post('parent_id'),
                'published'  => (!empty($this->input->post('published')) && $this->input->post('published') == STATUS_ON) ? STATUS_ON : STATUS_OFF,
                'ctime'      => get_date(),
            ];

            $id = $this->Manager->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $add_data_description = $this->input->post('article_category_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['category_id'] = $id;
            }

            $this->Manager_description->insert($add_data_description);

            set_alert(lang('add_success'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL);
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

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

            $edit_data_description = $this->input->post('article_category_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['category_id'] = $id;

                if (!empty($this->Manager_description->get(['category_id' => $id, 'language_id' => $key]))) {
                    $this->Manager_description->where('category_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Manager_description->insert($edit_data_description[$key]);
                }
            }

            $edit_data = [
                'sort_order' => $this->input->post('sort_order'),
                'image'      => $this->input->post('image'),
                'parent_id'  => $this->input->post('parent_id'),
                'published'  => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
            ];

            if ($this->Manager->update($edit_data, $id) !== FALSE) {
                set_alert(lang('edit_success'), ALERT_SUCCESS);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
            }
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        // display the create user form
        // set the flash data error message if there is one
        //set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);


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

                set_alert(lang('delete_success'), ALERT_SUCCESS);
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

        theme_load('categories/delete', $this->data);
    }

    protected function get_form($id = null) {
        //filemanager
        $this->theme->add_js(js_url('js/image/common', 'common'));

        $this->data['list_lang'] = get_list_lang();

        list($list_all, $total) = $this->Manager->get_all_by_filter();
        $this->data['list_patent'] = format_tree(['data' => $list_all, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $this->data['text_form'] = lang('text_edit');
            $this->data['text_submit'] = lang('button_save');

            $category = $this->Manager->with_details()->get($id);
            if (empty($category) || empty($category['details'])) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $category = format_data_lang_id($category);

            // display the edit user form
            $this->data['csrf']      = create_token();
            $this->data['edit_data'] = $category;
        } else {
            $this->data['text_form']   = lang('text_add');
            $this->data['text_submit'] = lang('button_add');
        }

        $this->data['text_cancel']   = lang('text_cancel');
        $this->data['button_cancel'] = base_url(self::MANAGE_URL.http_get_query());

        theme_load('categories/form', $this->data);
    }

    protected function validate_form()
    {
        $slug_key = [];
        //$this->form_validation->set_rules('published', str_replace(':', '', lang('published_label')), 'required|is_natural|is_unique');
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('article_category_description[%s][title]', $key), str_replace(':', '', $value['name'] . ' ' . lang('title_label')), 'trim|required');
            $this->form_validation->set_rules(sprintf('article_category_description[%s][slug]', $key), str_replace(':', '', $value['name'] . ' ' . lang('slug_label')), 'trim|required');

            $slug_key[] = sprintf('article_category_description[%s][slug]', $key);
        }

        //check slug
        $slugs = $this->input->post($slug_key);
        if (!empty($slugs)) {
            if (!empty($this->input->post('category_id'))) {
                $slugs = $this->Manager_description->where('slug', $slugs)->where('category_id', '!=', $this->input->post('category_id'))->get_all();
            } else {
                $slugs = $this->Manager_description->where('slug', $slugs)->get_all();
            }

            if (!empty($slugs)) {
                set_alert('Slug da ton tai', ALERT_ERROR);
                return false;
            }
        }

        return $this->form_validation->run();
    }
}
