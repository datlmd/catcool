<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Model
{
    function __construct()
    {
        parent::__construct();

        $this->db_table    = 'menu';
        $this->primary_key = 'menu_id';

        //khoa ngoai
        $this->has_one['detail'] = [
            'foreign_model' => 'menus/Menu_description',
            'foreign_table' => 'menu_description',
            'foreign_key'   => 'menu_id',
            'local_key'     => 'menu_id',
        ];
        $this->has_many['details'] = [
            'foreign_model' => 'menus/Menu_description',
            'foreign_table' => 'menu_description',
            'foreign_key'   => 'menu_id',
            'local_key'     => 'menu_id',
        ];

        $this->fillable = [
            'menu_id',
            'slug',
            'icon',
            'context',
            'nav_key',
            'label',
            'attributes',
            'selected',
            'language',
            'sort_order',
            'user_id',
            'parent_id',
            'is_admin',
            'hidden',
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
        if (isset($filter['is_admin'])) {
            $filter_root[] = ['is_admin', $filter['is_admin']];
        }

        if (empty($filter['language_id'])) {
            $filter['language_id'] = get_lang_id();
        }

        $filter_detail  = sprintf('where:language_id=%d', $filter['language_id']);

        $total = $this->count_rows($filter_root);
        if (!empty($limit) && isset($offset)) {
            $result = $this->limit($limit,$offset)->order_by(['menu_id' => 'DESC'])->where($filter_root)->with_detail($filter_detail)->get_all();
        } else {
            $result = $this->order_by(['sort_order' => 'DESC'])->where($filter_root)->with_detail($filter_detail)->get_all();
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

        $ids           = is_array($ids) ? $ids : explode(',', $ids);
        $filter_detail = sprintf('where:language_id=%d', get_lang_id());
        $result        = $this->where('menu_id', $ids)->with_detail($filter_detail)->get_all();

        return $result;
    }

    public function get_menu_active($filter = null, $expire_tiem = 3600)
    {
        $cache_name = 'get_menu_cc';
        $filter['published'] = STATUS_ON;

        if (!empty($filter['is_admin'])) {
            $cache_name = 'admin_' . $cache_name;
        } else {
            $cache_name = (!empty($filter['context'])) ?  'frontend_' . $filter['context'] . '_' . $cache_name : 'frontend_' . $cache_name;
        }

        $this->load->driver('cache', ['adapter' => 'file', 'key_prefix' => '']);

        if ( !$result = $this->cache->get($cache_name)) {
            $result = $this->order_by(['sort_order' => 'DESC'])->where($filter)->with_detail('where:language_id=' . get_lang_id())->get_all();
            if (empty($result)) {
                return false;
            }

            // Save into the cache for 1hour
            $this->cache->save($cache_name, $result, $expire_tiem);
        }


        return $result;
    }
}
