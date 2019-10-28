<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_manager extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'photos';
        $this->primary_key = 'id';

        $this->fillable = [
            'id',
            'title',
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

    /**
     * Get all
     *
     * @return bool
     */
    public function get_all_by_filter($filter = null, $limit = 0, $offset = 0)
    {
        $filter['title LIKE']    = empty($filter['title']) ? '%%' : '%' . $filter['title'] . '%';

        unset($filter['title']);

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

    public function get_phot_by_album($album_id, $order = null)
    {
        if (empty($album_id) || !is_numeric($album_id) || $album_id <= 0) {
            return [];
        }

        if (!empty($order)) {
            $result = $this->order_by($order)->get_all(['album_id' => $album_id]);
        } else {
            $result = $this->get_all(['album_id' => $album_id]);
        }

        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
