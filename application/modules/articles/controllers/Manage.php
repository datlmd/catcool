<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    CONST MANAGE_NAME       = 'articles';
    CONST MANAGE_URL        = 'articles/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    CONST FOLDER_UPLOAD     = 'articles';

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

        $this->data['list']   = $list;
        $this->data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $start_index);

        set_last_url();

        theme_load('list', $this->data);
    }

    public function add()
    {
        //phai full quyen hoac duoc them moi
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {

                $category_ids = $this->input->post('category_ids', true);
                if (!empty($category_ids)) {
                    $category_ids = (is_array($category_ids)) ? $category_ids : explode(",", $category_ids);

                    $list_categories = $this->Article_category->fields('id, title')->where('id', $category_ids)->get_all();
                    if (!empty($category_ids) && empty($list_categories)) {
                        set_alert(lang('error_empty'), ALERT_ERROR);
                        redirect(self::MANAGE_URL);
                    }
                }

                $publish_date = $this->input->post('publish_date', true);
                if (empty($publish_date)) {
                    $publish_date = get_date();
                } else {
                    $publish_date = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
                }

                $additional_data = [
                    'title'           => $this->input->post('title', true),
                    'description'     => $this->input->post('description', true),
                    'slug'            => slugify($this->input->post('slug', true)),
                    'content'         => trim($_POST['content']),
                    'seo_title'       => $this->input->post('seo_title', true),
                    'seo_description' => $this->input->post('seo_description', true),
                    'seo_keyword'     => $this->input->post('seo_keyword', true),
                    'publish_date'    => $publish_date,
                    'images'          => $this->input->post('image', true),
                    'categories'      => json_encode(format_dropdown($list_categories)),
                    'tags'            => $this->input->post('tags', true),
                    'author'          => $this->input->post('author', true),
                    'source'          => $this->input->post('source', true),
                    'user_ip'         => get_client_ip(),
                    'user_id'         => $this->get_user_id(),
                    'is_comment'      => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                    'sort_order'      => $this->input->post('sort_order', true),
                    'published'       => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                    'language'        => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
                    'ctime'           => get_date(),
                ];

                if ($this->Manager->insert($additional_data) !== FALSE) {
                    set_alert(lang('text_add_success'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                    redirect(self::MANAGE_URL . '/add');
                }
            }
        }

        $this->get_form();
    }

    private function _load_css_js()
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

        //add dropdrap upload
        add_style(css_url('js/dropzone/dropdrap', 'common'));
        //$this->theme->add_js(js_url('js/dropzone/dropdrap', 'common'));

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        //filemanager
        $this->theme->add_js(js_url('js/image/common', 'common'));
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $this->_load_css_js();

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $category_ids = $this->input->post('category_ids', true);
            if (!empty($category_ids)) {
                $category_ids = (is_array($category_ids)) ? $category_ids : explode(",", $category_ids);

                $list_categories = $this->Article_category->fields('id, title')->where('id', $category_ids)->get_all();
                if (!empty($category_ids) && empty($list_categories)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }
            }

            $publish_date = $this->input->post('publish_date', true);
            if (empty($publish_date)) {
                $publish_date = get_date();
            } else {
                $publish_date = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            if ($this->form_validation->run() === TRUE) {
                $edit_data = [
                    'title'           => $this->input->post('title', true),
                    'description'     => $this->input->post('description', true),
                    'slug'            => slugify($this->input->post('slug', true)),
                    'content'         => trim($_POST['content']),
                    'seo_title'       => $this->input->post('seo_title', true),
                    'seo_description' => $this->input->post('seo_description', true),
                    'seo_keyword'     => $this->input->post('seo_keyword', true),
                    'publish_date'    => $publish_date,
                    'is_comment'      => (isset($_POST['is_comment'])) ? STATUS_ON : STATUS_OFF,
                    'images'          => $this->input->post('image', true),
                    'categories'      => json_encode(format_dropdown($list_categories)),
                    'tags'            => $this->input->post('tags', true),
                    'author'          => $this->input->post('author', true),
                    'source'          => $this->input->post('source', true),
                    'user_ip'         => get_client_ip(),
                    'user_id'         => $this->get_user_id(),
                    'sort_order'      => $this->input->post('sort_order', true),
                    'published'       => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                    'language'        => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
                ];


                if ($this->Manager->update($edit_data, $id) !== FALSE) {
                    set_alert(lang('text_edit_success'), ALERT_SUCCESS);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                }
                redirect(self::MANAGE_URL . '/edit/' . $id);
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        list($list_all, $total)   = $this->Article_category->fields('id, title')->get_all_by_filter(['language' => $this->_site_lang]);
        $this->data['categories'] = $list_all;

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['categorie_item'] = $item_edit['categories'];// json_decode($item_edit['categories'], true);
        $this->data['images'] = $item_edit['images'];

        $this->data['title']['value']           = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['description']['value']     = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['slug']['value']            = $this->form_validation->set_value('slug', $item_edit['slug']);
        $this->data['content']['value']         = $this->form_validation->set_value('content', $item_edit['content']);
        $this->data['seo_title']['value']       = $this->form_validation->set_value('seo_title', $item_edit['seo_title']);
        $this->data['seo_description']['value'] = $this->form_validation->set_value('seo_description', $item_edit['seo_description']);
        $this->data['seo_keyword']['value']     = $this->form_validation->set_value('seo_keyword', $item_edit['seo_keyword']);
        $this->data['publish_date']['value']    = $this->form_validation->set_value('publish_date', $item_edit['publish_date']);
        $this->data['tags']['value']            = $this->form_validation->set_value('tags', $item_edit['tags']);
        $this->data['author']['value']          = $this->form_validation->set_value('author', $item_edit['author']);
        $this->data['source']['value']          = $this->form_validation->set_value('source', $item_edit['source']);
        $this->data['sort_order']['value']      = $this->form_validation->set_value('sort_order', $item_edit['sort_order']);
        $this->data['published']['value']       = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked']     = ($item_edit['published'] == STATUS_ON) ? true : false;
        $this->data['is_comment']['value']      = $this->form_validation->set_value('is_comment', $item_edit['is_comment']);
        $this->data['is_comment']['checked']    = ($item_edit['is_comment'] == STATUS_ON) ? true : false;

        theme_load('edit', $this->data);
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
        $this->_load_css_js();

        $data['list_lang'] = get_list_lang();

        list($list_all, $total) = $this->Article_category->fields('category_id, title')->get_all_by_filter();
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
}
