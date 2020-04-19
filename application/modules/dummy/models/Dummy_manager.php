<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Dummy_manager extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db_table    = "dummy";
        $this->primary_key = "dummy_id";

        //khoa ngoai
        $this->has_one["detail"] = [
            "foreign_model" => "dummy/Dummy_description_manager",
            "foreign_table" => "dummy_description",
            "foreign_key"   => "dummy_id",
            "local_key"     => "dummy_id",
        ];
        $this->has_many["details"] = [
            "foreign_model" => "dummy/Dummy_description_manager",
            "foreign_table" => "dummy_description",
            "foreign_key"   => "dummy_id",
            "local_key"     => "dummy_id",
        ];

        $this->fillable = [
            "dummy_id",
            "sort_order",
            "published",
            "ctime",
            "mtime",
            //FIELD_ROOT
        ];
    }

    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0, $order = null)
    {
        $filter_root = [];

        if (!empty($filter["id"])) {
            $filter_root[] = ["dummy_id", (is_array($filter["id"])) ? $filter["id"] : explode(",", $filter["id"])];
        }

        if (empty($filter["language_id"])) {
            $filter["language_id"] = get_lang_id();
        }

        if (empty($filter["name"])) {
            $filter_detail = sprintf("where:language_id=%d", $filter["language_id"]);
        } else {
            $filter_name   = "%" . $filter["name"] . "%";
            $filter_detail = sprintf("where:language_id=%d and name like \"%s\"", $filter["language_id"], $filter_name);
        }

        $order = empty($order) ? ["dummy_id" => "DESC"] : $order;

        //neu filter name thi phan trang bang array
        if (empty($filter["name"])) {
            $total = $this->count_rows($filter_root);
            if (!empty($limit) && isset($offset)) {
                $this->limit($limit, $offset);
            }
        }

        $result = $this->where($filter_root)->order_by($order)->with_detail($filter_detail)->get_all();
        if (empty($result)) {
            return [false, 0];
        }

        //check neu get detail null
        foreach($result as $key => $val) {
            if (empty($val["detail"])) {
                unset($result[$key]);
                if (!empty($total)) $total--;
            }
        }

        //set lai total neu filter bang ten
        if (!empty($filter["name"])) {
            $total  = count($result);
            $result = array_slice($result, $offset, $limit);
        }

        return [$result, $total];
    }

    public function get_list_full_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids           = is_array($ids) ? $ids : explode(",", $ids);
        $filter_detail = sprintf("where:language_id=%d", get_lang_id());
        $result        = $this->where("dummy_id", $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }
}
