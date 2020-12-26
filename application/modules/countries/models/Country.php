<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table = 'country';
        $this->primary_key = 'country_id';
        $this->fillable = [
            'country_id',
            'name',
            'formal_name',
            'country_code',
            'country_code3',
            'country_type',
            'country_sub_type',
            'sovereignty',
            'capital',
            'currency_code',
            'currency_name',
            'telephone_code',
            'country_number',
            'internet_country_code',
            'sort_order',
            'published',
            'flags',
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
            $result = $this->limit($limit,$offset)->order_by(['country_id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['country_id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_by_publish($published = STATUS_ON)
    {
        $return = $this->get_all(['published' => $published]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}