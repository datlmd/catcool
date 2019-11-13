<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_category_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'article_category';
        $this->primary_key = 'category_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model'=>'articles/Article_category_description_manager',
            'foreign_table'=>'article_category_description',
            'foreign_key'=>'category_id',
            'local_key'=>'category_id',
        ];
        $this->has_many['details'] = [
            'foreign_model'=>'articles/Article_category_description_manager',
            'foreign_table'=>'article_category_description',
            'foreign_key'=>'category_id',
            'local_key'=>'category_id',
        ];
        //$this->has_many['article_category_descriptions'] = 'articles/Article_category_description_manager';

        $this->fillable = [
            'category_id',
            'parent_id',
            'image',
            'sort_order',
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
        if (isset($filter['is_admin']) && is_numeric($filter['is_admin'])) {
            $filter_root[] = ['is_admin', $filter['is_admin']];
        }

        if (!empty($filter['id'])) {
            $filter_root[] = ['category_id', (is_array($filter['id'])) ? $filter['id'] : explode(",", $filter['id'])];
        }

        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter['name'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter_str = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter['name']);

        $total = $this->with_detail($filter_str)->count_rows();

        if (!empty($limit) && isset($offset)) {
            //'fields:...|where:`phone_status`=\'active\''|order_inside:published_at desc'
            $result = $this->limit($limit,$offset)->order_by(['category_id' => 'DESC'])->with_detail($filter_str)->get_all();
        } else {
            $result = $this->order_by(['category_id' => 'DESC'])->with_detail($filter_str)->get_all();
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
        $result         = $this->where('category_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }
}
