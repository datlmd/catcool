<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Layout_module extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'layout_module';
        $this->primary_key = 'layout_module_id';

        $this->fillable = [
            'layout_module_id',
            'layout_id',
            'code',
            'position',
            'sort_order'
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
        $filter['position LIKE'] = empty($filter['position']) ? '%%' : '%' . $filter['position'] . '%';
        unset($filter['position']);

        $total = $this->count_rows($filter);

        $order = !empty($order) ? $order : ['layout_module_id' => 'ASC'];

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
