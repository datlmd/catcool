<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Length_class_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "length_class_description";
        $this->primary_key = "length_class_id";

        //khoa ngoai
        $this->has_one["root"] = [
            "foreign_model" => "products/Length_class",
            "foreign_table" => "length_class",
            "foreign_key"   => "length_class_id",
            "local_key"     => "length_class_id",
        ];

        $this->fillable = [
            "length_class_id",
            "language_id",
            "name",
            "unit",
        ];
    }
}
