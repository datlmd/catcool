<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Dummy_description extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = "dummy_description";
        $this->primary_key = "dummy_id";

        //khoa ngoai
        $this->has_one["root"] = [
            "foreign_model" => "dummy/Dummy",
            "foreign_table" => "dummy",
            "foreign_key"   => "dummy_id",
            "local_key"     => "dummy_id",
        ];

        $this->fillable = [
            "dummy_id",
            "language_id",
            "name",
            "description",
            //FIELD_DESCRIPTION
        ];
    }
}
