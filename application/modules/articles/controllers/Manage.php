<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'articles';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('article', $this->_site_lang);

        //load model manage
        $this->load->model("articles/ArticleManager", 'Manager');
        $this->load->model("categories/CategoryManager", 'Category');

        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_name', self::MANAGE_NAME);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('list_heading'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'title' => [
                'field' => 'title',
                'label' => lang('title_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('title_label')),
                ],
            ],
            'description' => [
                'field' => 'description',
                'label' => lang('description_label'),
                'rules' => 'trim',
            ],
            'slug' => [
                'field' => 'slug',
                'label' => lang('slug_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('slug_label')),
                ],
            ],
            'content' => [
                'field' => 'content',
                'label' => lang('content_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('manage_validation_label'), lang('content_label')),
                ],
            ],
            'seo_title' => [
                'field' => 'seo_title',
                'label' => lang('seo_title_label'),
                'rules' => 'trim',
            ],
            'seo_description' => [
                'field' => 'seo_description',
                'label' => lang('seo_description_label'),
                'rules' => 'trim',
            ],
            'seo_keyword' => [
                'field' => 'seo_keyword',
                'label' => lang('seo_keyword_label'),
                'rules' => 'trim',
            ],
            'publish_date' => [
                'field' => 'publish_date',
                'label' => lang('publish_date_label'),
                'rules' => 'trim',
            ],
            'is_comment' => [
                'field' => 'is_comment',
                'label' => lang('is_comment_label'),
                'rules' => 'trim',
            ],
            'images' => [
                'field' => 'images',
                'label' => lang('images_label'),
                'rules' => 'trim',
            ],
            'categories' => [
                'field' => 'categories',
                'label' => lang('categories_label'),
                'rules' => 'trim',
            ],
            'tags' => [
                'field' => 'tags',
                'label' => lang('tags_label'),
                'rules' => 'trim',
            ],
            'author' => [
                'field' => 'author',
                'label' => lang('author_label'),
                'rules' => 'trim',
            ],
            'source' => [
                'field' => 'source',
                'label' => lang('source_label'),
                'rules' => 'trim',
            ],
            'precedence' => [
                'field' => 'precedence',
                'label' => lang('precedence_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('manage_validation_number_label'), lang('precedence_label')),
                ],
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('published_lable'),
                'rules' => 'trim',
            ],
        ];

        //set form input
        $this->data = [
            'title' => [
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'description' => [
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'rows' => 4,
                'class' => 'form-control',
            ],
            'slug' => [
                'name' => 'slug',
                'id' => 'slug',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'content' => [
                'name' => 'content',
                'id' => 'content',
                'type' => 'textarea',
                'rows' => 10,
                'class' => 'form-control load_ckeditor',
            ],
            'seo_title' => [
                'name' => 'seo_title',
                'id' => 'seo_title',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'seo_description' => [
                'name' => 'seo_description',
                'id' => 'seo_description',
                'type' => 'textarea',
                'rows' => 4,
                'class' => 'form-control',
            ],
            'seo_keyword' => [
                'name' => 'seo_keyword',
                'id' => 'seo_keyword',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'publish_date' => [
                'name' => 'publish_date',
                'id' => 'publish_date',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'is_comment' => [
                'name' => 'is_comment',
                'id' => 'is_comment',
                'type' => 'checkbox',
                'checked' => true,
            ],
            'images' => [
                'name' => 'images',
                'id' => 'images',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'tags' => [
                'name' => 'tags',
                'id' => 'tags',
                'type' => 'text',
                'class' => 'form-control',
                'data-role' => 'tagsinput',
            ],
            'author' => [
                'name' => 'author',
                'id' => 'author',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'source' => [
                'name' => 'source',
                'id' => 'source',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'precedence' => [
                'name' => 'precedence',
                'id' => 'precedence',
                'type' => 'number',
                'min' => 0,
                'class' => 'form-control',
            ],
            'published' => [
                'name' => 'published',
                'id' => 'published',
                'type' => 'checkbox',
                'checked' => true,
            ],
        ];
    }

    public function index()
    {
        //phai full quyen hoac chi duoc doc
        if (!$this->ion_auth->in_group([PERMISSION_ADMIN_ALL, PERMISSION_ADMIN_READ])) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect(base_url(CATCOOL_DASHBOARD), 'refresh');
        };

        $this->data          = [];
        $this->data['title'] = lang('list_heading');

        $filter = [];

        $filter_language = $this->input->get('filter_language', true);
        $filter_name     = $this->input->get('filter_name', true);
        $filter_limit    = $this->input->get('filter_limit', true);

        //trường hợp không show dropdown thì get language session
        if (!is_show_select_language()) {
            $filter['language'] = $this->_site_lang;
        } else {
            $filter['language'] = (!empty($filter_language) && $filter_language != 'none') ? $filter_language : '';
        }

        if (!empty($filter_name)) {
            $filter['title']   = $filter_name;
        }

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        //create pagination
        $settings               = $this->config->item('pagination');
        $settings['base_url']   = base_url(self::MANAGE_URL);
        $settings['total_rows'] = $total_records;
        $settings['per_page']   = $limit;

        if ($total_records > 0) {
            // use the settings to initialize the library
            $this->pagination->initialize($settings);
            // build paging links
            $this->data['pagination_links'] = $this->pagination->create_links();
        }

        $this->data['list']          = $list;
        $this->data['total_records'] = $total_records;

        $this->theme->load('manage/list', $this->data);
    }

    /**
     * Create table manage by entity
     */
    public function create_table()
    {
        //phai full quyen
//        if (!$this->ion_auth->in_group([PERMISSION_ADMIN_ALL])) {
//            set_alert(lang('error_permission_execute'), ALERT_ERROR);
//            redirect(self::MANAGE_URL, 'refresh');
//        };

        try {
            $this->Manager->install();
            set_alert(lang('created_table_success'), ALERT_SUCCESS);

        } catch (Exception $e) {
            set_alert(lang('error'), ALERT_ERROR);
        }

        redirect(self::MANAGE_URL, 'refresh');
    }

    public function add()
    {
        //add ckeditor
        $this->theme->add_js(js_url('js/ckeditor/ckeditor', 'common'));
        $this->theme->add_js(js_url('js/ckeditor/ckfinder/ckfinder', 'common'));
        $this->theme->add_js(js_url('js/admin/editor', 'common'));

        //add datetimepicker
        add_style('assets/vendor/datepicker/tempusdominus-bootstrap-4');
        prepend_script('assets/vendor/datepicker/tempusdominus-bootstrap-4');
        prepend_script('assets/vendor/datepicker/moment');

        //add tags
        add_style(css_url('js/tags/tagsinput', 'common'));
        $this->theme->add_js(js_url('js/tags/tagsinput', 'common'));

        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {

            $category_ids    = $this->input->post('categories', true);
            $list_categories = $this->Category->get_list_by_ids($category_ids);
            if (!empty($category_ids) && empty($list_categories)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            $publish_date = $this->input->post('publish_date', true);
            if (empty($publish_date)) {
                $publish_date = date('Y-m-d H:i:s', time());
            } else {
                $publish_date = date('Y-m-d H:i:00', strtotime($publish_date));
            }
            $upload = upload_file('image_file', 'article');

            $additional_data = [
                'title'           => $this->input->post('title', true),
                'description'     => $this->input->post('description', true),
                'slug'            => $this->input->post('slug', true),
                'content'         => $this->input->post('content', true),
                'seo_title'       => $this->input->post('seo_title', true),
                'seo_description' => $this->input->post('seo_description', true),
                'seo_keyword'     => $this->input->post('seo_keyword', true),
                'publish_date'    => $publish_date,

                'images' => $this->input->post('images', true),

                'categories'      => json_encode(format_dropdown($list_categories)),
                'tags'            => $this->input->post('tags', true),
                'author'          => $this->input->post('author', true),
                'source'          => $this->input->post('source', true),
                'user_ip'         => get_client_ip(),
                'is_comment'      => (isset($_POST['is_comment']) && $_POST['is_comment'] == true) ? PUBLISH_STATUS_ON : PUBLISH_STATUS_OFF,
                'language'        => $this->input->post('language', true),
                'precedence'      => $this->input->post('precedence', true),
                'published'       => (isset($_POST['published']) && $_POST['published'] == true) ? PUBLISH_STATUS_ON : PUBLISH_STATUS_OFF,
                'language'        => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
            ];

            if ($this->Manager->create($additional_data)) {
                set_alert(lang('add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL, 'refresh');
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add', 'refresh');
            }
        }

        list($list_all, $total) = $this->Category->get_all_by_filter(['language' => $this->_site_lang]);
        $this->data['categories'] = $list_all;

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $this->data['title']['value']           = $this->form_validation->set_value('title');
        $this->data['description']['value']     = $this->form_validation->set_value('description');
        $this->data['slug']['value']            = $this->form_validation->set_value('slug');
        $this->data['content']['value']         = $this->form_validation->set_value('content');
        $this->data['seo_title']['value']       = $this->form_validation->set_value('seo_title');
        $this->data['seo_description']['value'] = $this->form_validation->set_value('seo_description');
        $this->data['seo_keyword']['value']     = $this->form_validation->set_value('seo_keyword');
        $this->data['publish_date']['value']    = $this->form_validation->set_value('publish_date');

        $this->data['images']['value']          = $this->form_validation->set_value('images');

        $this->data['tags']['value']            = $this->form_validation->set_value('tags');
        $this->data['author']['value']          = $this->form_validation->set_value('author');
        $this->data['source']['value']          = $this->form_validation->set_value('source');
        $this->data['precedence']['value']      = 0;
        $this->data['published']['value']       = $this->form_validation->set_value('published', PUBLISH_STATUS_ON);
        $this->data['published']['checked']     = true;
        $this->data['is_comment']['value']      = $this->form_validation->set_value('is_comment', PUBLISH_STATUS_ON);
        $this->data['is_comment']['checked']    = true;

        $this->theme->load('manage/add', $this->data);
    }

    public function edit($id = null)
    {
        //add ckeditor
        $this->theme->add_js(js_url('js/ckeditor/ckeditor', 'common'));
        $this->theme->add_js(js_url('js/ckeditor/ckfinder/ckfinder', 'common'));
        $this->theme->add_js(js_url('js/admin/editor', 'common'));

        //phai full quyen hoac duoc cap nhat
        if (!$this->ion_auth->in_group([PERMISSION_ADMIN_ALL, PERMISSION_ADMIN_EDIT])) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        };

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            if ($this->form_validation->run() === TRUE) {
                $additional_data = [
                    'title'       => $this->input->post('title', true),
                    'description' => $this->input->post('description', true),
                'slug' => $this->input->post('slug', true),
                'content' => $this->input->post('content', true),
                'seo_title' => $this->input->post('seo_title', true),
                'seo_description' => $this->input->post('seo_description', true),
                'seo_keyword' => $this->input->post('seo_keyword', true),
                'publish_date' => $this->input->post('publish_date', true),
                'is_comment' => (isset($_POST['published']) && $_POST['published'] == true) ? PUBLISH_STATUS_ON : PUBLISH_STATUS_OFF,
                'images' => $this->input->post('images', true),
                'categories' => $this->input->post('categories', true),
                'tags' => $this->input->post('tags', true),
                'author' => $this->input->post('author', true),
                'source' => $this->input->post('source', true),
                'user_ip' => $this->input->post('user_ip', true),
                    'language'    => $this->input->post('language', true),
                    'precedence'  => $this->input->post('precedence', true),
                    'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? PUBLISH_STATUS_ON : PUBLISH_STATUS_OFF,
                    'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
                ];

                if ($this->Manager->create($additional_data, $id)) {
                    set_alert(lang('edit_success'), ALERT_SUCCESS);
                } else {
                    set_alert(lang('error'), ALERT_ERROR);
                }
                redirect(self::MANAGE_URL . '/edit/' . $id, 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['description']['value'] = $this->form_validation->set_value('description', $item_edit['description']);
                $this->data['slug']['value'] = $this->form_validation->set_value('slug', $item_edit['slug']);
                $this->data['content']['value'] = $this->form_validation->set_value('content', $item_edit['content']);
                $this->data['seo_title']['value'] = $this->form_validation->set_value('seo_title', $item_edit['seo_title']);
                $this->data['seo_description']['value'] = $this->form_validation->set_value('seo_description', $item_edit['seo_description']);
                $this->data['seo_keyword']['value'] = $this->form_validation->set_value('seo_keyword', $item_edit['seo_keyword']);
                $this->data['publish_date']['value'] = $this->form_validation->set_value('publish_date', $item_edit['publish_date']);

                $this->data['images']['value'] = $this->form_validation->set_value('images', $item_edit['images']);
                $this->data['categories']['value'] = $this->form_validation->set_value('categories', $item_edit['categories']);
                $this->data['tags']['value'] = $this->form_validation->set_value('tags', $item_edit['tags']);
                $this->data['author']['value'] = $this->form_validation->set_value('author', $item_edit['author']);
                $this->data['source']['value'] = $this->form_validation->set_value('source', $item_edit['source']);

        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence', $item_edit['precedence']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == PUBLISH_STATUS_ON) ? true : false;

        $this->data['is_comment']['value'] = $this->form_validation->set_value('is_comment', $item_edit['is_comment']);
        $this->data['is_comment']['checked'] = ($item_edit['is_comment'] == PUBLISH_STATUS_ON) ? true : false;

        $this->theme->load('manage/edit', $this->data);
    }

    public function delete($id = null)
    {
        //phai full quyen hoac duowc xoa
        if (!$this->ion_auth->in_group([PERMISSION_ADMIN_ALL, PERMISSION_ADMIN_DELETE])) {
            set_alert(lang('error_permission_delete'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        };

        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            $ids         = explode(",", $this->input->post('ids', true));
            $list_delete = $this->Manager->get_list_by_ids($ids);

            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            try {
                foreach($ids as $id){
                    $this->Manager->delete($id);
                }

                set_alert(lang('delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            redirect(self::MANAGE_URL, 'refresh');
        }

        $delete_ids = $id;

        //truong hop chon xoa nhieu muc
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $delete_ids = $this->input->post('delete_ids', true);
        }

        if (empty($delete_ids)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $list_delete = $this->Manager->get_list_by_ids($delete_ids);
        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $this->data['csrf']        = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids']         = $delete_ids;

        $this->theme->load('manage/delete', $this->data);
    }

    public function api_publish()
    {
        header('content-type: application/json; charset=utf8');

        //phai full quyen hoac duoc cap nhat
        if (!$this->ion_auth->in_group([PERMISSION_ADMIN_ALL, PERMISSION_ADMIN_EDIT])) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_permission_edit')]);
            return;
        };

        $data = [];
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        $item_edit['published'] = (isset($_POST['published']) && $_POST['published'] == true) ? PUBLISH_STATUS_ON : PUBLISH_STATUS_OFF;
        if (!$this->Manager->create($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        echo json_encode($data);
        return;
    }

    /**
     * format dropdown
     *
     * @param $list_dropdown
     * @param null $id_unset
     * @return array
     */
    private function _get_dropdown($list_dropdown, $id_unset = null)
    {
        $list_tree = format_dropdown($list_dropdown);

        if (empty($list_tree)) {
            return ;
        }
            foreach ($list_tree as $key => $val) {
                $dropdown[$key] = $val;
            }

        if (!empty($id_unset) && isset($dropdown[$id_unset])) {
            unset($dropdown[$id_unset]);
        }

        return $dropdown;
    }
}
