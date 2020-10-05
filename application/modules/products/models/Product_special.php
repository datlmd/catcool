<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_special extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_special";
        $this->primary_key = "product_special_id";

        $this->fillable = [
            "product_special_id",
            "product_id",
            "customer_group_id",
            "priority",
            "price",
            "date_start",
            "date_end",
        ];
    }
}
