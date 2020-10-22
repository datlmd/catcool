<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Stock_status_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "stock_status_description";
        $this->primary_key = "stock_status_id";

        //khoa ngoai
        $this->has_one["root"] = [
            "foreign_model" => "products/Stock_status",
            "foreign_table" => "stock_status",
            "foreign_key"   => "stock_status_id",
            "local_key"     => "stock_status_id",
        ];

        $this->fillable = [
            "stock_status_id",
            "language_id",
            "name",
        ];
    }
}
