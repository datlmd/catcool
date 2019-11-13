<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_NAME       = 'articles';
    CONST MANAGE_URL        = 'articles/manage';
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

        $this->lang->load('articles_manage', $this->_site_lang);
        $this->lang->load('categories_manage', $this->_site_lang);

        //load model manage
        $this->load->model("articles/Article_manager", 'Manager');
        $this->load->model("articles/Article_description_manager", 'Manager_description');
        $this->load->model("articles/Article_category_manager", 'Article_category');

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

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;
        }

        $filter_limit = $this->input->get('filter_limit', true);

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $start_index);

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
            $category_ids = $this->input->post('category_ids', true);
            if (!empty($category_ids)) {
                $category_ids = (is_array($category_ids)) ? $category_ids : explode(",", $category_ids);

                $list_categories = $this->Article_category->fields('category_id, title')->where('category_id', $category_ids)->get_all();
                if (!empty($category_ids) && empty($list_categories)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }

                $list_category_tmp = [];
                foreach ($list_categories as $val) {
                    $list_category_tmp[$val['category_id']] = $val['detail']['title'];
                }
            }

            $publish_date = $this->input->post('publish_date', true);
            if (empty($publish_date)) {
                $publish_date = get_date();
            } else {
                $publish_date = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            $add_data = [
                'publish_date' => $publish_date,
                'images'       => $this->input->post('image', true),
                'categories'   => json_encode($list_category_tmp),
                'tags'         => $this->input->post('tags', true),
                'author'       => $this->input->post('author', true),
                'source'       => $this->input->post('source', true),
                'user_ip'      => get_client_ip(),
                'user_id'      => $this->get_user_id(),
                'is_comment'   => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                'published'    => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'sort_order'   => $this->input->post('sort_order', true),
                'ctime'        => get_date(),
            ];

            $id = $this->Manager->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['article_id']  = $id;
                $edit_data_description[$key]['content']    = trim($_POST['manager_description'][$key]['content']);
            }

            $this->Manager_description->insert($add_data_description);

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
            if (valid_token() === FALSE || $id != $this->input->post('article_id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $category_ids = $this->input->post('category_ids', true);
            if (!empty($category_ids)) {
                $category_ids = (is_array($category_ids)) ? $category_ids : explode(",", $category_ids);

                $list_categories = $this->Article_category->get_details($category_ids);
                if (!empty($category_ids) && empty($list_categories)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }

                $list_category_tmp = [];
                foreach ($list_categories as $val) {
                    $list_category_tmp[$val['category_id']] = $val['detail']['title'];
                }
            }

            $publish_date = $this->input->post('publish_date', true);
            if (empty($publish_date)) {
                $publish_date = get_date();
            } else {
                $publish_date = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['article_id']  = $id;
                $edit_data_description[$key]['content']     = trim($_POST['manager_description'][$key]['content']);

                if (!empty($this->Manager_description->get(['article_id' => $id, 'language_id' => $key]))) {
                    $this->Manager_description->where('article_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Manager_description->insert($edit_data_description[$key]);
                }
            }

            $edit_data = [
                'publish_date' => $publish_date,
                'images'       => $this->input->post('image', true),
                'categories'   => json_encode($list_category_tmp),
                'tags'         => $this->input->post('tags', true),
                'author'       => $this->input->post('author', true),
                'source'       => $this->input->post('source', true),
                'user_ip'      => get_client_ip(),
                'user_id'      => $this->get_user_id(),
                'sort_order'   => $this->input->post('sort_order', true),
                'is_comment'   => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                'published'    => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
            ];

            if ($this->Manager->update($edit_data, $id) !== FALSE) {
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
                redirect(get_last_url(self::MANAGE_URL));
            }

            $ids = $this->input->post('ids', true);
            $ids = (is_array($ids)) ? $ids : explode(",", $ids);

            $list_delete = $this->Manager->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(get_last_url(self::MANAGE_URL));
            }

            try {
                foreach($list_delete as $item) {
                    $edit_data['is_delete'] = STATUS_ON;
                    $this->Manager->update($edit_data, $item['id']);
                }

                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            redirect(get_last_url(self::MANAGE_URL));
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

    protected function get_form($id = null)
    {
        //add tinymce
        prepend_script(js_url('js/tinymce/tinymce.min', 'common'));
        prepend_script(js_url('js/admin/tiny_content', 'common'));
        prepend_script(js_url('js/admin/articles/articles', 'common'));

        //add datetimepicker
        add_style(css_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/moment', 'common'));

        //add tags
        add_style(css_url('js/tags/tagsinput', 'common'));
        $this->theme->add_js(js_url('js/tags/tagsinput', 'common'));

        $data['list_lang'] = get_list_lang();

        list($list_all, $total) = $this->Article_category->get_all_by_filter();
        $data['categories']     = $list_all;

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Manager->where('article_id', $id)->with_details()->get();
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

        theme_load('form', $data);
    }

    protected function validate_form()
    {
        $slug_key = [];
        //$this->form_validation->set_rules('published', str_replace(':', '', lang('text_published')), 'required|is_natural|is_unique');
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), str_replace(':', '', $value['name'] . ' ' . lang('text_name')), 'trim|required');
            $this->form_validation->set_rules(sprintf('manager_description[%s][slug]', $key), str_replace(':', '', $value['name'] . ' ' . lang('text_slug')), 'trim|required');
            $this->form_validation->set_rules(sprintf('manager_description[%s][content]', $key), str_replace(':', '', $value['name'] . ' ' . lang('text_content')), 'trim|required');

            if (!empty($this->input->post(sprintf('manager_description[%s][slug]', $key)))) {
                $slug_key[$key] = $this->input->post(sprintf('manager_description[%s][slug]', $key));
            }
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        if (!empty($slug_key)) {
            if (!empty($this->input->post('article_id'))) {
                $slugs = $this->Manager_description->where([['slug', $slug_key], ['article_id', '!=', $this->input->post('article_id')]])->get_all();
            } else {
                $slugs = $this->Manager_description->where('slug', $slug_key)->get_all();
            }

            if (!empty($slugs)) {
                foreach ($slugs as $val) {
                    foreach ($slug_key as $key => $slug) {
                        if ($val['slug'] == $slug) {
                            $key_error = 'slug_' . $key;
                            $this->errors[$key_error] = lang('error_slug_exists');
                        }
                    }
                }
                return FALSE;
            }
        }

        return $is_validation;
    }
}
