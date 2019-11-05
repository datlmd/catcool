<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'categories';
    CONST MANAGE_URL        = 'categories/manage';
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
        $this->load->model("categories/Category_manager", 'Manager');

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
                'label' => lang('text_title'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('text_manage_validation'), lang('text_title')),
                ],
            ],
            'slug' => [
                'field' => 'slug',
                'label' => lang('text_slug'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('text_manage_validation'), lang('text_slug')),
                ],
            ],
            'description' => [
                'field' => 'description',
                'label' => lang('text_description'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('text_manage_validation'), lang('text_description')),
                ],
            ],
            'context' => [
                'field' => 'context',
                'label' => lang('text_context'),
                'rules' => 'trim',
            ],
            'sort_order' => [
                'field' => 'sort_order',
                'label' => lang('text_sort_order'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('text_manage_validation_number'), lang('text_sort_order')),
                ],
            ],
            'parent_id' => [
                'field' => 'parent_id',
                'label' => lang('text_parent'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('text_manage_validation_number'), lang('text_parent')),
                ],
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('text_published'),
                'rules' => 'trim',
            ],
        ];

        //set form input
        $this->data = [
            'title' => [
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control make_slug',
                'placeholder' => sprintf(lang('text_manage_placeholder'), lang('text_title')),
                'oninvalid' => sprintf("this.setCustomValidity('%s')", sprintf(lang('text_manage_placeholder'), lang('text_title'))),
                'required' => 'required',
            ],
            'slug' => [
                'name' => 'slug',
                'id' => 'slug',
                'type' => 'text',
                'class' => 'form-control linked_slug',
            ],
            'description' => [
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'form-control',
            ],
            'context' => [
                'name' => 'context',
                'id' => 'context',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'sort_order' => [
                'name' => 'sort_order',
                'id' => 'sort_order',
                'type' => 'number',
                'min' => 0,
                'class' => 'form-control',
            ],
            'parent_id' => [
                'name' => 'parent_id',
                'id' => 'parent_id',
                'type' => 'dropdown',
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
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_read'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

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
            $filter['context'] = $filter_name;
        }

        $limit         = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index   = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) : 0;
        $total_records = 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $this->data['list']   = format_tree($list);
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

        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {

            // check lang cua parent giong voi lang them vao khong

            $additional_data = [
                'title'       => $this->input->post('title', true),
                'slug'        => slugify($this->input->post('slug')),
                'description' => $this->input->post('description'),
                'context'     => $this->input->post('context'),
                'sort_order'  => $this->input->post('sort_order'),
                'parent_id'   => $this->input->post('parent_id'),
                'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
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

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        list($list_all, $total) = $this->Manager->get_all_by_filter(['language' => $this->_site_lang]);
        $this->data['list_all'] = format_tree($list_all);

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['slug']['value']        = $this->form_validation->set_value('slug');
        $this->data['description']['value'] = $this->form_validation->set_value('description');
        $this->data['context']['value']     = $this->form_validation->set_value('context');
        $this->data['sort_order']['value']  = $this->form_validation->set_value('sort_order');
        $this->data['published']['value']   = $this->form_validation->set_value('published', STATUS_ON);
        $this->data['published']['checked'] = true;

        $this->data['parent_id']['options']  = $list_all;
        $this->data['parent_id']['selected'] = $this->form_validation->set_value('parent_id');

        theme_load('add', $this->data);
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

            if ($this->form_validation->run() === TRUE) {
                $edit_data = [
                    'title'       => $this->input->post('title'),
                    'slug'        => slugify($this->input->post('slug')),
                    'description' => $this->input->post('description'),
                    'context'     => $this->input->post('context'),
                    'sort_order'  => $this->input->post('sort_order'),
                    'parent_id'   => $this->input->post('parent_id'),
                    'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
                    'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
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

        list($list_all, $total) = $this->Manager->get_all_by_filter(['language' => $item_edit['language']]);
        $this->data['list_all'] = format_tree($list_all);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['slug']['value']        = $this->form_validation->set_value('slug', $item_edit['slug']);
        $this->data['description']['value'] = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['context']['value']     = $this->form_validation->set_value('context', $item_edit['context']);
        $this->data['sort_order']['value']  = $this->form_validation->set_value('sort_order', $item_edit['sort_order']);
        $this->data['parent_id']['value']   = $this->form_validation->set_value('parent_id', $item_edit['parent_id']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == STATUS_ON) ? true : false;

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
}
