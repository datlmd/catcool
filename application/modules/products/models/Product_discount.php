<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_discount extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_discount";
        $this->primary_key = "product_discount_id";

        $this->fillable = [
            "product_discount_id",
            "product_id",
            "customer_group_id",
            "quantity",
            "priority",
            "price",
            "date_start",
            "date_end",
        ];
    }
}
