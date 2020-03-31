<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'module';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'module',
            'sub_module',
            'user_id',
            'published',
            'ctime',
            'mtime',
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
        $filter_root = [];
        if (!empty($filter)) {
            $filter_root['module LIKE']     = empty($filter['module']) ? '%%' : '%' . $filter['module'] . '%';
            $filter_root['sub_module LIKE'] = empty($filter['sub_module']) ? '%%' : '%' . $filter['sub_module'] . '%';
        }

        $total = $this->count_rows($filter_root);
        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['id' => 'DESC'])->get_all($filter_root);
        } else {
            $result = $this->order_by(['id' => 'DESC'])->get_all($filter_root);
        }

        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_by_publish($published = STATUS_ON)
    {
        if (empty($published)) {
            return false;
        }

        $return = $this->order_by(['id' => 'DESC'])->get_all(['published' => $published]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
