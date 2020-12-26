<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Dummy_group extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db_table    = "dummy_group";
        $this->primary_key = "dummy_id";

        $this->fillable = [
            "dummy_id",
            "name",
            "description",
            //FIELD_ROOT
        ];
    }

    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        unset($filter['name']);

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['dummy_id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['dummy_id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }
}
