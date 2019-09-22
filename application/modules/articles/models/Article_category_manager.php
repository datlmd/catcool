<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_category_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'article_categories';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'title',
            'slug',
            'description',
            'context',
            'seo_title',
            'seo_description',
            'seo_keyword',
            'language',
            'precedence',
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
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['language LIKE'] = empty($filter['language']) ? '%%' : '%' . $filter['language'] . '%';
        $filter['title LIKE']    = empty($filter['title']) ? '%%' : '%' . $filter['title'] . '%';
        $filter['context LIKE']  = empty($filter['context']) ? '%%' : '%' . $filter['context'] . '%';

        unset($filter['language']);
        unset($filter['title']);
        unset($filter['context']);

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
}