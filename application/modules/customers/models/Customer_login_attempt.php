<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_login_attempt extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'customer_login_attempt';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'customer_id',
            'login',
            'time'
        ];
    }
}
