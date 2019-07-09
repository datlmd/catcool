<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];

    public $data = [];

    CONST MANAGE_URL = 'categories/manage';

    public function __construct()
    {
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('categories', $this->_site_lang);

        $this->load->model("categories/CategoryManager");
        $this->theme->theme('admin')
            ->title('Admin Panel')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');

        //add breadcrumb
        $this->breadcrumb->add('Dashboard', base_url());
        $this->breadcrumb->add(lang('list_heading'), base_url('categories/manage'));

        //check validation
        $this->config_form = [
            'title' => [
                'field' => 'title',
                'label' => lang('title_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('title_label')),
                ],
            ],
            'slug' => [
                'field' => 'slug',
                'label' => lang('slug_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('slug_label')),
                ],
            ],
            'description' => [
                'field' => 'description',
                'label' => lang('description_label'),
                'rules' => 'trim|required',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('description_label')),
                ],
            ],
            'context' => [
                'field' => 'context',
                'label' => lang('context_label'),
                'rules' => 'trim',
            ],
            'precedence' => [
                'field' => 'precedence',
                'label' => lang('precedence_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('category_validation_number_label'), lang('precedence_label')),
                ],
            ],
            'parent_id' => [
                'field' => 'parent_id',
                'label' => lang('parent_label'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'is_natural' => sprintf(lang('category_validation_number_label'), lang('parent_label')),
                ],
            ],
            'published' => [
                'field' => 'published',
                'label' => lang('published_lable'),
                'rules' => 'trim|is_natural',
                'errors' => [
                    'required' => sprintf(lang('category_validation_label'), lang('published_lable')),
                    'is_natural' => sprintf(lang('category_validation_number_label'), lang('published_lable')),

                ],
            ],
        ];

        //set form input
        $this->data = [
            'title' => [
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control make_slug',
                'placeholder' => sprintf(lang('category_placeholder_label'), lang('title_label')),
                'oninvalid' => sprintf("this.setCustomValidity('%s')", sprintf(lang('category_placeholder_label'), lang('title_label'))),
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
            'precedence' => [
                'name' => 'precedence',
                'id' => 'precedence',
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
        $this->data = [];
        $this->data['title'] = lang('inding');

        $filter = [];

        //trường hợp không show dropdown thì get language session
        if (!is_show_select_language()) {
            $filter['language'] = $this->_site_lang;
        } else {
            $filter_language = $this->input->get('filter_language');
            $filter['language'] = (!empty($filter_language) && $filter_language != 'none') ? $filter_language : '';
        }

        //list
        $list = $this->CategoryManager->findAll($filter);

        $this->data['list'] = $list;

        $this->theme->load('list', $this->data);
    }

    public function create_table()
    {
        $this->CategoryManager->install();

        exit('done');
    }

    public function add()
    {
        $this->breadcrumb->add(lang('add_heading'), base_url('categories/manage/add'));

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
                'language'    => $this->input->post('language'),
                'precedence'  => $this->input->post('precedence'),
                'parent_id'   => $this->input->post('parent_id'),
                'published'   => isset($_POST['published']) ? true : false,
                'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
            ];

            if ($this->CategoryManager->create($additional_data)) {
                set_alert(lang('add_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL, 'refresh');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $list_category = $this->CategoryManager->findAll(['language' => $this->_site_lang]);
        $list_category = $this->_get_dropdown($list_category);

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['slug']['value']        = $this->form_validation->set_value('slug');
        $this->data['description']['value'] = $this->form_validation->set_value('description');
        $this->data['context']['value']     = $this->form_validation->set_value('context');
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence');
        $this->data['published']['value']   = $this->form_validation->set_value('published');
        $this->data['published']['checked'] = true;

        $this->data['parent_id']['options']  = $list_category;
        $this->data['parent_id']['selected'] = $this->form_validation->set_value('parent_id');

        $this->theme->load('add', $this->data);
    }

    public function edit($id = null)
    {
        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            show_error(lang('error_empty'));
        }

        $item_edit = $this->CategoryManager->findById($id);
        if (empty($item_edit)) {
            show_error(lang('error_empty'));
        }

        $this->breadcrumb->add(lang('edit_heading'), base_url('categories/manage/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                show_error(lang('error_token'));
            }

            if ($this->form_validation->run() === TRUE) {
                $additional_data = [
                    'title'       => $this->input->post('title'),
                    'slug'        => slugify($this->input->post('slug')),
                    'description' => $this->input->post('description'),
                    'context'     => $this->input->post('context'),
                    'language'    => $this->input->post('language'),
                    'precedence'  => $this->input->post('precedence'),
                    'parent_id'   => $this->input->post('parent_id'),
                    'published'   => isset($_POST['published']) ? true : false,
                    'language'    => isset($_POST['language']) ? $_POST['language'] : $this->_site_lang,
                ];

                if ($this->CategoryManager->create($additional_data, $id)) {
                    set_alert(lang('edit_success'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL, 'refresh');
                }
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        $list_category = $this->CategoryManager->findAll(['language' => $item_edit['language']]);
        $list_category = $this->_get_dropdown($list_category);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        $this->data['title']['value']       = $this->form_validation->set_value('title', $item_edit['title']);
        $this->data['slug']['value']        = $this->form_validation->set_value('slug', $item_edit['slug']);
        $this->data['description']['value'] = $this->form_validation->set_value('description', $item_edit['description']);
        $this->data['context']['value']     = $this->form_validation->set_value('context', $item_edit['context']);
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence', $item_edit['precedence']);
        $this->data['parent_id']['value']   = $this->form_validation->set_value('parent_id', $item_edit['parent_id']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = $item_edit['published'];

        $this->data['parent_id']['options']  = $list_category;
        $this->data['parent_id']['selected'] = $this->form_validation->set_value('parent_id', $item_edit['parent_id']);

        $this->theme->load('edit', $this->data);
    }

    public function delete($id = null)
    {
        $this->breadcrumb->add(lang('delete_heading'), base_url('categories/manage/delete'));
        $this->data['title_heading'] = lang('delete_heading');

        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $id = $this->input->post('delete_ids', true);
        }
        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        $ids = explode(',', $id);
        $list_delete = $this->CategoryManager->findListByIds($ids);

        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        }

        if (isset($_POST['ids']) && !empty($_POST['ids'])) {
            if (valid_token() === FALSE) {
                show_error(lang('error_token'));
            }
            try {
                $ids = explode(",", $this->input->post('ids', true));
                foreach($ids as $id){
                    $this->CategoryManager->delete($id);
                }
                set_alert(lang('edit_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL, 'refresh');
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
                redirect(self::MANAGE_URL, 'refresh');
            }


        }
        $this->data['csrf']      = create_token();
        $this->data['list_delete'] = $list_delete;
        $this->data['ids'] = implode(',', $ids);

        $this->theme->load('delete', $this->data);
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
        $item_edit = $this->CategoryManager->findById($id);
        if (empty($item_edit)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_empty')]);
            return;
        }

        $item_edit['published'] = isset($_POST['published']) ? $_POST['published'] : false;
        if (!$this->CategoryManager->create($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        echo json_encode($data);
        return;
    }

    public function api_get_categories()
    {
        header('content-type: application/json; charset=utf8');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (empty($_POST)) {
            echo json_encode(['status' => 'ng', 'msg' => lang('error_json')]);
            return;
        }

        $list_category = $this->CategoryManager->findAll(['language' => $this->input->post('language', true)]);

        $data = [
            'status' => 'ok',
            'msg'    => lang('reload_list_parent_success'),
            'list'   => $this->_get_dropdown($list_category)
        ];

        echo json_encode($data);
        return;
    }

    private function _get_dropdown($list_dropdown, $id_unset = null)
    {
        $list_tree = format_dropdown($list_dropdown);
        $dropdown  = empty($list_tree) ? [0 => lang('select_dropdown_lable')] : array_merge([0 => lang('select_dropdown_lable')], $list_tree);

        if (!empty($id_unset) && isset($dropdown[$id_unset])) {
            unset($dropdown[$id_unset]);
        }

        return $dropdown;
    }
}
