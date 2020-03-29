<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_album_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'photo_album';
        $this->primary_key = 'album_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' => 'photos/Photo_album_description_manager',
            'foreign_table' => 'photo_album_description',
            'foreign_key'   => 'album_id',
            'local_key'     => 'album_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'menus/Photo_album_description_manager',
            'foreign_table' => 'photo_album_description',
            'foreign_key'   => 'album_id',
            'local_key'     => 'album_id',
        ];

        $this->fillable = [
            'album_id',
            'image',
            'is_comment',
            'user_id',
            'user_ip',
            'sort_order',
            'published',
            'ctime',
            'mtime',
        ];
    }

    /**
     * Get all
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
            $filter_root[] = ['album_id', (is_array($filter['id'])) ? $filter['id'] : explode(",", $filter['id'])];
        }
        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter['name'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter_detail  = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter['name']);

        $order = empty($order) ? ['album_id' => 'DESC'] : $order;

        $total = $this->count_rows($filter_root);
        if (!empty($limit) && isset($offset)) {
            $this->limit($limit, $offset);
        }

        $this->where($filter_root)->order_by($order)->with_detail($filter_detail);
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

        $ids           = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail = sprintf('where:language_id=%d', get_lang_id());
        $result        = $this->where('album_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }
}
