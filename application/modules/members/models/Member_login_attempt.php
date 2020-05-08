<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member_login_attempt extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'member_login_attempt';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'member_id',
            'login',
            'time'
        ];
    }
}
