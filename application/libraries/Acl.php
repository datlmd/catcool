<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Acl {
    private $name_permission;
    private $CI;
    public function __construct()
    {
        $this->CI = & get_instance();

        $this->CI->load->model("relationships/RelationshipManager", 'Relationship');
        $this->CI->load->model("permissions/PermissionManager", 'Permission');

        $this->name_permission = $this->CI->uri->uri_string();
    }

    public function check_acl ($user_id) {
        if (empty($user_id)) {
            return false;
        }

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
            return false;
        }

        return true;
    }
}
