<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl
{
    private $name_permission;
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();

        $this->name_permission = $this->CI->uri->uri_string();
    }

    public function check_acl()
    {
        $user_id = $this->CI->session->userdata('user_id');
        if(empty($user_id)) {
            //neu da logout thi check auto login
            $remember_cookie_name = get_cookie(config_item('remember_cookie_name'));
            if (!empty($remember_cookie_name)) {
                $this->CI->load->model("users/UserManager", 'User');

                $recheck = $this->CI->User->login_remembered_user(TRUE);
                if ($recheck === FALSE) {
                    redirect('users/manage/login', 'refresh');
                }

                $user_id = $this->CI->session->userdata('user_id');
            } else {
                redirect('users/manage/login', 'refresh');
            }
        }

        if(empty($this->CI->session->userdata('is_admin'))) {
            //chuyen sang trang frontend
            return FALSE;
        }

        $is_super_admin = $this->CI->session->userdata('super_admin');
        if (!empty($is_super_admin) && $is_super_admin === TRUE) {
            return TRUE;
        }

        $this->CI->load->model("relationships/RelationshipManager", 'Relationship');
        $this->CI->load->model("permissions/PermissionManager", 'Permission');

        $id_permission = 0;
        $permissions = $this->CI->Permission->get_list_published();
        foreach($permissions as $key => $val) {
            if (strpos($this->name_permission, $val['name']) !== false) {
                $id_permission = $val['id'];
                break;
            }
        }

        $relationship = $this->CI->Relationship->get_relationship('users', $user_id, 'permissions', $id_permission);
        if (empty($relationship)) {
            return FALSE;
        }

        return true;
    }
}
