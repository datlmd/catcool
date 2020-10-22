<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_category_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_category_relationship";
        $this->primary_key = "product_id";

        $this->has_one['product'] = [
            'foreign_model' =>'products/Product',
            'foreign_table' =>'product',
            'foreign_key'   =>'product_id',
            'local_key'     =>'product_id',
        ];

        $this->has_one['category'] = [
            'foreign_model' =>'categories/Category',
            'foreign_table' =>'category',
            'foreign_key'   =>'category_id',
            'local_key'     =>'category_id',
        ];

        $this->fillable = [
            "product_id",
            "category_id",
        ];
    }
}
