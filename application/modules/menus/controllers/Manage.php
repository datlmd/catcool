<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'menus';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('menu', $this->_site_lang);

        //load model manage
        $this->load->model("menus/MenuManager", 'Manager');

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
            'context' => [
                'field' => 'context',
                'label' => lang('context_label'),
                'rules' => 'trim',
            ],
            'parent_id' => [
                'field' => 'parent_id',
                'label' => lang('parent_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('manage_validation_number_label'), lang('parent_label')),
                ],
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
                'class' => 'form-control make_slug',
                'placeholder' => sprintf(lang('manage_placeholder_label'), lang('title_label')),
                'oninvalid' => sprintf("this.setCustomValidity('%s')", sprintf(lang('manage_placeholder_label'), lang('title_label'))),
                'required' => 'required',
            ],
            'description' => [
                'name' => 'description',
                'id' => 'description',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'form-control',
            ],
            'slug' => [
                'name' => 'slug',
                'id' => 'slug',
                'type' => 'text',
                'class' => 'form-control linked_slug',
            ],
            'context' => [
                'name' => 'context',
                'id' => 'context',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'parent_id' => [
                'name' => 'parent_id',
                'id' => 'parent_id',
                'type' => 'dropdown',
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
        list($list, $total_records) = $this->Manager->findAll($filter, $limit, $start_index);

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

        $this->data['list']          = format_tree($list);
        $this->data['total_records'] = $total_records;

        $this->theme->load('manage/list', $this->data);
    }

    /**
     * Create table manage by entity
     */
    public function create_table()
    {
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
        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {
            $additional_data = [
                'title'       => $this->input->post('title', true),
                'description' => $this->input->post('description', true),
                'slug'        => $this->input->post('slug', true),
                'context'     => $this->input->post('context', true),
                'user_id'     => $this->ion_auth->get_user_id(),
                'parent_id'   => $this->input->post('parent_id', true),
                'language'    => $this->input->post('language', true),
                'precedence'  => $this->input->post('precedence', true),
                'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? PUBLISH_STATUS_ON : PUBLISH_STATUS_OFF,
                'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
            ];

            if ($this->Manager->create($additional_data)) {
                set_alert(lang('add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL, 'refresh');
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add', 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        list($list_all, $total) = $this->Manager->findAll(['language' => $this->_site_lang]);
        $list_all = $this->_get_dropdown($list_all);

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['description']['value'] = $this->form_validation->set_value('description');
        $this->data['slug']['value']        = $this->form_validation->set_value('slug');
        $this->data['context']['value']     = $this->form_validation->set_value('context');
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence');
        $this->data['published']['value']   = $this->form_validation->set_value('published', PUBLISH_STATUS_ON);
        $this->data['published']['checked'] = true;

        $this->data['parent_id']['options']  = $list_all;
        $this->data['parent_id']['selected'] = $this->form_validation->set_value('parent_id');

        $this->theme->load('manage/add', $this->data);
    }

    public function edit($id = null)
    {
        $this->data['title_heading'] = lang('edit_heading');

        //edit thi khong can tu dong tao slug
        $data['title']['class'] = 'form-control';
        $data['slug']['class']  = 'form-control';

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $item_edit = $this->Manager->findById($id);
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
                    'slug'        => $this->input->post('slug', true),
                    'context'     => $this->input->post('context', true),
                    'user_id'     => $this->ion_auth->get_user_id(),
                    'parent_id'   => $this->input->post('parent_id', true),
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

        list($list_all, $total) = $this->Manager->findAll(['language' => $item_edit['language']]);
        $list_all = $this->_get_dropdown($list_all, $id);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['description']['value'] = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['slug']['value']        = $this->form_validation->set_value('slug', $item_edit['slug']);
        $this->data['context']['value']     = $this->form_validation->set_value('context', $item_edit['context']);
        $this->data['user_id']['value']     = $this->form_validation->set_value('user_id', $item_edit['user_id']);
        $this->data['parent_id']['value']   = $this->form_validation->set_value('parent_id', $item_edit['parent_id']);
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence', $item_edit['precedence']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == PUBLISH_STATUS_ON) ? true : false;

        $this->data['parent_id']['options']  = $list_all;
        $this->data['parent_id']['selected'] = $this->form_validation->set_value('parent_id', $item_edit['parent_id']);

        $this->theme->load('manage/edit', $this->data);
    }

    public function delete($id = null)
    {
        $this->breadcrumb->add(lang('delete_heading'), base_url(self::MANAGE_URL . 'delete'));

        $this->data['title_heading'] = lang('delete_heading');

        //delete
        if (isset($_POST['is_delete']) && isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() == FALSE) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }

            $ids         = explode(",", $this->input->post('ids', true));
            $list_delete = $this->Manager->findListByIds($ids);

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

        $list_delete = $this->Manager->findListByIds($delete_ids);
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

        $data = [];
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $id        = $this->input->post('id');
        $item_edit = $this->Manager->findById($id);
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

    public function api_get_parent()
    {
        header('content-type: application/json; charset=utf8');

        if (!$this->input->is_ajax_request()) {
            //show_404();
        }

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        list($list, $total) = $this->Manager->findAll(['language' => $this->input->post('language', true)]);

        $id = $this->input->post('id', true);
        $data = [
                'status' => 'ok',
                'msg'    => lang('reload_list_parent_success'),
                'list'   => $this->_get_dropdown($list, $id)
        ];

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

        $dropdown[0] = lang('select_dropdown_lable');

        if (!empty($list_tree)) {
            foreach ($list_tree as $key => $val) {
                $dropdown[$key] = $val;
            }
        }

        if (!empty($id_unset) && isset($dropdown[$id_unset])) {
            unset($dropdown[$id_unset]);
        }

        return $dropdown;
    }
}
