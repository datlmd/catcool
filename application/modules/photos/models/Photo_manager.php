<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'photo';
        $this->primary_key = 'photo_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' => 'photos/Photo_description_manager',
            'foreign_table' => 'photo_description',
            'foreign_key'   => 'photo_id',
            'local_key'     => 'photo_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'photos/Photo_description_manager',
            'foreign_table' => 'photo_description',
            'foreign_key'   => 'photo_id',
            'local_key'     => 'photo_id',
        ];

        $this->fillable = [
            'photo_id',
            'image',
            'album_id',
            'is_comment',
            'tags',
            'user_id',
            'user_ip',
            'sort_order',
            'published',
            'ctime',
            'mtime',
        ];
    }

    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter_root = [];
        if (!empty($filter['id'])) {
            $filter_root[] = [$this->primary_key, (is_array($filter['id'])) ? $filter['id'] : explode(",", $filter['id'])];
        }
        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter['name'] = empty($filter['name']) ? '%%' : '%' . $filter['name'] . '%';
        $filter_detail  = sprintf('where:language_id=%d and name like \'%s\'', $filter['language_id'], $filter['name']);

        $total = $this->with_detail($filter_detail)->count_rows($filter_root);

        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by([$this->primary_key => 'DESC'])->where($filter_root)->with_detail($filter_detail);
        } else {
            $result = $this->order_by([$this->primary_key => 'DESC'])->where($filter_root)->with_detail($filter_detail);
        }

        $result = $result->get_all();
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
        $result        = $this->where('photo_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }

    public function get_photo_by_album($album_id, $order = null)
    {
        if (empty($album_id) || !is_numeric($album_id) || $album_id <= 0) {
            return false;
        }

        $filter_detail = sprintf('where:language_id=%d', get_lang_id());

        if (!empty($order)) {
            $result = $this->order_by($order)->where(['album_id' => $album_id])->with_detail($filter_detail)->get_all();
        } else {
            $result = $this->where(['album_id' => $album_id])->with_detail($filter_detail)->get_all();
        }

        if (empty($result)) {
            return false;
        }

        return $result;
    }
}
