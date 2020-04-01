<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT       = 'users/manage';
    CONST MANAGE_URL        = 'users/manage';
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

        $this->lang->load('users_manage', $this->_site_lang);

        //load model manage
        $this->load->model("users/User_manager", 'Manager');
        $this->load->model("users/Group_manager", 'Group');
        $this->load->model("relationships/Relationship_manager", 'Relationship');
        $this->load->model("permissions/Permission_manager", 'Permission');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('heading_title'), base_url(self::MANAGE_URL));

        //check validation
        $this->config_form = [
            'username' => [
                'field' => 'username',
                'label' => lang('text_username'),
                'rules' => 'trim',
            ],
            'email' => [
                'field' => 'email',
                'label' => lang('create_user_email_label'),
                'rules' => 'trim',
            ],
            'password' => [
                'field' => 'password',
                'label' => lang('create_user_password_label'),
                'rules' => 'trim',
            ],
            'active' => [
                'field' => 'active',
                'label' => lang('text_active'),
                'rules' => 'trim',
            ],
            'first_name' => [
                'field' => 'first_name',
                'label' => lang('text_first_name'),
                'rules' => 'trim',
            ],
            'last_name' => [
                'field' => 'last_name',
                'label' => lang('text_last_name'),
                'rules' => 'trim',
            ],
            'company' => [
                'field' => 'company',
                'label' => lang('create_user_company_label'),
                'rules' => 'trim',
            ],
            'phone' => [
                'field' => 'phone',
                'label' => lang('create_user_phone_label'),
                'rules' => 'trim',
            ],
            'address' => [
                'field' => 'address',
                'label' => lang('text_address'),
                'rules' => 'trim',
            ],
            'dob' => [
                'field' => 'dob',
                'label' => lang('text_dob'),
                'rules' => 'trim',
            ],
            'gender' => [
                'field' => 'gender',
                'label' => lang('text_gender'),
                'rules' => 'trim',
            ],
            'image' => [
                'field' => 'image',
                'label' => lang('text_image'),
                'rules' => 'trim',
            ],
            'super_admin' => [
                'field' => 'super_admin',
                'label' => lang('text_super_admin'),
                'rules' => 'trim',
            ],
        ];

        //set form input
        $this->data = [
            'username' => [
                'name' => 'username',
                'id' => 'username',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'identity' => [
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'email' => [
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'class' => 'form-control',
            ],
            'password' => [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => lang('pass_text_title'),
            ],
            'password_confirm' => [
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => lang('text_confirm_password'),
            ],
            'first_name' => [
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => lang('text_first_name'),
            ],
            'last_name' => [
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => lang('text_last_name'),
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
                'type' => 'number',
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
            'super_admin' => [
                'name' => 'super_admin',
                'id' => 'super_admin',
                'type' => 'checkbox',
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
        $this->data['title'] = lang('heading_title');

        $filter = [];

        $filter_name  = $this->input->get('filter_name', true);
        $filter_limit = $this->input->get('filter_limit', true);

        if (!empty($filter_name)) {
            $filter['username'] = $filter_name;
            $filter['email']    = $filter_name;
            $filter['phone']    = $filter_name;
        }

        $limit       = empty($filter_limit) ? self::MANAGE_PAGE_LIMIT : $filter_limit;
        $start_index = (isset($_GET['page']) && is_numeric($_GET['page'])) ? ($_GET['page'] - 1) * $limit : 0;

        //list
        list($list, $total_records) = $this->Manager->get_all_by_filter($filter, $limit, $start_index);

        $this->data['list']   = $list;
        $this->data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $this->input->get('page'));

        theme_load('list', $this->data);
    }

    public function add()
    {
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permissin_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        //add datetimepicker
        add_style('assets/vendor/datepicker/tempusdominus-bootstrap-4');
        prepend_script('assets/vendor/datepicker/tempusdominus-bootstrap-4');
        prepend_script('assets/vendor/datepicker/moment');

        //add dropdrap
        add_style(css_url('js/dropzone/dropdrap', 'common'));
        $this->theme->add_js(js_url('js/dropzone/dropdrap', 'common'));

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        $this->breadcrumb->add(lang('add_heading'), base_url(self::MANAGE_URL . '/add'));

        $this->data['title_heading'] = lang('add_heading');

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if ($identity_column !== 'email') {
            $this->config_form['identity'] = [
                'field' => 'identity',
                'label' => lang('text_identity'),
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => lang('create_user_validation_identity_label'),
                ],
            ];
        }

        $this->config_form['email'] = [
            'field' => 'email',
            'label' => lang('text_username'),
            'rules' => 'required|valid_email|is_unique[' . $tables['users'] . '.email]',
            'errors' => [
                'required' => lang('create_user_validation_email_label'),
            ],
        ];
        $this->config_form['password'] = [
            'field' => 'password',
            'label' => lang('create_user_password_label'),
            'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]',
            'errors' => [
                'required' => lang('create_user_validation_password_label'),
            ],
        ];
        $this->config_form['password_confirm'] = [
            'field' => 'password_confirm',
            'label' => lang('create_user_password_label'),
            'rules' => 'required',
            'errors' => [
                'required' => lang('create_user_validation_password_confirm_label'),
            ],
        ];

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if ($this->form_validation->run() === TRUE) {

            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');

            $dob = $this->input->post('dob', true);
            if (!empty($dob)) {
                $dob = standar_date($dob);
            }

            $additional_data = [
                'username'       => $email,
                'email'          => strtolower($this->input->post('email', true)),
                $identity_column => $identity,
                'password'       =>  $this->Manager->hash_password($this->input->post('password', true)),
                'first_name'     => $this->input->post('first_name', true),
                'last_name'      => $this->input->post('last_name', true),
                'company'        => $this->input->post('company', true),
                'phone'          => $this->input->post('phone', true),
                'address'        => $this->input->post('address', true),
                'dob'            => $dob,
                'gender'         => $this->input->post('gender', true),
                'image'          => (!empty($_POST['file_upload'])) ? $_POST['file_upload'][0] : "",
                'super_admin'    => (isset($_POST['super_admin'])) ? true : false,
                'active'         => true,
                'ip_address'     => get_client_ip(),
            ];

            $id = $this->Manager->create($additional_data);
            if (!empty($id)) {
                $group_ids  = $this->input->post('groups', true);
                $list_group = $this->Group->get_list_by_ids($group_ids);
                if (!empty($group_ids) && empty($list_group)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }

                //add group
                foreach ($list_group as $group) {
                    $this->Manager->add_to_group($group['id'], $id);
                }

                $permission_ids = $this->input->post('permissions', true);
                $list_permission = $this->Permission->get_list_by_ids($permission_ids);
                if (!empty($permission_ids) && empty($list_permission)) {
                    set_alert(lang('error_empty'), ALERT_ERROR);
                    redirect(self::MANAGE_URL);
                }

                foreach ($list_permission as $permission) {
                    $data_relationship = [
                        'candidate_table' => 'users',
                        'candidate_key' => $id,
                        'foreign_table' => 'permissions',
                        'foreign_key' => $permission['id'],
                    ];
                    $this->Relationship->create($data_relationship);
                }

                set_alert($this->ion_auth->messages(), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            } else {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : null)), ALERT_ERROR);

        list($list_group, $total) = $this->Group->get_all_by_filter();
        $this->data['groups']     = $list_group;

        list($list_permission, $total) = $this->Permission->get_all_by_filter();
        $this->data['permissions'] = $list_permission;

        $this->data['username']['value']      = $this->form_validation->set_value('username');
        $this->data['password']['value']      = $this->form_validation->set_value('password');
        $this->data['email']['value']         = $this->form_validation->set_value('email');
        $this->data['first_name']['value']    = $this->form_validation->set_value('first_name');
        $this->data['last_name']['value']     = $this->form_validation->set_value('last_name');
        $this->data['company']['value']       = $this->form_validation->set_value('company');
        $this->data['phone']['value']         = $this->form_validation->set_value('phone');
        $this->data['address']['value']       = $this->form_validation->set_value('address');
        $this->data['dob']['value']           = $this->form_validation->set_value('dob');
        $this->data['gender']['value']        = $this->form_validation->set_value('gender');
        $this->data['super_admin']['value']   = $this->form_validation->set_value('super_admin', STATUS_OFF);
        $this->data['super_admin']['checked'] = false;

        theme_load('add', $this->data);
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        //add datetimepicker
        add_style('assets/vendor/datepicker/tempusdominus-bootstrap-4');
        prepend_script('assets/vendor/datepicker/tempusdominus-bootstrap-4');
        prepend_script('assets/vendor/datepicker/moment');

        //add dropdrap
        add_style(css_url('js/dropzone/dropdrap', 'common'));
        $this->theme->add_js(js_url('js/dropzone/dropdrap', 'common'));

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        $this->data['title_heading'] = lang('edit_heading');

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (!empty($item_edit['super_admin']) && !$this->ion_auth->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $user_groups = $this->Manager->get_users_groups($id)->result();

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        if (isset($_POST) && !empty($_POST) && $this->input->post('password')) {
            $this->config_form['password'] = [
                'field' => 'password',
                'label' => lang('create_user_password_label'),
                'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]',
                'errors' => [
                    'required' => lang('create_user_validation_password_label'),
                ],
            ];
            $this->config_form['password_confirm'] = [
                'field' => 'password_confirm',
                'label' => lang('create_user_password_label'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('create_user_validation_password_confirm_label'),
                ],
            ];
        }

        $this->config_form['email'] = [
            'field' => 'email',
            'label' => lang('text_username'),
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => lang('create_user_validation_email_label'),
            ],
        ];

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
//            if (valid_token() === FALSE || $id != $this->input->post('id')) {
//                set_alert(lang('error_token'), ALERT_ERROR);
//                redirect(self::MANAGE_URL);
//            }

            if ($this->form_validation->run() === TRUE) {

                $group_ids  = $this->input->post('groups', true);
                if (isset($group_ids) && !empty($group_ids)) {
                    $list_group = $this->Group->get_list_by_ids($group_ids);
                    if (!empty($group_ids) && empty($list_group)) {
                        set_alert(lang('error_empty'), ALERT_ERROR);
                        redirect(self::MANAGE_URL);
                    }

                    $this->Manager->remove_from_group('', $id);

                    //add group
                    foreach ($list_group as $group) {
                        $this->Manager->add_to_group($group['id'], $id);
                    }
                }

                $dob = $this->input->post('dob', true);
                if (!empty($dob)) {
                    $dob = standar_date($dob);
                }

                $additional_data['first_name']  = $this->input->post('first_name', true);
                $additional_data['last_name']   = $this->input->post('last_name', true);
                $additional_data['company']     = $this->input->post('company', true);
                $additional_data['phone']       = $this->input->post('phone', true);
                $additional_data['address']     = $this->input->post('address', true);
                $additional_data['dob']         = $dob;
                $additional_data['gender']      = $this->input->post('gender', true);
                $additional_data['image']       = (!empty($_POST['file_upload'])) ? $_POST['file_upload'][0] : "";
                $additional_data['super_admin'] = (isset($_POST['super_admin'])) ? true : false;
                $additional_data['ip_address']  = get_client_ip();

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $additional_data['password'] = $this->Manager->hash_password($this->input->post('password', true));
                }

                if ($this->Manager->create($additional_data, $id, $additional_data)) {
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

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        list($list_group, $total) = $this->Group->get_all_by_filter();
        $this->data['groups']     = $list_group;

        $this->data['user_groups'] = $user_groups;
        $this->data['image']       = $item_edit['image'];

        $this->data['username']['value']      = $this->form_validation->set_value('username', $item_edit['username']);
        $this->data['password']['value']      = $this->form_validation->set_value('password');
        $this->data['email']['value']         = $this->form_validation->set_value('email', $item_edit['email']);
        $this->data['first_name']['value']    = $this->form_validation->set_value('first_name', $item_edit['first_name']);
        $this->data['last_name']['value']     = $this->form_validation->set_value('last_name', $item_edit['last_name']);
        $this->data['company']['value']       = $this->form_validation->set_value('company', $item_edit['company']);
        $this->data['phone']['value']         = $this->form_validation->set_value('phone', $item_edit['phone']);
        $this->data['address']['value']       = $this->form_validation->set_value('address', $item_edit['address']);
        $this->data['dob']['value']           = $this->form_validation->set_value('dob', $item_edit['dob']);
        $this->data['gender']['value']        = $this->form_validation->set_value('gender', $item_edit['gender']);
        $this->data['super_admin']['value']   = $this->form_validation->set_value('super_admin', (bool)$item_edit['super_admin']);
        $this->data['super_admin']['checked'] = (bool)$item_edit['super_admin'];

        theme_load('edit', $this->data);
    }

    public function permission($id = null)
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

        $item_edit = $this->Manager->get_by_id($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (!empty($item_edit['super_admin']) && !$this->ion_auth->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }
        $user_permissions = $this->Relationship->get_candidate('users', 'permissions', $id);

        $this->breadcrumb->add(lang('edit_heading'), base_url(self::MANAGE_URL . '/edit/' . $id));

        //set rule form
        $this->form_validation->set_rules($this->config_form);

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
//            if (valid_token() === FALSE || $id != $this->input->post('id')) {
//                set_alert(lang('error_token'), ALERT_ERROR);
//                redirect(self::MANAGE_URL);
//            }

            if ($this->form_validation->run() === TRUE) {

                //set quyen module cho user
                $permission_ids = $this->input->post('permissions', true);
                if (isset($permission_ids) && !empty($permission_ids)) {
                    $list_permission = $this->Permission->get_list_by_ids($permission_ids);
                    if (!empty($permission_ids) && empty($list_permission)) {
                        set_alert(lang('error_empty'), ALERT_ERROR);
                        redirect(self::MANAGE_URL);
                    }

                    foreach ($user_permissions as $permission) {
                        $this->Relationship->delete($permission['id']);
                    }
                    foreach ($list_permission as $permission) {
                        $data_relationship = [
                            'candidate_table' => 'users',
                            'candidate_key' => $id,
                            'foreign_table' => 'permissions',
                            'foreign_key' => $permission['id'],
                        ];
                        $this->Relationship->create($data_relationship);
                    }
                }

                set_alert(lang('text_edit_success'), ALERT_SUCCESS);
                redirect(self::MANAGE_URL);
            }
        }

        // display the create user form
        // set the flash data error message if there is one
        set_alert((validation_errors() ? validation_errors() : null), ALERT_ERROR);

        // display the edit user form
        $this->data['csrf']      = create_token();
        $this->data['item_edit'] = $item_edit;

        list($list_permission, $total) = $this->Permission->get_all_by_filter();
        $this->data['permissions']     = $list_permission;

        $this->data['user_permissions']  = $user_permissions;
        $this->data['username']['value'] = $this->form_validation->set_value('username', $item_edit['username']);

        theme_load('manage/permission', $this->data);
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
//            if (valid_token() == FALSE) {
//                set_alert(lang('error_token'), ALERT_ERROR);
//                redirect(self::MANAGE_URL);
//            }

            $ids         = explode(",", $this->input->post('ids', true));
            $list_delete = $this->Manager->get_list_by_ids($ids);
            if (empty($list_delete)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            try {
                foreach($list_delete as $delete){
                    if ((!empty($delete['super_admin']) && !$this->ion_auth->is_super_admin()) || $delete['id'] == $this->ion_auth->get_user_id()) {
                        continue;
                    }
                    $this->Manager->remove($delete['id']);
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

        $list_delete = $this->Manager->get_list_by_ids($delete_ids);
        if (empty($list_delete)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && !$this->ion_auth->is_super_admin()) || $value['id'] == $this->ion_auth->get_user_id()) {
                $list_undelete[] = $value;
                unset($list_delete[$key]);
            }
        }

        $this->data['csrf']          = create_token();
        $this->data['list_delete']   = $list_delete;
        $this->data['list_undelete'] = $list_undelete;
        $this->data['ids']           = $delete_ids;

        theme_load('delete', $this->data);
    }

    /**
     * Log the user in
     */
    public function login()
    {
        if (!empty($this->session->userdata('user_id'))) {
            redirect(get_last_url(CATCOOL_DASHBOARD));
        } else {
            //neu da logout thi check auto login
            $recheck = $this->Manager->login_remembered_user(TRUE);
            if ($recheck !== FALSE) {
                redirect(get_last_url(CATCOOL_DASHBOARD));
            }
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

            if ($this->Manager->login($this->input->post('identity'), $this->input->post('password'), $remember, true))
            {
                //if the login is successful
                //redirect them back to the home page
                set_alert(lang('login_successful'), ALERT_SUCCESS);

                redirect(get_last_url(self::MANAGE_URL));
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                set_alert(lang('login_unsuccessful'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/login'); // use redirects instead of loading views for compatibility with MY_Controller libraries
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

            $this->theme->layout('empty')->load('login', $this->data);
        }
    }

    /**
     * Log the user out
     */
    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $this->Manager->logout();

        // redirect them to the login page
        set_alert(lang('logout_successful'), ALERT_SUCCESS);
        redirect(self::MANAGE_URL . '/login');
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
        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['published'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Manager->update($item_edit, $id)) {
            $data = ['status' => 'ng', 'msg' => lang('error_json')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('text_published_success')];
        }

        json_output($data);
    }
}
