<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_option extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_option";
        $this->primary_key = "product_option_id";

        $this->fillable = [
            "product_option_id",
            "product_id",
            "option_id",
            "value",
            "required",
        ];
    }
}
