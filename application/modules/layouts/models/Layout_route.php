<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Layout_route extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'layout_route';
        $this->primary_key = 'layout_route_id';

        $this->fillable = [
            'layout_route_id',
            'layout_id',
            'store_id',
            'route',
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
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0, $order = null)
    {
        $filter['route LIKE'] = empty($filter['route']) ? '%%' : '%' . $filter['route'] . '%';
        unset($filter['route']);

        $total = $this->count_rows($filter);

        $order = !empty($order) ? $order : ['layout_route_id' => 'ASC'];

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by($order)->get_all($filter);
        } else {
            $result = $this->order_by($order)->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }
}
