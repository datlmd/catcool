<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LanguageManager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'languages';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'name',
            'code',
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
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter['code LIKE'] = empty($filter['code']) ? '%%' : '%' . $filter['code'] . '%';

        unset($filter['name']);
        unset($filter['code']);

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

    public function get_list_by_publish($published = STATUS_ON)
    {
        if (empty($published)) {
            return false;
        }

        $return = $this->get_all(['published' => $published]);
        if (empty($return)) {
            return false;
        }

        return $return;
    }
}
