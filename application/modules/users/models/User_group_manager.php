<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_group_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'users_groups';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'user_id',
            'group_id',
        ];
    }
}
