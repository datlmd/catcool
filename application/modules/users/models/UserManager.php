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
     * Get list all
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
}
