<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_related extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_related";
        $this->primary_key = "product_id";

        $this->fillable = [
            "product_id",
            "related_id",
        ];
    }
}
