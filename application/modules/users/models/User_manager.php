<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_manager extends MY_Model
{
    /**
     * Max cookie lifetime constant
     */
    const MAX_COOKIE_LIFETIME = 63072000; // 2 years = 60*60*24*365*2 = 63072000 seconds;

    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'users';
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
            'remember_selector',
            'remember_code',
            'last_login',
            'active',
            'is_delete',
            'language',
            'ip_address',
            'ctime',
            'mtime'
        ];
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

    public function login($username, $password, $remember = FALSE, $is_check_admin = FALSE)
    {
        if (empty($username) || empty($password)) {
            return FALSE;
        }

        $user_info = $this->get(['username' => $username, 'active' => 1,]);
        if (empty($user_info)) {
            return FALSE;
        }

        if ($this->check_password($password, $user_info['password']) === FALSE) {
            return FALSE;
        }

        $session_data = [
            'username'      => $user_info['username'],
            'user_email'     => $user_info['email'],
            'user_id'        => $user_info['id'], //everyone likes to overwrite id so we'll use user_id
            'user_gender'    => $user_info['gender'],
            //'image'        => $user_info['image'],
            'old_last_login' => $user_info['last_login'],
            'last_login'     => time(),
        ];
        if ($is_check_admin) {
            $session_data['is_admin'] = $this->is_admin_user_group($user_info['id']);
            if (isset($user_info['super_admin']) && $user_info['super_admin'] == true) {
                $session_data['super_admin'] = TRUE;
            }
        }
        $this->session->set_userdata($session_data);

        $data_login = [];
        //check remember login
        if ($remember) {
            // Generate random tokens
            $token = $this->_generate_selector_validator_couple();
            if (!empty($token['validator_hashed'])) {
                //set token login auto bang cookie
                $data_login['remember_selector'] = $token['selector'];
                $data_login['remember_code']     = $token['validator_hashed'];

                if(config_item('user_expire') === 0) {
                    $expire = self::MAX_COOKIE_LIFETIME;
                } else {// otherwise use what is set
                    $expire = config_item('user_expire');
                }
                $cookie_config = array(
                    'name' => config_item('remember_cookie_name'),
                    'value' => $token['user_code'],
                    'expire' => $expire,
                    'domain' => '',
                    'path' => '/',
                    'prefix' => '',
                    'secure' => FALSE
                );
                set_cookie($cookie_config);
            }
        } else {
            $data_login['remember_selector'] = NULL;
            $data_login['remember_code']     = NULL;
        }

        //xoa forgotten pass neu login thanh cong
        $data_login['forgotten_password_selector'] = NULL;
        $data_login['forgotten_password_code']     = NULL;
        $data_login['forgotten_password_time']     = NULL;
        $data_login['last_login']                  = time(); // last login

        $this->update($data_login, $user_info['id']);

        return TRUE;
    }

    public function login_remembered_user($is_check_admin = FALSE)
    {
        $remember_cookie = get_cookie(config_item('remember_cookie_name'));
        $token           = $this->_retrieve_selector_validator_couple($remember_cookie);

        if ($token === FALSE) {
            return FALSE;
        }

        $user_info = $this->get(['remember_selector' => $token['selector'], 'active' => 1]);
        if (empty($user_info)) {
            return FALSE;
        }

        if ($this->check_password($token['validator'], $user_info['remember_code']) === FALSE) {
            return FALSE;
        }

        $session_data = [
            'username'      => $user_info['username'],
            'user_email'     => $user_info['email'],
            'user_id'        => $user_info['id'], //everyone likes to overwrite id so we'll use user_id
            'user_gender'    => $user_info['gender'],
            //'image'        => $user_info['image'],
            'old_last_login' => $user_info['last_login'],
            'last_login'     => time(),
        ];
        if ($is_check_admin) {
            $session_data['is_admin'] = $this->is_admin_user_group($user_info['id']);
            if (isset($user_info['super_admin']) && $user_info['super_admin'] == true) {
                $session_data['super_admin'] = TRUE;
            }
        }
        $this->session->set_userdata($session_data);

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
        $user_id = $this->session->userdata('user_id');
        if (empty($user_id)) {
            return FALSE;
        }

        $this->session->unset_userdata(['username', 'user_id']);

        // delete the remember me cookies if they exist
        delete_cookie(config_item('remember_cookie_name'));

        // Destroy the session
        $this->session->sess_destroy();

        // Clear all codes
        $data_logout = [
            'forgotten_password_selector' => NULL,
            'forgotten_password_code'     => NULL,
            'forgotten_password_time'     => NULL,
            'remember_selector'           => NULL,
            'remember_code'               => NULL,
        ];

        $this->update($data_logout, $user_id);

        return TRUE;
    }

    /**
     * Kiem tra user co quyen admin khong
     *
     * @param $user_id
     * @return bool
     */
    public function is_admin_user_group($user_id)
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            return FALSE;
        }

        $admin_group = config_item('admin_group');

        $this->load->model("users/Group_manager", 'Group');
        $this->load->model("users/User_group_manager", 'User_group');

        $group_info = $this->Group->get(['name' => $admin_group]);
        if (empty($group_info)) {
            return FALSE;
        }

        $check_admin = $this->User_group->get(['user_id' => $user_id, 'group_id' => $group_info['id']]);
        if(empty($check_admin)) {
            return FALSE;
        }

        return TRUE;
    }

    protected function _generate_selector_validator_couple($selector_size = 40, $validator_size = 128)
    {
        // The selector is a simple token to retrieve the user
        $selector = $this->_random_token($selector_size);

        // The validator will strictly validate the user and should be more complex
        $validator = $this->_random_token($validator_size);

        // The validator is hashed for storing in DB (avoid session stealing in case of DB leaked)
        $validator_hashed = $this->hash_password($validator);

        // The code to be used user-side
        $user_code = "$selector.$validator";

        return [
            'selector' => $selector,
            'validator_hashed' => $validator_hashed,
            'user_code' => $user_code,
        ];
    }

    protected function _retrieve_selector_validator_couple($user_code)
    {
        // Check code
        if ($user_code)
        {
            $tokens = explode('.', $user_code);

            // Check tokens
            if (count($tokens) === 2) {
                return [
                    'selector' => $tokens[0],
                    'validator' => $tokens[1]
                ];
            }
        }

        return FALSE;
    }

    protected function _random_token($result_length = 32)
    {
        if(!isset($result_length) || intval($result_length) <= 8 ){
            $result_length = 32;
        }

        // Try random_bytes: PHP 7
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($result_length / 2));
        }

        // Try mcrypt
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($result_length / 2, MCRYPT_DEV_URANDOM));
        }

        // Try openssl
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($result_length / 2));
        }

        // No luck!
        return FALSE;
    }

    public function hash_password($password)
    {
        $hash_string = config_item('catcool_hash');

        // Make sure the session library is loaded
        if ( ! class_exists('CI_Encrypt', false)) {
            $this->load->library('encrypt');
        }

        return $this->encrypt->encode(md5($password . $hash_string));
    }

    public function get_hash_password($password)
    {
        if (empty($password)) {
            return FALSE;
        }

        // Make sure the session library is loaded
        if ( ! class_exists('CI_Encrypt', false)) {
            $this->load->library('encrypt');
        }

        return  $this->encrypt->decode($password);
    }

    public function check_password($password, $password_db)
    {
        if (empty($password) || empty($password_db)) {
            return FALSE;
        }

        // Make sure the session library is loaded
        if ( ! class_exists('CI_Encrypt', false)) {
            $this->load->library('encrypt');
        }

        $hash_string   = config_item('catcool_hash');
        $password_db   = $this->get_hash_password($password_db);
        $password_hash = md5($password . $hash_string);

        return $password_hash == $password_db;
    }
}
