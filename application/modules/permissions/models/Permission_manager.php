<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'permissions';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'name',
            'description',
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
            $result = $this->limit($limit,$offset)->order_by(['id' => 'DESC'])->get_all($filter);
        } else {
            $result = $this->order_by(['id' => 'DESC'])->get_all($filter);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_published()
    {
        $result = $this->get_all(['published' => STATUS_ON]);
        if (empty($result)) {
            return false;
        }

        return $result;
    }
}
