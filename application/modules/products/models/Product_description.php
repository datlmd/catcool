<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Product_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "product_description";
        $this->primary_key = "product_id";

        //khoa ngoai
        $this->has_one["root"] = [
            "foreign_model" => "products/Product",
            "foreign_table" => "product",
            "foreign_key"   => "product_id",
            "local_key"     => "product_id",
        ];

        $this->fillable = [
            "product_id",
            "language_id",
            "name",
            "slug",
            "description",
            "tag",
            "meta_title",
            "meta_description",
            "meta_keyword",
        ];
    }
}
