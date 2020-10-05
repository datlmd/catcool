<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_recurring extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_recurring";
        $this->primary_key = "product_id";

        $this->fillable = [
            "product_id",
            "recurring_id",
            "customer_group_id",
        ];
    }
}
