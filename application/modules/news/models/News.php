<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'news_2021';
        $this->primary_key = 'news_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' => 'news/News_description',
            'foreign_table' => 'news_description',
            'foreign_key'   => 'news_id',
            'local_key'     => 'news_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'news/News_description',
            'foreign_table' => 'news_description',
            'foreign_key'   => 'news_id',
            'local_key'     => 'news_id',
        ];

        $this->has_many['relationship'] = [
            'foreign_model' => 'news/News_category_relationship',
            'foreign_table' => 'news_category_relationship',
            'foreign_key'   => 'news_id',
            'local_key'     => 'news_id',
            'join' => true
        ];

        $this->fillable = [
            'news_id',
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
        $filter_root = [];

        if(empty($filter['is_deleted'])) {
            $filter_root[] = ['is_deleted', STATUS_OFF];
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

        if (empty($filter['name'])) {
            $filter_detail = sprintf('where:language_id=%d', $filter['language_id']);
        } else {
            $filter_name   = '%' . $filter['name'] . '%';
            $filter_detail = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter_name);
        }

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

        $order = empty($order) ? ['news_id' => 'DESC'] : $order;

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
