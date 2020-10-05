<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_to_layout extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_to_layout";
        $this->primary_key = "product_id";

        $this->fillable = [
            "product_id",
            "store_id",
            "layout_id",
        ];
    }
}
