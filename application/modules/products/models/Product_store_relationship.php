<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_store_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_store_relationship";
        $this->primary_key = "product_id";

        $this->has_one['product'] = [
            'foreign_model' =>'products/Product',
            'foreign_table' =>'product',
            'foreign_key'   =>'product_id',
            'local_key'     =>'product_id',
        ];

        $this->has_one['store'] = [
            'foreign_model' =>'layouts/Store',
            'foreign_table' =>'store',
            'foreign_key'   =>'store_id',
            'local_key'     =>'store_id',
        ];

        $this->fillable = [
            "product_id",
            "store_id",
        ];
    }
}
