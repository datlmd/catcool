<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_manager extends MY_Model
{
    protected $errors;

    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'user';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'username',
            'password',
            'email',
            'first_name',
            'last_name',
            'company',
            'phone',
            'address',
            'dob',
            'gender',
            'image',
            'super_admin',
            'status',
            'activation_selector',
            'activation_code',
            'forgotten_password_selector',
            'forgotten_password_code',
            'forgotten_password_time',
            'last_login',
            'active',
            'is_delete',
            'language',
            'user_ip',
            'ctime',
            'mtime'
        ];

        $this->load->model("users/Auth_manager", 'Auth');
    }

    /**
     * Get list all support tool
     *
     * @param null $filter
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['username LIKE'] = empty($filter['username']) ? '%%' : '%' . $filter['username'] . '%';
        $filter['email LIKE']    = empty($filter['email']) ? '%%' : '%' . $filter['email'] . '%';
        $filter['phone LIKE']    = empty($filter['phone']) ? '%%' : '%' . $filter['phone'] . '%';

        unset($filter['username']);
        unset($filter['email']);
        unset($filter['phone']);

        if(empty($filter['is_delete'])) {
            $filter['is_delete'] = STATUS_OFF;
        }

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['id' => 'DESC'])->get_all($filter);
        }
;
        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function remove($id, $is_trash = false)
    {
        if (empty($id)) {
            return false;
        }

        if ($is_trash == true) {
            $return = $this->delete($id);
        } else {
            $return = $this->update(['is_delete' => STATUS_ON], $id);
        }

        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function update_acitve($id, $active)
    {
        if (empty($id)) {
            return false;
        }

        $return = $this->update(['active' => $active], $id);
        if (empty($return)) {
            return false;
        }

        return $return;
    }

    public function login($username, $password, $remember = FALSE)
    {
        $this->errors = [];

        if (empty($username) || empty($password)) {
            $this->errors[] = lang('login_unsuccessful');
            return FALSE;
        }

        $user_info = $this->get([['username',$username], ['is_delete', 0]]);
        if (empty($user_info)) {
            $this->errors[] = lang('login_unsuccessful');

            return FALSE;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('login_unsuccessful_not_active');
            return FALSE;
        }

        if ($this->Auth->check_password($password, $user_info['password']) === FALSE) {
            $this->errors[] = lang('login_unsuccessful');
            return FALSE;
        }

        $this->Auth->set_session($user_info, true);

        $data_login = [];
        //check remember login
        if ($remember) {
            // Generate random tokens
            $token = $this->Auth->generate_selector_validator_couple();
            if (!empty($token['validator_hashed'])) {
                $this->Auth->set_cookie($token);

                $this->load->model("users/User_token_manager", 'User_token');
                $this->User_token->add_token($user_info['id'], $token);
            }
        }

        //xoa forgotten pass neu login thanh cong
        $data_login['forgotten_password_selector'] = NULL;
        $data_login['forgotten_password_code']     = NULL;
        $data_login['forgotten_password_time']     = NULL;
        $data_login['last_login']                  = time(); // last login

        $this->update($data_login, $user_info['id']);

        return TRUE;
    }

    public function login_remembered_user()
    {
        $this->errors = [];

        $this->load->model("users/User_token_manager", 'User_token');

        $remember_cookie = $this->Auth->get_cookie();
        $token           = $this->Auth->retrieve_selector_validator_couple($remember_cookie);
        if ($token === FALSE) {
            $this->errors[] = lang('login_unsuccessful');
            return FALSE;
        }

        $user_token = $this->User_token->get(['remember_selector' => $token['selector']]);
        if (empty($user_token)) {
            $this->errors[] = lang('login_unsuccessful');
            return FALSE;
        }

        $user_info = $this->get([['id', $user_token['user_id']], ['is_delete', 0]]);
        if (empty($user_info)) {
            $this->errors[] = lang('login_unsuccessful');
            return FALSE;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('login_unsuccessful_not_active');
            return FALSE;
        }

        if ($this->Auth->check_password($token['validator'], $user_token['remember_code']) === FALSE) {
            $this->errors[] = lang('login_unsuccessful');
            return FALSE;
        }

        $this->Auth->set_session($user_info, true);

        //xoa forgotten pass neu login thanh cong
        $data_login = [
            'forgotten_password_selector' => NULL,
            'forgotten_password_code'     => NULL,
            'forgotten_password_time'     => NULL,
            'last_login'                  => time(), // last login
        ];
        $this->update($data_login, $user_info['id']);

        return TRUE;
    }

    public function logout()
    {
        $user_id = $this->Auth->get_user_id();
        if (empty($user_id)) {
            return FALSE;
        }

        $remember_cookie = $this->Auth->get_cookie();
        $token           = $this->Auth->retrieve_selector_validator_couple($remember_cookie);

        $this->load->model("users/User_token_manager", 'User_token');
        $this->User_token->delete_token($token);

        $this->Auth->clear_session();
        $this->Auth->delete_cookie();

        // Clear all codes
        $data_logout = [
            'forgotten_password_selector' => NULL,
            'forgotten_password_code'     => NULL,
            'forgotten_password_time'     => NULL,
        ];

        $this->update($data_logout, $user_id);

        return TRUE;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function forgot_password($email)
    {
        if (empty($email)) {
            return FALSE;
        }

        $this->errors = [];

        $user_info = $this->where([['email', $email], ['username', '=', $email, true]] )->get();
        if (empty($user_info) || !empty($user_info['is_delete'])) {
            $this->errors[] = lang('text_email_not_found');
            return false;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('login_unsuccessful_not_active');
            return false;
        }

        // Generate random token: smaller size because it will be in the URL
        $token = $this->Auth->generate_selector_validator_couple(20, 80);
        if (empty($token)) {
            $this->errors[] = lang('error_generate_code');
            return false;
        }

        $update = [
            'forgotten_password_selector' => $token['selector'],
            'forgotten_password_code'     => $token['validator_hashed'],
            'forgotten_password_time'     => time()
        ];
        $id = $this->update($update, $user_info['id']);
        if (empty($id)) {
            return false;
        }

        $user_info['user_code'] = $token['user_code'];

        return $user_info;
    }
}
