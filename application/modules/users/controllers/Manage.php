<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_NAME       = 'users';
    CONST MANAGE_URL        = self::MANAGE_NAME . '/manage';
    CONST MANAGE_PAGE_LIMIT = PAGINATION_DEFAULF_LIMIT;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('user', $this->_site_lang);

        //load model manage
        $this->load->model("users/UserManager", 'Manager');

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
                'username' => [
                    'field' => 'username',
                    'label' => lang('username_label'),
                    'rules' => 'trim',
                ],
                'password' => [
                    'field' => 'password',
                    'label' => lang('password_label'),
                    'rules' => 'trim',
                ],
                'email' => [
                    'field' => 'email',
                    'label' => lang('email_label'),
                    'rules' => 'trim',
                ],
                'activation_selector' => [
                    'field' => 'activation_selector',
                    'label' => lang('activation_selector_label'),
                    'rules' => 'trim',
                ],
                'activation_code' => [
                    'field' => 'activation_code',
                    'label' => lang('activation_code_label'),
                    'rules' => 'trim',
                ],
                'forgotten_password_selector' => [
                    'field' => 'forgotten_password_selector',
                    'label' => lang('forgotten_password_selector_label'),
                    'rules' => 'trim',
                ],
                'forgotten_password_code' => [
                    'field' => 'forgotten_password_code',
                    'label' => lang('forgotten_password_code_label'),
                    'rules' => 'trim',
                ],
                'forgotten_password_time' => [
                    'field' => 'forgotten_password_time',
                    'label' => lang('forgotten_password_time_label'),
                    'rules' => 'trim',
                ],
                'remember_selector' => [
                    'field' => 'remember_selector',
                    'label' => lang('remember_selector_label'),
                    'rules' => 'trim',
                ],
                'remember_code' => [
                    'field' => 'remember_code',
                    'label' => lang('remember_code_label'),
                    'rules' => 'trim',
                ],
                'created_on' => [
                    'field' => 'created_on',
                    'label' => lang('created_on_label'),
                    'rules' => 'trim',
                ],
                'last_login' => [
                    'field' => 'last_login',
                    'label' => lang('last_login_label'),
                    'rules' => 'trim',
                ],
                'active' => [
                    'field' => 'active',
                    'label' => lang('active_label'),
                    'rules' => 'trim',
                ],
                'first_name' => [
                    'field' => 'first_name',
                    'label' => lang('first_name_label'),
                    'rules' => 'trim',
                ],
                'last_name' => [
                    'field' => 'last_name',
                    'label' => lang('last_name_label'),
                    'rules' => 'trim',
                ],
                'company' => [
                    'field' => 'company',
                    'label' => lang('company_label'),
                    'rules' => 'trim',
                ],
                'phone' => [
                    'field' => 'phone',
                    'label' => lang('phone_label'),
                    'rules' => 'trim',
                ],
                'address' => [
                    'field' => 'address',
                    'label' => lang('address_label'),
                    'rules' => 'trim',
                ],
                'dob' => [
                    'field' => 'dob',
                    'label' => lang('dob_label'),
                    'rules' => 'trim',
                ],
                'gender' => [
                    'field' => 'gender',
                    'label' => lang('gender_label'),
                    'rules' => 'trim',
                ],
                'image' => [
                    'field' => 'image',
                    'label' => lang('image_label'),
                    'rules' => 'trim',
                ],
                'super_admin' => [
                    'field' => 'super_admin',
                    'label' => lang('super_admin_label'),
                    'rules' => 'trim',
                ],
                'status' => [
                    'field' => 'status',
                    'label' => lang('status_label'),
                    'rules' => 'trim',
                ],
                'is_delete' => [
                    'field' => 'is_delete',
                    'label' => lang('is_delete_label'),
                    'rules' => 'trim',
                ],
                'ip_address' => [
                    'field' => 'ip_address',
                    'label' => lang('ip_address_label'),
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
                'username' => [
                    'name' => 'username',
                    'id' => 'username',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'password' => [
                    'name' => 'password',
                    'id' => 'password',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'email' => [
                    'name' => 'email',
                    'id' => 'email',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'activation_selector' => [
                    'name' => 'activation_selector',
                    'id' => 'activation_selector',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'activation_code' => [
                    'name' => 'activation_code',
                    'id' => 'activation_code',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'forgotten_password_selector' => [
                    'name' => 'forgotten_password_selector',
                    'id' => 'forgotten_password_selector',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'forgotten_password_code' => [
                    'name' => 'forgotten_password_code',
                    'id' => 'forgotten_password_code',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'forgotten_password_time' => [
                    'name' => 'forgotten_password_time',
                    'id' => 'forgotten_password_time',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'remember_selector' => [
                    'name' => 'remember_selector',
                    'id' => 'remember_selector',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'remember_code' => [
                    'name' => 'remember_code',
                    'id' => 'remember_code',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'created_on' => [
                    'name' => 'created_on',
                    'id' => 'created_on',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'last_login' => [
                    'name' => 'last_login',
                    'id' => 'last_login',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'active' => [
                    'name' => 'active',
                    'id' => 'active',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'first_name' => [
                    'name' => 'first_name',
                    'id' => 'first_name',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'last_name' => [
                    'name' => 'last_name',
                    'id' => 'last_name',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'company' => [
                    'name' => 'company',
                    'id' => 'company',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'phone' => [
                    'name' => 'phone',
                    'id' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'address' => [
                    'name' => 'address',
                    'id' => 'address',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'dob' => [
                    'name' => 'dob',
                    'id' => 'dob',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'gender' => [
                    'name' => 'gender',
                    'id' => 'gender',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'image' => [
                    'name' => 'image',
                    'id' => 'image',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'super_admin' => [
                    'name' => 'super_admin',
                    'id' => 'super_admin',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'status' => [
                    'name' => 'status',
                    'id' => 'status',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'is_delete' => [
                    'name' => 'is_delete',
                    'id' => 'is_delete',
                    'type' => 'text',
                    'class' => 'form-control',
                ],
                'ip_address' => [
                    'name' => 'ip_address',
                    'id' => 'ip_address',
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
        //phai full quyen hoac duoc them moi
        if (!$this->ion_auth->in_group([PERMISSION_ADMIN_ALL, PERMISSION_ADMIN_ADD])) {
            set_alert(lang('error_permission_add'), ALERT_ERROR);
            redirect(self::MANAGE_URL, 'refresh');
        };

        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {
            $additional_data = [
                'title'       => $this->input->post('title', true),
                'description' => $this->input->post('description', true),
                'username' => $this->input->post('username', true),
                'password' => $this->input->post('password', true),
                'email' => $this->input->post('email', true),
                'activation_selector' => $this->input->post('activation_selector', true),
                'activation_code' => $this->input->post('activation_code', true),
                'forgotten_password_selector' => $this->input->post('forgotten_password_selector', true),
                'forgotten_password_code' => $this->input->post('forgotten_password_code', true),
                'forgotten_password_time' => $this->input->post('forgotten_password_time', true),
                'remember_selector' => $this->input->post('remember_selector', true),
                'remember_code' => $this->input->post('remember_code', true),
                'created_on' => $this->input->post('created_on', true),
                'last_login' => $this->input->post('last_login', true),
                'active' => $this->input->post('active', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'company' => $this->input->post('company', true),
                'phone' => $this->input->post('phone', true),
                'address' => $this->input->post('address', true),
                'dob' => $this->input->post('dob', true),
                'gender' => $this->input->post('gender', true),
                'image' => $this->input->post('image', true),
                'super_admin' => $this->input->post('super_admin', true),
                'status' => $this->input->post('status', true),
                'is_delete' => $this->input->post('is_delete', true),
                'ip_address' => $this->input->post('ip_address', true),
                'language'    => $this->input->post('language', true),
                'precedence'  => $this->input->post('precedence', true),
                'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
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

        $this->data['title']['value']       = $this->form_validation->set_value('title');
        $this->data['description']['value'] = $this->form_validation->set_value('description');
                $this->data['username']['value'] = $this->form_validation->set_value('username');
                $this->data['password']['value'] = $this->form_validation->set_value('password');
                $this->data['email']['value'] = $this->form_validation->set_value('email');
                $this->data['activation_selector']['value'] = $this->form_validation->set_value('activation_selector');
                $this->data['activation_code']['value'] = $this->form_validation->set_value('activation_code');
                $this->data['forgotten_password_selector']['value'] = $this->form_validation->set_value('forgotten_password_selector');
                $this->data['forgotten_password_code']['value'] = $this->form_validation->set_value('forgotten_password_code');
                $this->data['forgotten_password_time']['value'] = $this->form_validation->set_value('forgotten_password_time');
                $this->data['remember_selector']['value'] = $this->form_validation->set_value('remember_selector');
                $this->data['remember_code']['value'] = $this->form_validation->set_value('remember_code');
                $this->data['created_on']['value'] = $this->form_validation->set_value('created_on');
                $this->data['last_login']['value'] = $this->form_validation->set_value('last_login');
                $this->data['active']['value'] = $this->form_validation->set_value('active');
                $this->data['first_name']['value'] = $this->form_validation->set_value('first_name');
                $this->data['last_name']['value'] = $this->form_validation->set_value('last_name');
                $this->data['company']['value'] = $this->form_validation->set_value('company');
                $this->data['phone']['value'] = $this->form_validation->set_value('phone');
                $this->data['address']['value'] = $this->form_validation->set_value('address');
                $this->data['dob']['value'] = $this->form_validation->set_value('dob');
                $this->data['gender']['value'] = $this->form_validation->set_value('gender');
                $this->data['image']['value'] = $this->form_validation->set_value('image');
                $this->data['super_admin']['value'] = $this->form_validation->set_value('super_admin');
                $this->data['status']['value'] = $this->form_validation->set_value('status');
                $this->data['is_delete']['value'] = $this->form_validation->set_value('is_delete');
                $this->data['ip_address']['value'] = $this->form_validation->set_value('ip_address');
        $this->data['precedence']['value']  = 0;
        $this->data['published']['value']   = $this->form_validation->set_value('published', STATUS_ON);
        $this->data['published']['checked'] = true;

        $this->theme->load('manage/add', $this->data);
    }

    public function edit($id = null)
    {
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
                'username' => $this->input->post('username', true),
                'password' => $this->input->post('password', true),
                'email' => $this->input->post('email', true),
                'activation_selector' => $this->input->post('activation_selector', true),
                'activation_code' => $this->input->post('activation_code', true),
                'forgotten_password_selector' => $this->input->post('forgotten_password_selector', true),
                'forgotten_password_code' => $this->input->post('forgotten_password_code', true),
                'forgotten_password_time' => $this->input->post('forgotten_password_time', true),
                'remember_selector' => $this->input->post('remember_selector', true),
                'remember_code' => $this->input->post('remember_code', true),
                'created_on' => $this->input->post('created_on', true),
                'last_login' => $this->input->post('last_login', true),
                'active' => $this->input->post('active', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'company' => $this->input->post('company', true),
                'phone' => $this->input->post('phone', true),
                'address' => $this->input->post('address', true),
                'dob' => $this->input->post('dob', true),
                'gender' => $this->input->post('gender', true),
                'image' => $this->input->post('image', true),
                'super_admin' => $this->input->post('super_admin', true),
                'status' => $this->input->post('status', true),
                'is_delete' => $this->input->post('is_delete', true),
                'ip_address' => $this->input->post('ip_address', true),
                    'language'    => $this->input->post('language', true),
                    'precedence'  => $this->input->post('precedence', true),
                    'published'   => (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF,
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
                $this->data['username']['value'] = $this->form_validation->set_value('username', $item_edit['username']);
                $this->data['password']['value'] = $this->form_validation->set_value('password', $item_edit['password']);
                $this->data['email']['value'] = $this->form_validation->set_value('email', $item_edit['email']);
                $this->data['activation_selector']['value'] = $this->form_validation->set_value('activation_selector', $item_edit['activation_selector']);
                $this->data['activation_code']['value'] = $this->form_validation->set_value('activation_code', $item_edit['activation_code']);
                $this->data['forgotten_password_selector']['value'] = $this->form_validation->set_value('forgotten_password_selector', $item_edit['forgotten_password_selector']);
                $this->data['forgotten_password_code']['value'] = $this->form_validation->set_value('forgotten_password_code', $item_edit['forgotten_password_code']);
                $this->data['forgotten_password_time']['value'] = $this->form_validation->set_value('forgotten_password_time', $item_edit['forgotten_password_time']);
                $this->data['remember_selector']['value'] = $this->form_validation->set_value('remember_selector', $item_edit['remember_selector']);
                $this->data['remember_code']['value'] = $this->form_validation->set_value('remember_code', $item_edit['remember_code']);
                $this->data['created_on']['value'] = $this->form_validation->set_value('created_on', $item_edit['created_on']);
                $this->data['last_login']['value'] = $this->form_validation->set_value('last_login', $item_edit['last_login']);
                $this->data['active']['value'] = $this->form_validation->set_value('active', $item_edit['active']);
                $this->data['first_name']['value'] = $this->form_validation->set_value('first_name', $item_edit['first_name']);
                $this->data['last_name']['value'] = $this->form_validation->set_value('last_name', $item_edit['last_name']);
                $this->data['company']['value'] = $this->form_validation->set_value('company', $item_edit['company']);
                $this->data['phone']['value'] = $this->form_validation->set_value('phone', $item_edit['phone']);
                $this->data['address']['value'] = $this->form_validation->set_value('address', $item_edit['address']);
                $this->data['dob']['value'] = $this->form_validation->set_value('dob', $item_edit['dob']);
                $this->data['gender']['value'] = $this->form_validation->set_value('gender', $item_edit['gender']);
                $this->data['image']['value'] = $this->form_validation->set_value('image', $item_edit['image']);
                $this->data['super_admin']['value'] = $this->form_validation->set_value('super_admin', $item_edit['super_admin']);
                $this->data['status']['value'] = $this->form_validation->set_value('status', $item_edit['status']);
                $this->data['is_delete']['value'] = $this->form_validation->set_value('is_delete', $item_edit['is_delete']);
                $this->data['ip_address']['value'] = $this->form_validation->set_value('ip_address', $item_edit['ip_address']);
        $this->data['precedence']['value']  = $this->form_validation->set_value('precedence', $item_edit['precedence']);
        $this->data['published']['value']   = $this->form_validation->set_value('published', $item_edit['published']);
        $this->data['published']['checked'] = ($item_edit['published'] == STATUS_ON) ? true : false;

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

        $item_edit['published'] = (isset($_POST['published']) && $_POST['published'] == true) ? STATUS_ON : STATUS_OFF;
        if (!$this->Manager->create($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('modify_publish_success')];
        }

        echo json_encode($data);
        return;
    }

    /**
     * Log the user in
     */
    public function login()
    {
        if ($this->ion_auth->logged_in()) {
            redirect(base_url(CATCOOL_DASHBOARD), 'refresh');
        }

        $this->data['title'] = $this->lang->line('login_heading');

        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === TRUE)
        {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                //if the login is successful
                //redirect them back to the home page
                set_alert($this->ion_auth->messages(), ALERT_SUCCESS);

                $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value

                if ($redirect_url) {
                    $this->session->unset_userdata('redirect_back');
                    redirect($redirect_url);
                } else {
                    redirect(self::MANAGE_URL, 'refresh');
                }
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                set_alert($this->ion_auth->errors(), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

            $this->data['identity'] = [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'placeholder' => lang('login_identity_label'),
                'class' => 'form-control form-control-lg',
                'autocomplete' => 'off',
                'value' => $this->form_validation->set_value('identity'),
            ];

            $this->data['password'] = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'placeholder' => lang('login_password_label'),
                'class' => 'form-control form-control-lg',
            ];

            $this->theme->layout('empty')->load('manage/login', $this->data);
        }
    }

    /**
     * Log the user out
     */
    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $this->ion_auth->logout();

        // redirect them to the login page
        set_alert($this->ion_auth->messages(), ALERT_SUCCESS);
        redirect(self::MANAGE_URL . '/login', 'refresh');
    }
}
