<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_attribute extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_attribute";
        $this->primary_key = "product_id";

        $this->fillable = [
            "product_id",
            "attribute_id",
            "language_id",
            "text",
        ];
    }
}
