<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DummyManager extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db_table    = 'dummy';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'title',
            'description',
            'precedence',
            'published',
            'language',
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
        $filter['language LIKE'] = empty($filter['language']) ? '%%' : '%' . $filter['language'] . '%';
        $filter['title LIKE']    = empty($filter['title']) ? '%%' : '%' . $filter['title'] . '%';

        unset($filter['language']);
        unset($filter['title']);

        $total  = $this->count_rows($filter);

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
}
