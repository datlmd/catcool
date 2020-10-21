<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Weight_class_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "weight_class_description";
        $this->primary_key = "weight_class_id";

        //khoa ngoai
        $this->has_one["root"] = [
            "foreign_model" => "products/Weight_class",
            "foreign_table" => "weight_class",
            "foreign_key"   => "weight_class_id",
            "local_key"     => "weight_class_id",
        ];

        $this->fillable = [
            "weight_class_id",
            "language_id",
            "name",
            "unit",
        ];
    }
}
