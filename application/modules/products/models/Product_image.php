<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_image extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_image";
        $this->primary_key = "product_image_id";

        $this->fillable = [
            "product_image_id",
            "product_id",
            "image",
            "sort_order",
        ];
    }
}
