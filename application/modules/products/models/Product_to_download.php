<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_to_download extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_to_download";
        $this->primary_key = "product_id";

        $this->fillable = [
            "product_id",
            "download_id",
        ];
    }
}
