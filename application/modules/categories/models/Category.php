<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'category';
        $this->primary_key = 'category_id';

        $this->has_one['detail'] = [
            'foreign_model' => 'categories/Category_description',
            'foreign_table' => 'category_description',
            'foreign_key'   => 'category_id',
            'local_key'     => 'category_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'categories/Category_description',
            'foreign_table' => 'category_description',
            'foreign_key'   => 'category_id',
            'local_key'     => 'category_id',
        ];

        $this->fillable = [
            'category_id',
            'context',
            'image',
            'sort_order',
            'parent_id',
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
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0, $order = null)
    {
        $filter_root = [];
        if (!empty($filter['id'])) {
            $filter_root[] = ['category_id', (is_array($filter['id'])) ? $filter['id'] : explode(",", $filter['id'])];
        }

        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter['name'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter_detail  = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter['name']);

        $order = empty($order) ? ['sort_order' => 'DESC'] : $order;

        $total = $this->count_rows($filter_root);
        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit, $offset)->where($filter_root)->order_by($order)->with_detail($filter_detail)->get_all();
        } else {
            $result = $this->where($filter_root)->order_by($order)->with_detail($filter_detail)->get_all();
        }

        if (empty($result)) {
            return [false, 0];
        }
        $result = array_column($result, null, 'category_id');

        return [$result, $total];
    }

    public function get_list_full_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids            = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail  = sprintf('where:language_id=%d', get_lang_id());
        $result         = $this->where('category_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }
}
