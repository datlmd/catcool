<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Province extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table = 'country_province';
        $this->primary_key = 'province_id';
        $this->fillable = [
            'province_id',
            'country_id',
            'name',
            'type',
            'telephone_code',
            'zip_code',
            'country_code',
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
            $result = $this->limit($limit,$offset)->order_by(['province_id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['province_id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_display($country_id = null)
    {
        $where = [
            'published' => STATUS_ON,
            'is_deleted' => STATUS_OFF,
        ];

        if (!empty($country_id)) {
            $where['country_id'] = $country_id;
        }


        $return = $this->order_by(['sort_order' => 'ASC'])->get_all($where);
        if (empty($return)) {
            return false;
        }

        $province_list[0] = lang('text_select');
        foreach ($return as $key => $value) {
            $province_list[$value['province_id']] = $value['type'] . ' ' . $value['name'];
        }

        return $province_list;
    }
}
