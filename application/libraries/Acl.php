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
            $this->CI->load->model("users/User_manager", 'User');

            $recheck = $this->CI->User->login_remembered_user(TRUE);
            if ($recheck === FALSE) {
                set_last_url();
                redirect('users/manage/login', 'refresh');
            }

            $user_id = $this->CI->session->userdata('user_id');
        }

        if(empty($this->CI->session->userdata('is_admin')) || $this->CI->session->userdata('is_admin') == false) {
            //chuyen sang trang frontend
            show_error('You must be an administrator to view this page.');
            return FALSE;
        }

        $is_super_admin = $this->CI->session->userdata('super_admin');
        if (!empty($is_super_admin) && $is_super_admin === TRUE) {
            return TRUE;
        }

        $this->CI->load->model("relationships/Relationship_manager", 'Relationship');
        $this->CI->load->model("permissions/Permission_manager", 'Permission');

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
