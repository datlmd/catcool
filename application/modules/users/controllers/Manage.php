<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Admin_Controller
{
    public $errors = [];

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
        $this->load->model("users/User_group_manager", 'Group');
        $this->load->model("users/User_group_relationship_manager", 'User_group_relationship');
        $this->load->model("users/User_permission_relationship_manager", 'User_permission_relationship');
        $this->load->model("users/Auth_manager", 'Auth');
        $this->load->model("permissions/Permission_manager", 'Permission');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

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

        $data['list']   = $list;
        $data['paging'] = $this->get_paging_admin(base_url(self::MANAGE_URL), $total_records, $limit, $this->input->get('page'));


        theme_load('list', $data);
    }

    private function _load_asset()
    {
        //add datetimepicker
        add_style(css_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/tempusdominus-bootstrap-4', 'common'));
        prepend_script(js_url('vendor/datepicker/moment', 'common'));

        //add dropdrap
        add_style(css_url('js/dropzone/dropdrap', 'common'));
        $this->theme->add_js(js_url('js/dropzone/dropdrap', 'common'));

        //add lightbox
        add_style(css_url('js/lightbox/lightbox', 'common'));
        $this->theme->add_js(js_url('js/lightbox/lightbox', 'common'));

        add_style(css_url('vendor/bootstrap-select/css/bootstrap-select', 'common'));
        prepend_script(js_url('vendor/bootstrap-select/js/bootstrap-select', 'common'));
    }

    public function add()
    {
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permissin_add'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form() === TRUE) {
            $dob = $this->input->post('dob', true);
            if (!empty($dob)) {
                $dob = standar_date($dob);
            } else {
                $dob = '1990-01-01';
            }

            $username = strtolower($this->input->post('username', true));
            $avatar   = $this->input->post('avatar', true);
            if (!empty($avatar)) {
                $avatar_name = 'users/' . $username . '_ad.' . pathinfo($avatar, PATHINFO_EXTENSION);
                $avatar      = move_file_tmp($avatar, $avatar_name);
            }

            $add_data = [
                'username'   => $username,
                'email'      => strtolower($this->input->post('email', true)),
                'password'   =>  $this->Auth->hash_password($this->input->post('password', true)),
                'first_name' => $this->input->post('first_name', true),
                'company'    => $this->input->post('company', true),
                'phone'      => $this->input->post('phone', true),
                'address'    => $this->input->post('address', true),
                'dob'        => $dob,
                'gender'     => $this->input->post('gender', true),
                'image'      => $avatar,
                'active'     => isset($_POST['active']) ? true : false,
                'user_ip'    => get_client_ip(),
                'ctime'      => get_date(),
            ];

            if ($this->is_super_admin()) {
                $add_data['super_admin'] = (isset($_POST['super_admin'])) ? true : false;
            }

            $id = $this->Manager->insert($add_data);
            if (empty($id)) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/add');
            }

            $group_ids = $this->input->post('groups', true);
            if (!empty($group_ids)) {
                $list_group = $this->Group->where('id', $group_ids)->get_all();
                if (!empty($list_group)) {
                    foreach ($list_group as $group) {
                        $this->User_group_relationship->insert(['user_id' => $id, 'group_id' => $group['id']]);
                    }
                }
            }

            $permission_ids = $this->input->post('permissions', true);
            if (!empty($permission_ids)) {
                $list_permission = $this->Permission->where([['id', $permission_ids], ['published', STATUS_ON]])->get_all();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->User_permission_relationship->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('account_creation_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL);
        }

        $this->get_form();
    }

    protected function get_form($id = null)
    {
        $this->_load_asset();

        $data['list_lang'] = get_list_lang();

        list($list_group, $total)      = $this->Group->get_all_by_filter();
        $list_permission = $this->Permission->get_list_published();

        $data['groups']      = array_column($list_group, null, 'id');
        $data['permissions'] = $list_permission;

        //edit
        if (!empty($id) && is_numeric($id)) {
            $data['text_form']   = lang('text_edit');
            $data['text_submit'] = lang('button_save');

            $data_form = $this->Manager->where(['is_delete' => STATUS_OFF])->get($id);
            if (empty($data_form)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $data_form = format_data_lang_id($data_form);

            $data['user_groups']      = $this->User_group_relationship->get_all(['user_id' => $id]);
            $data['user_permissions'] = $this->User_permission_relationship->get_all(['user_id' => $id]);

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

        $data['is_super_admin'] = $this->is_super_admin();

        $this->breadcrumb->add($data['text_form'], base_url(self::MANAGE_URL));

        theme_load('form', $data);
    }

    protected function validate_form($id = null)
    {
        $this->form_validation->set_rules('first_name', lang('text_full_name'), 'required');
        $this->form_validation->set_rules('email', lang('text_email'), 'required');

        if (empty($id)) {
            $this->form_validation->set_rules('username', lang('text_username'), 'trim|required|is_unique[user.username]');
            $this->form_validation->set_rules('password', lang('text_password'), 'required|min_length[' . config_item('min_password_length') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', lang('text_password_confirm'), 'required');
        }

        $is_validation = $this->form_validation->run();
        $this->errors  = $this->form_validation->error_array();

        if (!empty($this->input->post('email'))) {
            if (!empty($this->input->post('id'))) {
                $email = $this->Manager->where(['email' => $this->input->post('email'), 'id !=' => $this->input->post('id')])->get_all();
            } else {
                $email = $this->Manager->where('email', $this->input->post('email'))->get_all();
            }
            if (!empty($email)) {
                $this->errors['email'] = lang('account_creation_duplicate_email');
            }
        }

        if (!empty($this->errors)) {
            return FALSE;
        }

        return $is_validation;
    }

    public function edit($id = null)
    {
        //phai full quyen hoac duoc cap nhat
        if (!$this->acl->check_acl()) {
            set_alert(lang('error_permission_edit'), ALERT_ERROR);
            redirect('permissions/not_allowed');
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (empty($id)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST) && $this->validate_form($id) === TRUE) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $item_edit = $this->Manager->where(['is_delete' => STATUS_OFF])->get($id);
            if (empty($item_edit)) {
                set_alert(lang('error_empty'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $dob = $this->input->post('dob', true);
            if (!empty($dob)) {
                $dob = standar_date($dob);
            } else {
                $dob = '1990-01-01';
            }

            $avatar = $this->input->post('avatar', true);
            if (!empty($avatar)) {
                $avatar_name = 'users/' . $item_edit['username'] . '_ad.' . pathinfo($avatar, PATHINFO_EXTENSION);
                $avatar      = move_file_tmp($avatar, $avatar_name);
            } else {
                $avatar = $this->input->post('avatar_root', true);
            }

            $edit_data = [
                'email'      => strtolower($this->input->post('email', true)),
                'first_name' => $this->input->post('first_name', true),
                'company'    => $this->input->post('company', true),
                'phone'      => $this->input->post('phone', true),
                'address'    => $this->input->post('address', true),
                'dob'        => $dob,
                'gender'     => $this->input->post('gender', true),
                'image'      => $avatar,
                'user_ip'    => get_client_ip(),
                'mtime'      => get_date(),
            ];

            if ($id != $this->get_user_id()) {
                $edit_data['active'] =isset($_POST['active']) ? true : false;
            }
            if ($this->is_super_admin()) {
                $edit_data['super_admin'] = (isset($_POST['super_admin'])) ? true : false;
            }

            if ($this->Manager->update($edit_data, $id) === FALSE) {
                set_alert(lang('error'), ALERT_ERROR);
                redirect(self::MANAGE_URL . '/edit/' . $id);
            }

            $this->User_group_relationship->force_delete(['user_id' => $id]);

            $group_ids  = $this->input->post('groups', true);
            if (!empty($group_ids)) {
                $list_group = $this->Group->where('id', $group_ids)->get_all();
                if (!empty($list_group)) {
                    foreach ($list_group as $group) {
                        $this->User_group_relationship->insert(['user_id' => $id, 'group_id' => $group['id']]);
                    }
                }
            }

            $this->User_permission_relationship->force_delete(['user_id' => $id]);

            $permission_ids  = $this->input->post('permissions', true);
            if (!empty($permission_ids)) {
                $list_permission = $this->Permission->where([['id', $permission_ids], ['published', STATUS_ON]])->get_all();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->User_permission_relationship->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('update_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/edit/' . $id);
        }

        $this->get_form($id);
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

        $item_edit = $this->Manager->where(['is_delete' => STATUS_OFF])->get($id);
        if (empty($item_edit)) {
            set_alert(lang('error_empty'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
        }

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if (valid_token() === FALSE || $id != $this->input->post('id')) {
                set_alert(lang('error_token'), ALERT_ERROR);
                redirect(self::MANAGE_URL);
            }

            $this->User_permission_relationship->force_delete(['user_id' => $id]);

            $permission_ids = $this->input->post('permissions', true);
            if (!empty($permission_ids)) {
                $list_permission = $this->Permission->where([['id', $permission_ids], ['published', STATUS_ON]])->get_all();
                if (!empty($list_permission)) {
                    foreach ($list_permission as $permission) {
                        $this->User_permission_relationship->insert(['user_id' => $id, 'permission_id' => $permission['id']]);
                    }
                }
            }

            set_alert(lang('update_permission_successful'), ALERT_SUCCESS);
            redirect(self::MANAGE_URL . '/permission/' . $id);
        }

        $data['csrf']             = create_token();
        $data['item_edit']        = $item_edit;
        $data['permissions']      = $this->Permission->get_list_published();
        $data['user_permissions'] = $this->User_permission_relationship->get_all($id);

        theme_load('permission', $data);
    }

    public function delete($id = null)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if (!$this->is_super_admin()) {
            set_alert(lang('error_permission_super_admin'), ALERT_ERROR);
            redirect(self::MANAGE_URL);
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

            $list_delete = $this->Manager->where('id', $ids)->get_all();
            if (empty($list_delete)) {
                json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
            }

            try {
                foreach($list_delete as $value) {
                    if ((!empty($value['super_admin']) && empty($this->is_super_admin())) || $value['id'] == $this->get_user_id()) {
                        continue;
                    }
                    $this->Manager->update(['is_delete' => STATUS_ON], $value['id']);
                }

                set_alert(lang('text_delete_success'), ALERT_SUCCESS);
            } catch (Exception $e) {
                set_alert($e->getMessage(), ALERT_ERROR);
            }

            json_output(['status' => 'redirect', 'url' => self::MANAGE_URL]);
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
        $list_delete = $this->Manager->where('id', $delete_ids)->get_all();
        if (empty($list_delete)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $list_undelete = [];
        foreach ($list_delete as $key => $value) {
            if ((!empty($value['super_admin']) && empty($this->is_super_admin())) || $value['id'] == $this->get_user_id()) {
                $list_undelete[] = $value;
                unset($list_delete[$key]);
            }
        }

        $data['csrf']          = create_token();
        $data['list_delete']   = $list_delete;
        $data['list_undelete'] = $list_undelete;
        $data['ids']           = $delete_ids;

        json_output(['data' => theme_view('delete', $data, true)]);
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
            $recheck = $this->Manager->login_remembered_user();
            if ($recheck !== FALSE) {
                redirect(get_last_url(CATCOOL_DASHBOARD));
            }
        }

        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', lang('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', lang('login_password_label')), 'required');
        $this->form_validation->set_rules('captcha', str_replace(':', '', lang('text_captcha')), 'required');

        if (isset($_POST) && !empty($_POST) && $this->form_validation->run() === TRUE)
        {
            if(!check_captcha($this->input->post('captcha'))) {
                $data['errors'] = lang('error_captcha');
            } else {
                $remember = (bool)$this->input->post('remember');
                if ($this->Manager->login($this->input->post('identity'), $this->input->post('password'), $remember, true)) {
                    set_alert(lang('login_successful'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                }

                $data['errors'] = empty($this->Manager->errors()) ? lang('login_unsuccessful') : $this->Manager->errors();
            }
        }

        if ($this->form_validation->error_array()) {
            $data['errors'] = $this->form_validation->error_array();
        }


        $data['image_captcha'] = print_captcha();
        $this->theme->layout('empty')->load('login', $data);
    }

    public function logout()
    {
        $data['title'] = "Logout";

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

        $id = $this->input->post('id');
        if ($id == $this->get_user_id()) {
            json_output(['status' => 'ng', 'msg' => lang('error_permission_owner')]);
        }

        $item_edit = $this->Manager->get($id);
        if (empty($item_edit)) {
            json_output(['status' => 'ng', 'msg' => lang('error_empty')]);
        }

        $item_edit['active'] = !empty($_POST['published']) ? STATUS_ON : STATUS_OFF;
        if (!$this->Manager->update($item_edit, $id)) {
            json_output(['status' => 'ng', 'msg' => lang('error_json')]);
        }

        if (!empty($_POST['published'])) {
            $data = ['status' => 'ok', 'msg' => lang('activate_successful')];
        } else {
            $data = ['status' => 'ok', 'msg' => lang('deactivate_successful')];
        }

        json_output($data);
    }
}
