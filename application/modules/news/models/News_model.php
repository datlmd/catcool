<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'core/MY_Farm.php');

class News_model extends MY_Farm
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'news_2021';
        $this->primary_key = 'news_id';

        $this->fillable = [
            'news_id',
            'name',
            'slug',
            'description',
            'content',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'language_id',
            'category_ids',
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
            'is_deleted',
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
        $filter['name LIKE'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';

        unset($filter['name']);

        $total = $this->count_rows($filter);

        $order = empty($order) ? ['news_id' => 'DESC'] : $order;

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

    public function get_list_full_detail($ids)
    {
        if (empty($ids)) {
            return false;
        }

        $ids            = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail  = sprintf('where:language_id=%d', get_lang_id());
        $result         = $this->where('news_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }

    public function get_list_published($filter = null, $limit = 0, $offset = 0, $order = null)
    {
        $filter_root = [['is_deleted', STATUS_OFF], ['published', STATUS_ON]];


        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter_detail = sprintf('where:language_id=%d', $filter['language_id']);

        $relationship = null;
        if (!empty($filter['category'])) {
            $this->load->model("news/News_category_relationship", 'Relationship');

            $category_ids     = is_array($filter['category']) ? $filter['category'] : explode(',', $filter['category']);
            $relationship_ids = $this->Relationship->where('category_id', $category_ids)->get_all();

            if (empty($relationship_ids) && empty($filter_ids)) {
                return [false, 0];
            }

            if (!empty($relationship_ids)) {
                $relationship_ids = array_column($relationship_ids, 'news_id');
            }

            $filter_ids = !empty($relationship_ids) ? array_merge($filter_ids, $relationship_ids) : $filter_ids;
        }

        if (!empty($filter_ids)) {
            $filter_root[] = ['news_id', $filter_ids];
        }

        $order = empty($order) ? ['publish_date' => 'DESC'] : $order;

        //neu filter name thi phan trang bang array
        if (empty($filter['name'])) {
            $total = $this->count_rows($filter_root);
            if (!empty($limit) && isset($offset)) {
                $this->limit($limit, $offset);
            }
        }

        $this->where($filter_root)->order_by($order)->with_detail($filter_detail);
        if (!empty($filter['category'])) {
            $this->with_relationship();
        }

        $result = $this->get_all();
        if (empty($result)) {
            return [false, 0];
        }

        //check neu get detail null
        foreach($result as $key => $val) {
            if (empty($val['detail'])) {
                unset($result[$key]);
                if (!empty($total)) $total--;
            }
        }

        //set lai total neu filter bang ten
        if (!empty($filter['name'])) {
            $total  = count($result);
            $result = array_slice($result, $offset, $limit);
        }

        return [$result, $total];
    }
}
