<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserManager extends MY_Model
{
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
            'activation_selector',
            'activation_code',
            'forgotten_password_selector',
            'forgotten_password_code',
            'forgotten_password_time',
            'remember_selector',
            'remember_code',
            'created_on',
            'last_login',
            'active',
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

        $user_info = $this->get(['username' => $username, 'active'   => 1,]);
        if (empty($user_info)) {
            return FALSE;
        }

        if ($this->check_password($password, $user_info['password']) === FALSE) {
            return FALSE;
        }

        $session_data = [
            'user_name'      => $user_info['username'],
            'user_email'     => $user_info['email'],
            'user_id'        => $user_info['id'], //everyone likes to overwrite id so we'll use user_id
            'user_gender'    => $user_info['gender'],
            //'image'        => $user_info['image'],
            'old_last_login' => $user_info['last_login'],
            'last_login'     => time(),
        ];

        if ($is_check_admin) {
            $admin_group = config_item('admin_group');

            $this->load->model("users/GroupManager", 'Group');
            $this->load->model("users/UserGroupManager", 'UserGroup');

            $group_info = $this->Group->get(['name' => $admin_group]);
            if (empty($group_info)) {
                return FALSE;
            }

            $check_admin = $this->UserGroup->get(['user_id' => $user_info['id'], 'group_id' => $group_info['id']]);
            if(empty($check_admin)) {
                return FALSE;
            }

            $session_data['is_admin'] = TRUE;

            if (isset($user_info['super_admin']) && $user_info['super_admin'] == true) {
                $session_data['super_admin'] = TRUE;
            }
        }

        $this->session->set_userdata($session_data);

        $this->update(['last_login' => time()], $user_info['id']);

        //check remember login

        return TRUE;
    }

    protected function hash_password($password)
    {
        $hash_string = config_item('catcool_hash');

        // Make sure the session library is loaded
        if ( ! class_exists('CI_Encrypt', false)) {
            $this->load->library('encrypt');
        }

        return $this->encrypt->encode(md5($password . $hash_string));
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
        $password_db   = $this->encrypt->decode($password_db);
        $password_hash = md5($password . $hash_string);

        return $password_hash == $password_db;
    }
}
