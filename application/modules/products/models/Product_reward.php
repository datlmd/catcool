<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_reward extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_reward";
        $this->primary_key = "product_reward_id";

        $this->fillable = [
            "product_reward_id",
            "product_id",
            "customer_group_id",
            "points"
        ];
    }
}
