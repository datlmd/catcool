<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_download_relationship extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_download_relationship";
        $this->primary_key = "product_id";

        $this->has_one['product'] = [
            'foreign_model' =>'products/Product',
            'foreign_table' =>'product',
            'foreign_key'   =>'product_id',
            'local_key'     =>'product_id',
        ];

        $this->has_one['download'] = [
            'foreign_model' =>'downloads/Download',
            'foreign_table' =>'download',
            'foreign_key'   =>'download_id',
            'local_key'     =>'download_id',
        ];

        $this->fillable = [
            "product_id",
            "download_id",
        ];
    }
}
