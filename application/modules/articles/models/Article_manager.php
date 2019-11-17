<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'article';
        $this->primary_key = 'article_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' => 'articles/Article_description_manager',
            'foreign_table' => 'article_description',
            'foreign_key'   => 'article_id',
            'local_key'     => 'article_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'articles/Article_description_manager',
            'foreign_table' => 'article_description',
            'foreign_key'   => 'article_id',
            'local_key'     => 'article_id',
        ];

        $this->has_many['relationship'] = [
            'foreign_model' => 'articles/Article_category_relationship_manager',
            'foreign_table' => 'article_category_relationship',
            'foreign_key'   => 'article_id',
            'local_key'     => 'article_id',
            'join' => true
        ];

        $this->fillable = [
            'article_id',
            'publish_date',
            'is_comment',
            'images',
            'categories',
            'tags',
            'author',
            'source',
            'sort_order',
            'user_id',
            'user_ip',
            'counter_view',
            'counter_comment',
            'counter_like',
            'published',
            'is_delete',
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

        if(empty($filter['is_delete'])) {
            $filter_root[] = ['is_delete', STATUS_OFF];
        }

        if (isset($filter['published']) && is_numeric($filter['published'])) {
            $filter_root[] = ['published', $filter['published']];
        }

        $filter_ids = [];
        if (!empty($filter['id'])) {
            $filter_ids = (is_array($filter['id'])) ? [$filter['id']] : explode(",", $filter['id']);
        }

        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter['name'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter_detail  = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter['name']);

        $relationship = null;
        if (!empty($filter['category'])) {
            $this->load->model("articles/Article_category_relationship_manager", 'Relationship');

            $category_ids     = is_array($filter['category']) ? $filter['category'] : explode(',', $filter['category']);
            $relationship_ids = $this->Relationship->where('category_id', $category_ids)->get_all();

            if (empty($relationship_ids) && empty($filter_ids)) {
                return [false, 0];
            }

            if (!empty($relationship_ids)) {
                $relationship_ids = array_column($relationship_ids, 'article_id');
            }

            $filter_ids = !empty($relationship_ids) ? array_merge($filter_ids, $relationship_ids) : $filter_ids;
        }

        if (!empty($filter_ids)) {
            $filter_root[] = ['article_id', $filter_ids];
        }

        if (!empty($filter_root)) {
            $this->where($filter_root);
        }

        $total = $this->count_rows();
        if (!empty($limit) && isset($offset)) {
            $this->limit($limit, $offset);
        }

        $order = empty($order) ? ['article_id' => 'DESC'] : $order;

        $this->order_by($order);
        $this->with_detail($filter_detail);

        $result = $this->get_all();
        if (empty($result)) {
            return [false, 0];
        }

        return [$result, $total];
    }

    public function get_list_full_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids            = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail  = sprintf('where:language_id=%d', get_lang_id());
        $result         = $this->where('article_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }
}
