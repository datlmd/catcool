<?php defined('BASEPATH') OR exit('No direct script access allowed');

class State extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table = 'country_state';
        $this->primary_key = 'state_id';
        $this->fillable = [
            'state_id',
            'zone_id',
            'name',
            'code',
            'published',
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

        $total = $this->count_rows($filter);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['state_id' => 'ASC'])->get_all($filter);
        } else {
            $result = $this->order_by(['state_id' => 'ASC'])->get_all($filter);
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
