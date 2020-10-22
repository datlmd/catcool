<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_layout_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_layout_relationship";
        $this->primary_key = "product_id";

        $this->has_one['product'] = [
            'foreign_model' =>'products/Product',
            'foreign_table' =>'product',
            'foreign_key'   =>'product_id',
            'local_key'     =>'product_id',
        ];

        $this->has_one['layout'] = [
            'foreign_model' =>'layouts/Layout',
            'foreign_table' =>'layout',
            'foreign_key'   =>'layout_id',
            'local_key'     =>'layout_id',
        ];

        $this->fillable = [
            "product_id",
            "store_id",
            "layout_id",
        ];
    }
}
