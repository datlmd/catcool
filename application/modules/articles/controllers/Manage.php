<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    protected $errors = [];

    CONST MANAGE_ROOT       = 'articles/manage';
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

        $this->lang->load('articles_manage', $this->_site_lang);

        //load model manage
        $this->load->model("articles/Article", 'Article');
        $this->load->model("articles/Article_description", 'Article_description');
        $this->load->model("articles/Article_category", 'Article_category');
        $this->load->model("articles/Article_category_relationship", 'Relationship');

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

        //phai full quyen hoac chi duoc doc
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        $list_category                = $this->Article_category->get_list_by_publish();
        $data['list_category']        = $list_category;
        $data['list_category_filter'] = format_tree(['data' => $list_category, 'key_id' => 'category_id']);

        $filter = $this->input->get('filter');
        if (!empty($filter)) {
            $data['filter_active'] = true;

            if (!empty($filter['category'])) {
                $filter_category    = fetch_tree($data['list_category_filter'], $filter['category']);
                $filter['category'] = array_column($filter_category, 'category_id');
            }
        }

        $limit             = empty($this->input->get('filter_limit', true)) ? self::MANAGE_PAGE_LIMIT : $this->input->get('filter_limit', true);
        $start_index       = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;
        list($list, $total) = $this->Article->get_all_by_filter($filter, $limit, $start_index);

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total, $limit, $this->input->get('page'));

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

                $list_categories = $this->Article_category->get_list_full_detail($category_ids);
                if (!empty($category_ids) && empty($list_categories)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }
            }

            $publish_date = $this->input->post('publish_date', true);
            if (empty($publish_date)) {
                $publish_date = get_date();
            } else {
                $publish_date_hour = $this->input->post('publish_date_hour', true);
                $publish_date_hour = empty($publish_date_hour) ? get_date('H:i') : $publish_date_hour;
                $publish_date      = $publish_date . ' ' . $publish_date_hour;
                $publish_date      = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            $add_data = [
                'publish_date' => $publish_date,
                'images'       => $this->input->post('image', true),
                'tags'         => $this->input->post('tags', true),
                'author'       => $this->input->post('author', true),
                'source'       => $this->input->post('source', true),
                'user_ip'      => get_client_ip(),
                'user_id'      => $this->get_user_id(),
                'is_comment'   => $this->input->post('is_comment'),
                'published'    => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'sort_order'   => $this->input->post('sort_order', true),
                'ctime'        => get_date(),
            ];

            $id = $this->Article->insert($add_data);
            if ($id === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            if (!empty($list_categories)) {
                $relationship_add = [];
                foreach ($list_categories as $val) {
                    $relationship_add[] = ['article_id' => $id, 'category_id' => $val['category_id']];
                }
                $this->Relationship->insert($relationship_add);
            }

            $add_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $add_data_description[$key]['language_id'] = $key;
                $add_data_description[$key]['article_id']  = $id;
                $edit_data_description[$key]['content']    = trim($_POST['manager_description'][$key]['content']);
            }

            $this->Article_description->insert($add_data_description);

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

                $list_categories = $this->Article_category->get_list_full_detail($category_ids);
                if (!empty($category_ids) && empty($list_categories)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }
            }

            $publish_date = $this->input->post('publish_date', true);
            if (empty($publish_date)) {
                $publish_date = get_date();
            } else {
                $publish_date_hour = $this->input->post('publish_date_hour', true);
                $publish_date_hour = empty($publish_date_hour) ? get_date('H:i') : $publish_date_hour;
                $publish_date      = $publish_date . ' ' . $publish_date_hour;
                $publish_date      = date('Y-m-d H:i:00', strtotime(str_replace('/', '-', $publish_date)));
            }

            $edit_data = [
                'publish_date' => $publish_date,
                'images'       => $this->input->post('image', true),
                'tags'         => $this->input->post('tags', true),
                'author'       => $this->input->post('author', true),
                'source'       => $this->input->post('source', true),
                'user_ip'      => get_client_ip(),
                'user_id'      => $this->get_user_id(),
                'sort_order'   => $this->input->post('sort_order', true),
                'is_comment'   => $this->input->post('is_comment'),
                'published'    => (isset($_POST['published'])) ? STATUS_ON : STATUS_OFF,
                'mtime'        => get_date(),
            ];

            if ($this->Article->update($edit_data, $id) === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/edit/' . $id);
            }

            $edit_data_description = $this->input->post('manager_description');
            foreach (get_list_lang() as $key => $value) {
                $edit_data_description[$key]['language_id'] = $key;
                $edit_data_description[$key]['article_id']  = $id;
                $edit_data_description[$key]['content']     = trim($_POST['manager_description'][$key]['content']);

                if (!empty($this->Article_description->get(['article_id' => $id, 'language_id' => $key]))) {
                    $this->Article_description->where('article_id', $id)->update($edit_data_description[$key], 'language_id');
                } else {
                    $this->Article_description->insert($edit_data_description[$key]);
                }
            }

            if (!empty($list_categories)) {
                $this->Relationship->delete(array_column($list_categories, 'category_id'));

                $relationship_add = [];
                foreach ($list_categories as $val) {
                    $relationship_add[] = ['article_id' => $id, 'category_id' => $val['category_id']];
                }
                $this->Relationship->insert($relationship_add);
            }

            set_alert(lang('text_edit_success'), ALERT_SUCCESS);
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

            $list_delete = $this->Article->get_list_full_detail($ids);
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    $this->Article->delete($value['article_id']);
                    $this->Article_description->delete($value['article_id']);
                    $this->Relationship->delete($value['article_id']);
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
        $list_delete = $this->Article->get_list_full_detail($delete_ids);
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
        //add tinymce
        prepend_script(js_url('js/tinymce/tinymce.min', 'common'));
        prepend_script(js_url('js/admin/tiny_content', 'common'));
        prepend_script(js_url('js/admin/articles/articles', 'common'));

        //add datetimepicker
        add_style(css_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/locale/vi', 'common'));
        prepend_script(js_url('vendor/datepicker/moment', 'common'));

        //add tags
        add_style(css_url('js/tags/tagsinput', 'common'));
        $this->theme->add_js(js_url('js/tags/tagsinput', 'common'));

        add_style(css_url('vendor/bootstrap-select/css/bootstrap-select', 'common'));
        prepend_script(js_url('vendor/bootstrap-select/js/bootstrap-select', 'common'));

        $this->theme->add_js(js_url('js/admin/filemanager', 'common'));

        $data['list_lang'] = get_list_lang();

        list($list_all, $total)  = $this->Article_category->get_all_by_filter();
        $data['categories']      = $list_all;
        $data['categories_tree'] = format_tree(['data' => $list_all, 'key_id' => 'category_id']);

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Article->where('article_id', $id)->with_details()->get();
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $data_form = format_data_lang_id($data_form);

            $categories = $this->Relationship->where('article_id', $id)->get_all();
            if (!empty($categories)) {
                $data_form['categories'] = array_column($categories, 'category_id');
            }

            // display the edit user form
            $data['csrf']      = create_token();
            $data['edit_data'] = $data_form;
        } else {
            $data['text_form']   = lang('text_add');
            $data['text_submit'] = lang('button_add');
            $data['edit_data']   = ['publish_date' => get_date()];
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
        $slug_key = [];
        //$this->form_validation->set_rules('published', str_replace(':', '', lang('text_published')), 'required|is_natural|is_unique');
        foreach(get_list_lang() as $key => $value) {
            $this->form_validation->set_rules(sprintf('manager_description[%s][name]', $key), lang('text_name') . ' (' . $value['name']  . ')', 'trim|required');
            $this->form_validation->set_rules(sprintf('manager_description[%s][slug]', $key), lang('text_slug') . ' (' . $value['name']  . ')', 'trim|required');
            $this->form_validation->set_rules(sprintf('manager_description[%s][content]', $key), lang('text_content') . ' (' . $value['name']  . ')', 'trim|required');

            if (!empty($this->input->post(sprintf('manager_description[%s][slug]', $key)))) {
                $slug_key[$key] = $this->input->post(sprintf('manager_description[%s][slug]', $key));
            }
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        //check slug
        if (!empty($slug_key)) {
            if (!empty($this->input->post('article_id'))) {
                $slugs = $this->Article_description->where([['slug', $slug_key], ['article_id', '!=', $this->input->post('article_id')]])->get_all();
            } else {
                $slugs = $this->Article_description->where('slug', $slug_key)->get_all();
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
        $item_edit = $this->Article->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Article->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}
