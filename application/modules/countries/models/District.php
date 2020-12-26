<?php defined('BASEPATH') OR exit('No direct script access allowed');

class District extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table = 'country_district';
        $this->primary_key = 'district_id';
        $this->fillable = [
            'district_id',
            'province_id',
            'name',
            'type',
            'lati_long_tude',
            'sort_order',
            'published',
            'is_deleted',
        ];
    }

    /**
     * Get list all
     *
     * @param null $filter
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';

        unset($filter['name']);

        $filter['is_deleted'] = 0;

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['district_id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['district_id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_display($province_id)
    {
        if (empty($province_id)) {
            return false;
        }

        $where = [
            'published' => STATUS_ON,
            'is_deleted' => STATUS_OFF,
            'province_id' => $province_id,
        ];
        $return = $this->order_by(['sort_order' => 'ASC'])->get_all($where);
        if (empty($return)) {
            return false;
        }

        $district_list[0] = lang('text_select');
        foreach ($return as $key => $value) {
            $district_list[$value['district_id']] = $value['type'] . ' ' . $value['name'];
        }

        return $district_list;
    }
}
