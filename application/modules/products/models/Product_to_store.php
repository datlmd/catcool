<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_to_store extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_to_store";
        $this->primary_key = "product_id";

        $this->fillable = [
            "product_id",
            "store_id",
        ];
    }
}
