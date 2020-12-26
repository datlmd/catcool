<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Currency extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db_table    = "currency";
        $this->primary_key = "currency_id";

        $this->fillable = [
            "currency_id",
            "name",
            "code",
            "symbol_left",
            "symbol_right",
            "decimal_place",
            "value",
            "published",
            "ctime",
            "mtime",
        ];
    }

    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        unset($filter['name']);

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['currency_id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['currency_id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }
}
