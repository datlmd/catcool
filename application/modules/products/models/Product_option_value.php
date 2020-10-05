<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_option_value extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_option_value";
        $this->primary_key = "product_option_value_id";

        $this->fillable = [
            "product_option_value_id",
            "product_option_id",
            "product_id",
            "option_id",
            "option_value_id",
            "quantity",
            "subtract",
            "price",
            "price_prefix",
            "points",
            "points_prefix",
            "weight",
            "weight_prefix",
        ];
    }
}
